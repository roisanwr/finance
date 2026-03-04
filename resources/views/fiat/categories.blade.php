@extends('layouts.app')
@section('title', 'Kategori Transaksi')

@section('content')
<div class="mb-6 flex justify-between items-end mt-2 lg:mt-0">
    <div>
        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-1 transition-colors">Kategori Transaksi</h2>
        <p class="text-gray-500 dark:text-gray-400 text-sm transition-colors">Kelola label untuk merapikan pencatatan
            pemasukan, pengeluaran, dan transfer.</p>
    </div>

    <button onclick="openCategoryModal()"
        class="text-sm bg-indigo-600 dark:bg-indigo-500 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 dark:hover:bg-indigo-600 transition-colors font-medium flex items-center gap-2 shadow-sm shrink-0">
        <i data-lucide="plus" class="w-4 h-4"></i> Tambah Kategori
    </button>
</div>

<!-- Tabs Filter -->
<div class="mb-6 border-b border-gray-200 dark:border-gray-700 flex space-x-6">
    <button onclick="filterType('ALL', this)"
        class="tab-btn active pb-3 text-sm font-semibold text-indigo-600 dark:text-indigo-400 border-b-2 border-indigo-600 dark:border-indigo-400 transition-colors">Semua</button>
    <button onclick="filterType('PEMASUKAN', this)"
        class="tab-btn pb-3 text-sm font-medium text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 border-b-2 border-transparent transition-colors">Pemasukan</button>
    <button onclick="filterType('PENGELUARAN', this)"
        class="tab-btn pb-3 text-sm font-medium text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 border-b-2 border-transparent transition-colors">Pengeluaran</button>
    <button onclick="filterType('TRANSFER', this)"
        class="tab-btn pb-3 text-sm font-medium text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 border-b-2 border-transparent transition-colors">Transfer</button>
</div>

<!-- Container Card untuk Kategori -->
<div class="bg-white dark:bg-gray-800 sudut-custom border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
    <div id="categories-container" class="flex flex-wrap gap-3">
        <!-- Skeleton loader -->
        <div class="bg-gray-200 dark:bg-gray-700 animate-pulse h-10 w-24 rounded-full"></div>
        <div class="bg-gray-200 dark:bg-gray-700 animate-pulse h-10 w-32 rounded-full"></div>
        <div class="bg-gray-200 dark:bg-gray-700 animate-pulse h-10 w-28 rounded-full"></div>
    </div>
</div>

@push('modals')
<!-- Modal Form Kategori -->
<div id="categoryModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 z-[60] hidden flex items-center justify-center">
    <div
        class="bg-white dark:bg-gray-800 sudut-custom p-6 w-full max-w-sm shadow-xl border border-gray-200 dark:border-gray-700 relative overflow-hidden">
        <div class="flex justify-between items-center mb-5">
            <h3 class="font-bold text-lg text-gray-900 dark:text-white" id="modalTitle">Tambah Kategori</h3>
            <button onclick="closeCategoryModal()"
                class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form id="categoryForm" onsubmit="submitCategoryForm(event)">
            <input type="hidden" id="category_id" name="id">

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Kategori</label>
                <input type="text" id="category_name" name="name" required placeholder="Cth: Gaji, Makan, Listrik"
                    class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-2 px-3">
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tipe Arus Kas</label>
                <select id="category_type" name="type" required
                    class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-2 px-3">
                    <option value="PEMASUKAN">Pemasukan</option>
                    <option value="PENGELUARAN">Pengeluaran</option>
                    <option value="TRANSFER">Transfer</option>
                </select>
            </div>

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeCategoryModal()"
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600">Batal</button>
                <button type="submit" id="btnSubmit"
                    class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 flex items-center">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endpush

@endsection

