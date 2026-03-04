Berikut adalah rincian fitur, menu, dan aktivitas yang dapat dilakukan di dalam sistem berdasarkan struktur *database* yang telah dirancang:

**1. Menu Dashboard (Ringkasan Keuangan)**

* **Melihat Kekayaan Bersih (Net Worth):** Pengguna dapat melihat total nilai kekayaan dari seluruh portofolio investasi yang dimiliki, yang dihitung berdasarkan harga pasar paling *update*.
* **Melihat Saldo Dompet:** Menampilkan ringkasan saldo terkini dari setiap dompet kas, rekening bank, maupun dompet digital.

**2. Menu Manajemen Kas & Dompet (Wallets)**

* **Membuat dan Mengelola Dompet:** Pengguna dapat menambahkan berbagai sumber dana yang dimiliki.
* **Kategorisasi Jenis Dompet:** Dompet dapat diklasifikasikan secara spesifik ke dalam tiga jenis: **Tunai** (uang fisik), **Bank** (rekening tabungan), dan **Dompet Digital** (seperti GoPay, OVO, dll).
* **Pengaturan Mata Uang:** Mendukung pengaturan mata uang dasar (default IDR) untuk masing-masing dompet.

**3. Menu Kategori Transaksi (Categories)**

* **Mengatur Pos Keuangan:** Pengguna bisa membuat label atau kategori khusus untuk merapikan pencatatan keuangannya (misal: "Gaji", "Makan Sehari-hari", "Langganan Netflix").
* **Pemilahan Tipe Arus Kas:** Kategori wajib diikat pada tipe arus kas tertentu, yaitu **Pemasukan**, **Pengeluaran**, atau **Transfer**.

**4. Menu Transaksi Keuangan (Arus Kas Fiat)**

* **Mencatat Pemasukan & Pengeluaran:** Pengguna dapat mencatat setiap uang yang masuk atau keluar dari dompet tertentu, melampirkan kategori, memasukkan nominal, dan memberikan catatan deskripsi.
* **Mencatat Transfer Antar Rekening:** Memungkinkan pemindahan uang antar dompet (misal dari Bank ke Dompet Digital) tanpa menganggapnya sebagai pengeluaran atau pendapatan murni.
* **Pelacakan Tanggal:** Setiap transaksi dapat diatur tanggal kejadiannya untuk keperluan riwayat keuangan (history).

**5. Menu Katalog Master Aset (Assets)**

* **Melihat Daftar Aset Investasi:** Berisi pangkalan data (katalog) seluruh instrumen investasi yang didukung oleh sistem.
* **Menambah Instrumen Baru:** Aset dikelompokkan menjadi **Kripto**, **Saham**, **Logam Mulia**, **Properti**, **Bisnis**, dan **Lainnya**. Pengguna juga bisa menyimpan simbol *ticker* (seperti BTC, BBCA) dan sebutan satuan unitnya (lot, gram, coin, dll).
* **Riwayat Harga Pasar (Valuations):** Terdapat fitur untuk memperbarui atau melacak pergerakan harga pasar dari suatu aset secara historis, baik di-update secara **Manual** oleh pengguna maupun ditarik secara otomatis via **API**.

**6. Menu Portofolio Investasi (User Portfolios)**

* **Pemantauan Aset Pribadi:** Pengguna dapat memantau daftar aset spesifik yang sedang mereka miliki.
* **Statistik Kepemilikan:** Menampilkan informasi krusial berupa total unit yang dimiliki saat ini dan **Harga Beli Rata-rata (Average Buy Price)**.
* **Otomatisasi DCA (Dollar Cost Averaging):** Pengguna tidak perlu menghitung ulang harga modal secara manual. Sistem (melalui *database trigger*) akan secara otomatis menghitung formula rata-rata harga setiap kali pengguna melakukan pembelian berulang pada aset yang sama.

**7. Menu Transaksi Aset (Asset Transactions)**

* **Beli dan Jual Aset:** Pengguna dapat mencatat riwayat transaksi untuk instrumen investasinya. Tersedia tipe transaksi **Beli**, **Jual**, atau input **Saldo Awal**.
* **Detail Kalkulasi Transaksi:** Saat bertransaksi, pengguna mencatat berapa unit yang dibeli/dijual dan harga per unitnya. Sistem juga memastikan bahwa saat menjual, unit pengguna tidak akan bisa bernilai minus (kurang dari yang dimiliki).
* **Integrasi ke Uang Kas (Linked Transaction):** Saat pengguna membeli aset (misalnya beli saham Rp1.000.000), transaksi tersebut dapat ditautkan langsung dengan catatan pengeluaran di dompet fiat. Sehingga, portofolio saham bertambah, dan saldo rekening bank otomatis berkurang di saat yang bersamaan.




Berikut adalah skenario perjalanan penggunanya dari hari pertama hingga pencairan profit investasi:

### Skenario 1: *Onboarding* & Inisialisasi Saldo (Hari Pertama)

1. **Registrasi & Login**: Aku mendaftar menggunakan email. Sistem (via Supabase Auth) menyimpan dataku di tabel `auth.users`, lalu aku diarahkan ke **Dashboard** yang saldonya masih Rp 0.
2. **Setup Dompet (Wallets)**: Aku masuk ke menu **Wallets** untuk memetakan tempat uangku berada. Aku membuat tiga dompet:
* "Rekening BCA" dengan tipe `BANK`.
* "GoPay" dengan tipe `DOMPET_DIGITAL`.
* "Dompet Fisik" dengan tipe `TUNAI`.


