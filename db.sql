-- ==========================================
-- 1. ENUMERATIONS (TIPE DATA KHUSUS)
-- ==========================================

CREATE TYPE wallet_type AS ENUM ('TUNAI', 'BANK', 'DOMPET_DIGITAL');
CREATE TYPE fiat_tx_type AS ENUM ('PEMASUKAN', 'PENGELUARAN', 'TRANSFER');
CREATE TYPE asset_type AS ENUM ('KRIPTO', 'SAHAM', 'LOGAM_MULIA', 'PROPERTI', 'BISNIS', 'LAINNYA');
CREATE TYPE asset_tx_type AS ENUM ('BELI', 'JUAL', 'SALDO_AWAL');
CREATE TYPE valuation_source AS ENUM ('MANUAL', 'API');


-- ==========================================
-- 2. TABEL UTAMA (MASTER DATA & KAS)
-- ==========================================

-- TABEL: WALLETS (Dompet Kas / Fiat)
CREATE TABLE wallets (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    user_id UUID NOT NULL REFERENCES auth.users(id) ON DELETE CASCADE,
    name VARCHAR(255) NOT NULL,
    type wallet_type NOT NULL,
    currency VARCHAR(10) NOT NULL DEFAULT 'IDR',
    created_at TIMESTAMPTZ DEFAULT NOW(),
    updated_at TIMESTAMPTZ DEFAULT NOW()
);

-- TABEL: CATEGORIES (Kategori Transaksi Kas)
CREATE TABLE categories (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    user_id UUID NOT NULL REFERENCES auth.users(id) ON DELETE CASCADE,
    name VARCHAR(100) NOT NULL,
    type fiat_tx_type NOT NULL,
    created_at TIMESTAMPTZ DEFAULT NOW(),
    UNIQUE (user_id, name, type)
);

-- TABEL: FIAT_TRANSACTIONS (Arus Kas Masuk/Keluar)
CREATE TABLE fiat_transactions (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    user_id UUID NOT NULL REFERENCES auth.users(id) ON DELETE CASCADE,
    wallet_id UUID NOT NULL REFERENCES wallets(id) ON DELETE CASCADE,
    category_id UUID REFERENCES categories(id) ON DELETE SET NULL,
    transaction_type fiat_tx_type NOT NULL,
    amount DECIMAL(18, 2) NOT NULL CHECK (amount > 0),
    description TEXT,
    transaction_date TIMESTAMPTZ DEFAULT NOW(),
    created_at TIMESTAMPTZ DEFAULT NOW()
);

-- TABEL: ASSETS (Katalog Master Instrumen Investasi)
CREATE TABLE assets (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    name VARCHAR(255) NOT NULL,
    asset_type asset_type NOT NULL,
    ticker_symbol VARCHAR(50),
    unit_name VARCHAR(50) DEFAULT 'unit',
    price_source valuation_source DEFAULT 'MANUAL',
    created_at TIMESTAMPTZ DEFAULT NOW(),
    UNIQUE (asset_type, ticker_symbol)
);


-- ==========================================
-- 3. TABEL PORTOFOLIO & TRANSAKSI ASET
-- ==========================================

-- TABEL: USER_PORTFOLIOS (Kepemilikan Aset User)
CREATE TABLE user_portfolios (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    user_id UUID NOT NULL REFERENCES auth.users(id) ON DELETE CASCADE,
    asset_id UUID NOT NULL REFERENCES assets(id) ON DELETE CASCADE,
    total_units DECIMAL(18, 8) DEFAULT 0 CHECK (total_units >= 0),
    average_buy_price DECIMAL(18, 2) DEFAULT 0 CHECK (average_buy_price >= 0),
    opened_at TIMESTAMPTZ DEFAULT NOW(),
    closed_at TIMESTAMPTZ,
    created_at TIMESTAMPTZ DEFAULT NOW(),
    updated_at TIMESTAMPTZ DEFAULT NOW(),
    UNIQUE (user_id, asset_id)
);

-- TABEL: ASSET_TRANSACTIONS (Riwayat Beli/Jual Aset)
CREATE TABLE asset_transactions (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    user_id UUID NOT NULL REFERENCES auth.users(id) ON DELETE CASCADE,
    portfolio_id UUID NOT NULL REFERENCES user_portfolios(id) ON DELETE CASCADE,
    transaction_type asset_tx_type NOT NULL,
    units DECIMAL(18, 8) NOT NULL CHECK (units > 0),
    price_per_unit DECIMAL(18, 2) NOT NULL CHECK (price_per_unit >= 0),
    total_amount DECIMAL(18, 2) NOT NULL CHECK (total_amount >= 0),
    linked_fiat_transaction_id UUID REFERENCES fiat_transactions(id) ON DELETE SET NULL,
    notes TEXT,
    transaction_date TIMESTAMPTZ DEFAULT NOW(),
    created_at TIMESTAMPTZ DEFAULT NOW()
);

