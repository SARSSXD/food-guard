<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin Nasional</title>
</head>

<body>
    @extends('nasional.layouts.app')

    @section('content')
        <div class="container-fluid">
            <!-- Page Heading -->
            <h1 class="h3 mb-4 text-gray-800">Dashboard Admin Nasional</h1>

            <!-- Kartu Statistik -->
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card card-stats bg-primary text-white shadow">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-tractor fa-2x mr-3"></i>
                                <div>
                                    <h6 class="card-title">Produksi Pangan</h6>
                                    <h3 class="card-text">{{ number_format($totalProduksi, 2, ',', '.') }} Ton</h3>
                                    <p class="card-text">Total produksi terverifikasi</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card card-stats bg-success text-white shadow">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-warehouse fa-2x mr-3"></i>
                                <div>
                                    <h6 class="card-title">Cadangan Pangan</h6>
                                    <h3 class="card-text">{{ number_format($totalCadangan, 2, ',', '.') }} Ton</h3>
                                    <p class="card-text">Total stok nasional</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card card-stats bg-info text-white shadow">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-money-bill-wave fa-2x mr-3"></i>
                                <div>
                                    <h6 class="card-title">Harga Pangan</h6>
                                    <h3 class="card-text">Rp {{ number_format($avgHarga, 0, ',', '.') }}/kg</h3>
                                    <p class="card-text">Rata-rata nasional</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Filter Data</h6>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('nasional.dashboard') }}">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="provinsi" class="font-weight-bold">Provinsi</label>
                                <select name="provinsi" id="provinsi" class="form-control">
                                    <option value="">Semua Provinsi</option>
                                    @foreach ($provinsiList as $provinsiItem)
                                        <option value="{{ $provinsiItem->id }}"
                                            {{ $provinsi == $provinsiItem->id ? 'selected' : '' }}>
                                            {{ $provinsiItem->provinsi }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="komoditas" class="font-weight-bold">Komoditas</label>
                                <select name="komoditas" id="komoditas" class="form-control">
                                    <option value="">Semua Komoditas</option>
                                    @foreach ($komoditasList as $komoditasItem)
                                        <option value="{{ $komoditasItem }}"
                                            {{ $komoditas == $komoditasItem ? 'selected' : '' }}>
                                            {{ $komoditasItem }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="tahun" class="font-weight-bold">Tahun</label>
                                <select name="tahun" id="tahun" class="form-control">
                                    <option value="">Semua Tahun</option>
                                    @foreach ($tahunList as $tahunItem)
                                        <option value="{{ $tahunItem }}" {{ $tahun == $tahunItem ? 'selected' : '' }}>
                                            {{ $tahunItem }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-3 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-eye"></i> Cari
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Grafik -->
            <div class="row">
                <!-- Grafik 1: Line Chart -->
                <div class="col-md-12 mb-4">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Tren Produksi dan Cadangan Pangan</h6>
                        </div>
                        <div class="card-body">
                            <canvas id="trenPanganChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Grafik 2: Pie Chart Produksi -->
                <div class="col-md-6 mb-4">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Distribusi Produksi Pangan</h6>
                        </div>
                        <div class="card-body">
                            <canvas id="pieProduksiChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Grafik 4: Pie Chart Cadangan -->
                <div class="col-md-6 mb-4">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Distribusi Cadangan Pangan</h6>
                        </div>
                        <div class="card-body">
                            <canvas id="pieCadanganChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Grafik 3: Bar Chart Harga -->
                <div class="col-md-6 mb-4">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Rata-rata Harga Pangan per Komoditas</h6>
                        </div>
                        <div class="card-body">
                            <canvas id="barHargaChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Grafik 5: Line Chart Harga -->
                <div class="col-md-6 mb-4">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Tren Harga Pangan</h6>
                        </div>
                        <div class="card-body">
                            <canvas id="lineHargaChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <style>
            .card-stats {
                transition: transform 0.2s;
            }

            .card-stats:hover {
                transform: translateY(-5px);
            }

            th,
            td {
                border-bottom: 1px solid #e5e7eb;
            }

            th {
                background: linear-gradient(135deg, #4d6fcc 0%, #3b82f6 100%);
                text-transform: uppercase;
                letter-spacing: 0.05em;
                text-align: center;
            }
        </style>
    @endsection

    @section('scripts')
        <script>
            $(document).ready(function() {
                // Debug data grafik
                console.log('Line Chart:', {
                    labels: @json($chartLabelsLine),
                    datasets: @json($chartDatasetsLine)
                });
                console.log('Pie Produksi:', {
                    labels: @json($pieProduksiLabels),
                    values: @json($pieProduksiValues)
                });
                console.log('Bar Harga:', {
                    labels: @json($chartLabelsBar),
                    datasets: @json($chartDatasetsBar)
                });
                console.log('Pie Cadangan:', {
                    labels: @json($pieCadanganLabels),
                    values: @json($pieCadanganValues)
                });
                console.log('Line Harga:', {
                    labels: @json($chartLabelsLineHarga),
                    datasets: @json($chartDatasetsLineHarga)
                });

                // Grafik 1: Line Chart
                if (@json($chartLabelsLine).length > 0) {
                    new Chart(document.getElementById('trenPanganChart'), {
                        type: 'line',
                        data: {
                            labels: @json($chartLabelsLine),
                            datasets: @json($chartDatasetsLine)
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Jumlah (Ton)'
                                    }
                                },
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Tahun'
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
                } else {
                    $('#trenPanganChart').replaceWith('<p>Tidak ada data untuk grafik tren.</p>');
                }

                // Grafik 2: Pie Chart Produksi
                if (@json($pieProduksiLabels).length > 0) {
                    new Chart(document.getElementById('pieProduksiChart'), {
                        type: 'pie',
                        data: {
                            labels: @json($pieProduksiLabels),
                            datasets: [{
                                data: @json($pieProduksiValues),
                                backgroundColor: @json($pieProduksiColors)
                            }]
                        },
                        options: {
                            plugins: {
                                legend: {
                                    position: 'right'
                                }
                            }
                        }
                    });
                } else {
                    $('#pieProduksiChart').replaceWith('<p>Tidak ada data untuk grafik produksi.</p>');
                }

                // Grafik 3: Bar Chart Harga
                if (@json($chartLabelsBar).length > 0) {
                    new Chart(document.getElementById('barHargaChart'), {
                        type: 'bar',
                        data: {
                            labels: @json($chartLabelsBar),
                            datasets: @json($chartDatasetsBar)
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Harga (Rp/kg)'
                                    }
                                },
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Tahun'
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
                } else {
                    $('#barHargaChart').replaceWith('<p>Tidak ada data untuk grafik harga.</p>');
                }

                // Grafik 4: Pie Chart Cadangan
                if (@json($pieCadanganLabels).length > 0) {
                    new Chart(document.getElementById('pieCadanganChart'), {
                        type: 'pie',
                        data: {
                            labels: @json($pieCadanganLabels),
                            datasets: [{
                                data: @json($pieCadanganValues),
                                backgroundColor: @json($pieCadanganColors)
                            }]
                        },
                        options: {
                            plugins: {
                                legend: {
                                    position: 'right'
                                }
                            }
                        }
                    });
                } else {
                    $('#pieCadanganChart').replaceWith('<p>Tidak ada data untuk grafik cadangan.</p>');
                }

                // Grafik 5: Line Chart Harga
                if (@json($chartLabelsLineHarga).length > 0) {
                    new Chart(document.getElementById('lineHargaChart'), {
                        type: 'line',
                        data: {
                            labels: @json($chartLabelsLineHarga),
                            datasets: @json($chartDatasetsLineHarga)
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Harga (Rp/kg)'
                                    }
                                },
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Tahun'
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
                } else {
                    $('#lineHargaChart').replaceWith('<p>Tidak ada data untuk grafik harga.</p>');
                }
            });
        </script>
    @endsection
</body>

</html>
