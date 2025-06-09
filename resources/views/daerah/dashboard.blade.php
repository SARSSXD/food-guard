@extends('daerah.layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Dashboard Admin Daerah</h4>
                    <p class="card-description">Ringkasan data pangan untuk wilayah {{ $wilayah->provinsi }} -
                        {{ $wilayah->kota }}</p>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card card-stats bg-primary text-white">
                                <div class="card-body">
                                    <h6 class="card-title">Produksi Pangan</h6>
                                    <h3 class="card-text">{{ $totalProduksi }} Ton</h3>
                                    <p class="card-text">Total produksi terverifikasi</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card card-stats bg-success text-white">
                                <div class="card-body">
                                    <h6 class="card-title">Cadangan Pangan</h6>
                                    <h3 class="card-text">{{ $totalCadangan }} Ton</h3>
                                    <p class="card-text">Total stok gudang</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card card-stats bg-info text-white">
                                <div class="card-body">
                                    <h6 class="card-title">Distribusi Pangan</h6>
                                    <h3 class="card-text">{{ $totalDistribusi }} Pengiriman</h3>
                                    <p class="card-text">Total pengiriman selesai</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card card-stats bg-warning text-white">
                                <div class="card-body">
                                    <h6 class="card-title">Artikel Gizi</h6>
                                    <h3 class="card-text">{{ $totalArtikel }}</h3>
                                    <p class="card-text">Total artikel diterbitkan</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Produksi vs Cadangan Pangan</h5>
                                    <canvas id="produksiCadanganChart"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Tren Harga Pangan</h5>
                                    <canvas id="hargaPanganChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const produksiCadanganChart = new Chart(document.getElementById('produksiCadanganChart'), {
                type: 'bar',
                data: {
                    labels: @json($komoditasLabels),
                    datasets: [{
                        label: 'Produksi (Ton)',
                        data: @json($produksiData),
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }, {
                        label: 'Cadangan (Ton)',
                        data: @json($cadanganData),
                        backgroundColor: 'rgba(75, 192, 192, 0.5)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Jumlah (Ton)'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top'
                        }
                    }
                }
            });

            const hargaPanganChart = new Chart(document.getElementById('hargaPanganChart'), {
                type: 'line',
                data: {
                    labels: @json($hargaLabels),
                    datasets: @json($hargaDatasets)
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Harga per Kg (Rp)'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Bulan-Tahun'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top'
                        }
                    }
                }
            });
        });
    </script>
@endsection
