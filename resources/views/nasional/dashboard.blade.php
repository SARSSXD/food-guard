@extends('nasional.layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Dashboard Nasional</h4>
                @if($pendingCount > 0)
                    <div class="alert alert-warning">
                        Ada {{ $pendingCount }} data produksi pangan yang masih pending lebih dari 3 hari.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Grafik Produksi -->
    <div class="col-lg-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Produksi Pangan per Bulan</h5>
                <canvas id="produksiChart"></canvas>
            </div>
        </div>
    </div>
    <!-- Grafik Cadangan -->
    <div class="col-lg-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Cadangan Pangan per Komoditas</h5>
                <canvas id="cadanganChart"></canvas>
            </div>
        </div>
    </div>
    <!-- Grafik Harga -->
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Rata-rata Harga Pangan per Bulan</h5>
                <canvas id="hargaChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript untuk Grafik -->
<script src="{{ asset('assets/js/chart.js/Chart.min.js') }}"></script>
<script>
    // Grafik Produksi
    new Chart(document.getElementById('produksiChart'), {
        type: 'line',
        data: {
            labels: @json($labels),
            datasets: @json($produksiDatasets)
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // Grafik Cadangan
    new Chart(document.getElementById('cadanganChart'), {
        type: 'bar',
        data: {
            labels: @json($cadanganLabels),
            datasets: [{
                label: 'Total Cadangan',
                data: @json($cadanganValues),
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // Grafik Harga
    new Chart(document.getElementById('hargaChart'), {
        type: 'bar',
        data: {
            labels: @json($hargaLabels),
            datasets: @json($hargaDatasets)
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
@endsection