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

@push('scripts')
<script>
    // ApexCharts: Alokasi Kekayaan
    (function () {
        var series = @json($chartSeries);
        var labels = @json($chartLabels);
        var total = series.reduce(function (a, b) { return a + b; }, 0);

        if (total > 0 && document.querySelector('#allocationChart')) {
            var isDark = document.documentElement.classList.contains('dark');
            var chart = new ApexCharts(document.querySelector('#allocationChart'), {
                series: series,
                labels: labels,
                chart: { type: 'donut', height: 280, fontFamily: 'inherit', background: 'transparent' },
                colors: ['#4F46E5', '#10B981', '#F59E0B', '#3B82F6', '#8B5CF6', '#EC4899', '#6B7280'],
                plotOptions: {
                    pie: {
                        donut: {
                            size: '72%',
                            labels: {
                                show: true,
                                name: { show: true, fontSize: '13px', color: isDark ? '#9CA3AF' : '#6B7280' },
                                value: {
                                    show: true, fontSize: '18px', fontWeight: 700,
                                    color: isDark ? '#F9FAFB' : '#111827',
                                    formatter: function (val) {
                                        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(val);
                                    }
                                },
                                total: {
                                    show: true, showAlways: false, label: 'Total',
                                    color: isDark ? '#9CA3AF' : '#6B7280',
                                    formatter: function (w) {
                                        var sum = w.globals.seriesTotals.reduce(function (a, b) { return a + b; }, 0);
                                        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(sum);
                                    }
                                }
                            }
                        }
                    }
                },
                dataLabels: { enabled: false },
                legend: { show: true, position: 'bottom', labels: { colors: isDark ? '#D1D5DB' : '#374151' }, markers: { radius: 12 } },
                stroke: { show: true, colors: isDark ? ['#1F2937'] : ['#ffffff'], width: 2 },
                tooltip: {
                    theme: isDark ? 'dark' : 'light',
                    y: { formatter: function (val) { return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(val); } }
                }
            });
            chart.render();

            // Dark mode listener
            new MutationObserver(function (mutations) {
                mutations.forEach(function (m) {
                    if (m.attributeName === 'class') {
                        var dark = document.documentElement.classList.contains('dark');
                        chart.updateOptions({
                            stroke: { colors: dark ? ['#1F2937'] : ['#ffffff'] },
                            tooltip: { theme: dark ? 'dark' : 'light' },
                            legend: { labels: { colors: dark ? '#D1D5DB' : '#374151' } }
                        });
                    }
                });
            }).observe(document.documentElement, { attributes: true });
        }
    })();
</script>
@endpush