@push('scripts')
<script>
    const headers = {
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
        'Accept': 'application/json',
        'Content-Type': 'application/json'
    };

    let allCategories = [];
    let currentFilter = 'ALL';

    document.addEventListener("DOMContentLoaded", fetchCategories);

    function fetchCategories() {
        fetch('/api/categories', { headers })
            .then(res => res.json())
            .then(data => {
                allCategories = data;
                renderCategories();
            })
            .catch(error => {
                console.error('Error fetching categories:', error);
                showToast('Gagal memuat daftar kategori.', 'error');
                document.getElementById('categories-container').innerHTML = '';
            });
    }

    function filterType(type, btnElement) {
        currentFilter = type;

        // Update styling tab aktif
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('active', 'text-indigo-600', 'dark:text-indigo-400', 'border-indigo-600', 'dark:border-indigo-400', 'font-semibold');
            btn.classList.add('text-gray-500', 'dark:text-gray-400', 'border-transparent', 'font-medium');
        });

        btnElement.classList.remove('text-gray-500', 'dark:text-gray-400', 'border-transparent', 'font-medium');
        btnElement.classList.add('active', 'text-indigo-600', 'dark:text-indigo-400', 'border-indigo-600', 'dark:border-indigo-400', 'font-semibold');

        renderCategories();
    }

    function renderCategories() {
        const container = document.getElementById('categories-container');
        container.innerHTML = '';

        let filtered = allCategories;
        if (currentFilter !== 'ALL') {
            filtered = allCategories.filter(c => c.type === currentFilter);
        }

        if (filtered.length === 0) {
            container.innerHTML = `
                <div class="w-full text-center py-6 text-gray-500 dark:text-gray-400">
                    <i data-lucide="inbox" class="w-10 h-10 mx-auto mb-2 text-gray-400 dark:text-gray-500"></i>
                    <p>Belum ada kategori untuk filter ini.</p>
                </div>
            `;
            lucide.createIcons();
            return;
        }

        filtered.forEach(category => {
            let colorClass = 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 border-gray-200 dark:border-gray-600';
            let icon = 'tag';

            if (category.type === 'PEMASUKAN') {
                colorClass = 'bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 border-emerald-200 dark:border-emerald-800/50 hover:border-emerald-300 dark:hover:border-emerald-600';
                icon = 'arrow-down-left';
            } else if (category.type === 'PENGELUARAN') {
                colorClass = 'bg-rose-50 dark:bg-rose-900/30 text-rose-700 dark:text-rose-400 border-rose-200 dark:border-rose-800/50 hover:border-rose-300 dark:hover:border-rose-600';
                icon = 'arrow-up-right';
            } else if (category.type === 'TRANSFER') {
                colorClass = 'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 border-blue-200 dark:border-blue-800/50 hover:border-blue-300 dark:hover:border-blue-600';
                icon = 'arrow-left-right';
            }

            const pill = document.createElement('div');
            pill.className = `group flex items-center gap-2 pl-3 pr-2 py-1.5 rounded-full border shadow-sm transition-all focus-within:ring-2 focus-within:ring-indigo-500 ${colorClass}`;

            pill.innerHTML = `
                <i data-lucide="${icon}" class="w-3.5 h-3.5 opacity-70"></i>
                <span class="font-medium text-sm mr-1">${category.name}</span>
                <div class="flex items-center opacity-0 scale-95 group-hover:opacity-100 group-hover:scale-100 transition-all">
                    <button onclick="editCategory('${category.id}', '${category.name.replace(/'/g, "\\'")}', '${category.type}')" 
                        class="p-1 min-w-[24px] rounded-full hover:bg-black/10 dark:hover:bg-white/10 transition-colors" title="Edit">
                        <i data-lucide="edit-2" class="w-3.5 h-3.5"></i>
                    </button>
                    <button onclick="deleteCategory('${category.id}')" 
                        class="p-1 min-w-[24px] rounded-full hover:bg-black/10 dark:hover:bg-red-500/20 text-rose-600 dark:text-rose-400 transition-colors" title="Hapus">
                        <i data-lucide="x" class="w-3.5 h-3.5"></i>
                    </button>
                </div>
            `;
            container.appendChild(pill);
        });

        lucide.createIcons();
    }

    function openCategoryModal() {
        document.getElementById('modalTitle').innerText = 'Tambah Kategori';
        document.getElementById('categoryForm').reset();
        document.getElementById('category_id').value = '';

        // Sesuaikan pilihan dropdown dengan filter aktif
        if (currentFilter !== 'ALL') {
            document.getElementById('category_type').value = currentFilter;
        }

        document.getElementById('categoryModal').classList.remove('hidden');
    }

    function closeCategoryModal() {
        document.getElementById('categoryModal').classList.add('hidden');
    }

    // Edit dipanggil saat klik tombol pencil
    window.editCategory = function (id, name, type) {
        document.getElementById('modalTitle').innerText = 'Edit Kategori';
        document.getElementById('category_id').value = id;
        document.getElementById('category_name').value = name;
        document.getElementById('category_type').value = type;
        document.getElementById('categoryModal').classList.remove('hidden');
    }

    function submitCategoryForm(e) {
        e.preventDefault();
        const id = document.getElementById('category_id').value;
        const name = document.getElementById('category_name').value;
        const type = document.getElementById('category_type').value;

        const btn = document.getElementById('btnSubmit');
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i data-lucide="loader-2" class="w-4 h-4 animate-spin mr-2"></i>y...';
        btn.disabled = true;
        lucide.createIcons();

        const url = id ? `/api/categories/${id}` : '/api/categories';
        const method = id ? 'PUT' : 'POST';

        fetch(url, {
            method: method,
            headers: headers,
            body: JSON.stringify({ name, type })
        })
            .then(async res => {
                const data = await res.json();
                if (!res.ok) throw new Error(data.message || 'Gagal menyimpan kategori');
                return data;
            })
            .then(data => {
                if (data.success) {
                    closeCategoryModal();
                    fetchCategories();
                    showToast(id ? 'Kategori diperbarui.' : 'Kategori ditambahkan!', 'success');
                } else {
                    showToast(data.message || 'Gagal menyimpan kategori.', 'error');
                }
            })
            .catch(err => {
                showToast(err.message || 'Terjadi kesalahan jaringan.', 'error');
            })
            .finally(() => {
                btn.innerHTML = originalText;
                btn.disabled = false;
            });
    }

    window.deleteCategory = function (id) {
        showConfirm('Kategori ini akan dihapus secara permanen. Pastikan tidak ada transaksi yang tertaut.', 'Hapus Kategori?').then(ok => {
            if (!ok) return;

            fetch(`/api/categories/${id}`, {
                method: 'DELETE',
                headers: headers
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        fetchCategories();
                        showToast('Kategori dihapus.', 'warning');
                    } else {
                        showToast('Gagal menghapus kategori.', 'error');
                    }
                })
                .catch(() => showToast('Terjadi kesalahan jaringan.', 'error'));
        });
    }
</script>
@endpush