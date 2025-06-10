@extends('nasional.layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Dashboard Nasional</h4>
                <form method="GET" action="{{ route('nasional.dashboard') }}" class="form-inline mb-3">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Cari komoditas..." value="{{ request()->query('search') }}">
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </div>
                </form>
                @if($pendingProduksiCount > 0)
                    <div class="alert alert-warning">
                        Ada {{ $pendingProduksiCount }} data produksi pangan yang masih pending lebih dari 7 hari.
                    </div>
                @endif
                @if($pendingPrediksiPangan > 0)
                    <div class="alert alert-info">
                        Ada {{ $pendingPrediksiPangan }} data prediksi pangan yang masih draft lebih dari 7 hari.
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
    <div class="col-lg-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Rata-rata Harga Pangan per Bulan</h5>
                <canvas id="hargaChart"></canvas>
            </div>
        </div>
    </div>
    <!-- Grafik Prediksi -->
    <div class="col-lg-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Prediksi Pangan per Bulan</h5>
                <canvas id="prediksiChart"></canvas>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
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
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Jumlah (Ton)'
                    }
                }
            }
        }
    });

    // Grafik Cadangan
    new Chart(document.getElementById('cadanganChart'), {
        type: 'bar',
        data: {
            labels: @json($cadanganLabels),
            datasets: [{
                label: 'Total Cadangan (Ton)',
                data: @json($cadanganValues),
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Jumlah (Ton)'
                    }
                }
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
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Harga (Rp/kg)'
                    }
                }
            }
        }
    });

    // Grafik Prediksi
    new Chart(document.getElementById('prediksiChart'), {
        type: 'line',
        data: {
            labels: @json($prediksiLabels),
            datasets: @json($prediksiDatasets)
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Jumlah Prediksi (Ton)'
                    }
                }
            }
        }
    });
</script>
@endpush
@endsection