-- TABEL: ASSET_VALUATIONS (Histori Harga Pasar Aset)
CREATE TABLE asset_valuations (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    asset_id UUID NOT NULL REFERENCES assets(id) ON DELETE CASCADE,
    price_per_unit DECIMAL(18, 8) NOT NULL CHECK (price_per_unit >= 0),
    source valuation_source NOT NULL,
    recorded_at TIMESTAMPTZ DEFAULT NOW(),
    created_at TIMESTAMPTZ DEFAULT NOW(),
    UNIQUE (asset_id, recorded_at)
);


-- ==========================================
-- 4. DATABASE TRIGGERS (LOGIKA OTOMATIS)
-- ==========================================

-- FUNGSI: Menghitung ulang unit dan harga rata-rata (DCA) di portofolio
CREATE OR REPLACE FUNCTION update_portfolio_stats()
RETURNS TRIGGER AS $$
DECLARE
    current_units DECIMAL(18, 8);
    current_avg_price DECIMAL(18, 2);
    new_total_units DECIMAL(18, 8);
    new_avg_price DECIMAL(18, 2);
BEGIN
    -- Ambil data portofolio saat ini
    SELECT total_units, average_buy_price 
    INTO current_units, current_avg_price
    FROM user_portfolios WHERE id = NEW.portfolio_id;

    IF NEW.transaction_type IN ('BELI', 'SALDO_AWAL') THEN
        -- Kalkulasi unit baru (tambah)
        new_total_units := current_units + NEW.units;
        -- Kalkulasi Average Buy Price baru (Metode Weighted Average)
        IF new_total_units > 0 THEN
            new_avg_price := ((current_units * current_avg_price) + (NEW.units * NEW.price_per_unit)) / new_total_units;
        ELSE
            new_avg_price := 0;
        END IF;

    ELSIF NEW.transaction_type = 'JUAL' THEN
        -- Kalkulasi unit baru (kurang), harga rata-rata beli tetap
        new_total_units := current_units - NEW.units;
        new_avg_price := current_avg_price;
        
        -- Validasi agar unit tidak menjadi minus
        IF new_total_units < 0 THEN
            RAISE EXCEPTION 'Unit tidak cukup untuk melakukan penjualan.';
        END IF;
    END IF;

    -- Update tabel portofolio
    UPDATE user_portfolios
    SET total_units = new_total_units,
        average_buy_price = new_avg_price,
        updated_at = NOW()
    WHERE id = NEW.portfolio_id;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

-- TRIGGER: Jalankan fungsi di atas setiap ada transaksi aset baru
CREATE TRIGGER after_asset_transaction_insert
AFTER INSERT ON asset_transactions
FOR EACH ROW EXECUTE FUNCTION update_portfolio_stats();


-- ==========================================
-- 5. VIEWS (UNTUK MEMUDAHKAN QUERY API)
-- ==========================================

-- VIEW: WALLET BALANCES (Kalkulasi saldo akhir tiap dompet)
CREATE VIEW wallet_balances AS
SELECT
    w.id AS wallet_id,
    w.user_id,
    w.name,
    COALESCE(SUM(
        CASE
            WHEN ft.transaction_type = 'PEMASUKAN' THEN ft.amount
            WHEN ft.transaction_type = 'PENGELUARAN' THEN -ft.amount
            ELSE 0
        END
    ), 0) AS balance
FROM wallets w
LEFT JOIN fiat_transactions ft ON ft.wallet_id = w.id
GROUP BY w.id, w.user_id, w.name;

-- VIEW: LATEST ASSET PRICES (Mengambil harga pasar terbaru tiap aset)
CREATE VIEW latest_asset_prices AS
SELECT DISTINCT ON (asset_id)
    asset_id,
    price_per_unit,
    recorded_at
FROM asset_valuations
ORDER BY asset_id, recorded_at DESC;

-- VIEW: USER NET WORTH (Total nilai valuasi seluruh portofolio user)
CREATE VIEW user_net_worth AS
SELECT
    up.user_id,
    SUM(up.total_units * lap.price_per_unit) AS total_asset_value
FROM user_portfolios up
JOIN latest_asset_prices lap ON lap.asset_id = up.asset_id
GROUP BY up.user_id;


-- ==========================================
-- 6. INDEXES (UNTUK PERFORMA QUERY CEPAT)
-- ==========================================

CREATE INDEX idx_fiat_tx_user_date ON fiat_transactions(user_id, transaction_date DESC);
CREATE INDEX idx_asset_tx_portfolio_date ON asset_transactions(portfolio_id, transaction_date DESC);
CREATE INDEX idx_asset_valuations_asset_date ON asset_valuations(asset_id, recorded_at DESC);