3. **Setup Kategori (Categories)**: Di menu **Categories**, aku membuat beberapa pos keuangan: "Fee Project Web" (tipe `PEMASUKAN`), "Makan Siang" (tipe `PENGELUARAN`), dan "Transport" (tipe `PENGELUARAN`).
4. **Input Saldo Awal**: Aku masuk ke menu **Fiat Transactions** dan mencatat Pemasukan sebesar Rp 5.000.000 ke "Rekening BCA" dan Rp 500.000 ke "GoPay" sebagai modal awal. Berkat *view* `wallet_balances` di *database*, angka di Dashboard-ku kini langsung menunjukkan total uang kas Rp 5.500.000.

### Skenario 2: Pencatatan Arus Kas Harian (Minggu Pertama)

1. **Pemasukan Baru**: Aku baru saja menyelesaikan migrasi *system* ke Laravel 10 untuk seorang klien dan menerima pembayaran. Aku mencatat Pemasukan Rp 3.000.000 ke "Rekening BCA" dengan kategori "Fee Project Web". Saldo BCA kini naik menjadi Rp 8.000.000.
2. **Transfer Antar Dompet**: Untuk persiapan jajan selama seminggu, aku memindahkan uang. Di menu **Fiat Transactions**, aku memilih transaksi `TRANSFER` dari dompet "Rekening BCA" ke "GoPay" sebesar Rp 300.000.
3. **Pengeluaran Harian**: Aku membeli kopi dan makan siang. Aku mencatat Pengeluaran Rp 50.000 di dompet "GoPay" dengan kategori "Makan Siang". Saldo GoPay otomatis berkurang secara *real-time*.

### Skenario 3: Memulai Investasi (Bulan Pertama)

1. **Melihat Katalog Aset**: Aku berniat menyisihkan uang untuk investasi. Di menu **Assets**, aku melihat daftar instrumen yang tersedia, misalnya saham "BBCA" (tipe `SAHAM`) dan kripto "BTC" (tipe `KRIPTO`).
2. **Beli Aset & Sinkronisasi Kas**: Aku memutuskan membeli saham BBCA. Aku masuk ke menu **Asset Transactions** dan memilih transaksi `BELI`.
* Aku membeli 10 lot (1000 unit) di harga Rp 10.000 per unit, total pengeluaran Rp 10.000.000.
* **Keajaiban Sistem**: Saat mengisi form, aku menautkan pembelian ini dengan dompet "Rekening BCA" (`linked_fiat_transaction_id`). Begitu aku klik *submit*, sistem otomatis membuat catatan pengeluaran di BCA sebesar Rp 10.000.000. Saldo bankku terpotong, namun portofolioku bertambah.


3. **Portofolio Terbentuk**: Di menu **User Portfolios**, kini muncul deretan aset BBCA milikku dengan total kepemilikan 1000 unit dan *Average Buy Price* di angka Rp 10.000.

### Skenario 4: Kekuatan *Dollar Cost Averaging* (Bulan Kedua)

1. **Membeli Aset yang Sama**: Bulan berikutnya, aku ingin menambah muatan saham BBCA (nabung rutin). Aku kembali masuk ke **Asset Transactions** dan membeli 500 unit lagi. Sayangnya, harga sedang naik menjadi Rp 11.000 per unit.
2. **Perhitungan Otomatis (Trigger Database)**: Aku tidak perlu mengambil kalkulator untuk menghitung harga rata-rata modalku. Begitu transaksi `BELI` tersimpan, *database trigger* `update_portfolio_stats()` langsung bekerja di latar belakang.
3. Saat aku membuka **User Portfolios**, total unitku sudah menjadi 1500, dan *Average Buy Price* otomatis bergeser menjadi sekitar Rp 10.333. Portofolioku tetap rapi tanpa pusing menghitung manual.

### Skenario 5: Update Harga Pasar & Panen Profit (Bulan Ketiga)

1. **Pembaruan Valuasi Aset**: Harga saham BBCA di pasar meroket ke Rp 12.000. Sistem mencatat harga baru ini di tabel `asset_valuations` (bisa lewat input manualku atau otomatis via API).
2. **Kekayaan Bersih Naik**: Saat aku membuka **Dashboard**, grafik *Net Worth* (berkat *view* `user_net_worth`) tiba-tiba melonjak naik karena sistem mengalikan 1500 unit sahamku dengan harga *latest* Rp 12.000.
3. **Jual Aset (Take Profit)**: Aku memutuskan untuk menjual 500 unit sahamku. Di menu **Asset Transactions**, aku pilih `JUAL` di harga Rp 12.000 dan menautkannya kembali ke dompet "Rekening BCA".
4. **Hasil Akhir**:
* Trigger *database* kembali bekerja: Unit sahamku di portofolio berkurang menjadi 1000 unit, namun *Average Buy Price* tetap terkunci di Rp 10.333 (tidak berubah karena ini transaksi jual).
* Saldo "Rekening BCA" milikku otomatis bertambah sebesar Rp 6.000.000 (hasil penjualan 500 unit x Rp 12.000).

