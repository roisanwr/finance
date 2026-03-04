@extends('layouts.app')
@section('title', 'Ringkasan Portofolio')

@section('content')

{{-- Judul halaman & tombol aksi --}}
@include('dashboard.partials.page-header')

{{-- 4 kartu statistik keuangan --}}
@include('dashboard.partials.stats-cards')

{{-- Grid: Transaksi Terakhir (2/3) + Alokasi Investasi (1/3) --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    @include('dashboard.partials.recent-transactions')
    @include('dashboard.partials.investment-allocation')
</div>

@endsection