@extends('user.layouts.app')

@section('content')
    <section class="section">
        <div class="container">
            <h2 class="mb-4" data-aos="fade-up">Data Prediksi Pangan</h2>

            <!-- Filter -->
            <div class="card shadow mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card-body">
                    <form method="GET" action="{{ route('prediksi.index') }}">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="kota" class="form-label fw-bold">Kota</label>
                                <select name="kota" id="kota" class="form-control">
                                    <option value="">Semua Kota</option>
                                    @foreach ($kotaList as $kotaItem)
                                        <option value="{{ $kotaItem }}" {{ $kota == $kotaItem ? 'selected' : '' }}>
                                            {{ $kotaItem }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="tahun" class="form-label fw-bold">Tahun</label>
                                <select name="tahun" id="tahun" class="form-control">
                                    <option value="">Semua Tahun</option>
                                    @foreach ($tahunList as $tahunItem)
                                        <option value="{{ $tahunItem }}" {{ $tahun == $tahunItem ? 'selected' : '' }}>
                                            {{ $tahunItem }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-3 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-search"></i> Cari
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Grafik -->
            <div class="card shadow mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card-body">
                    <h5 class="card-title">Tren Prediksi Pangan {{ $kota ? "di $kota" : 'Nasional' }}</h5>
                    <canvas id="prediksiChart"></canvas>
                </div>
            </div>

            <!-- Tabel Prediksi -->
            @if ($prediksiData->isNotEmpty())
                <div class="card shadow mb-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="card-body">
                        <h5 class="card-title">Daftar Prediksi Pangan</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th>Jenis</th>
                                        <th>Komoditas</th>
                                        <th>Bulan-Tahun</th>
                                        <th>Jumlah (Ton)</th>
                                        <th>Metode</th>
                                        <th>Kota</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($prediksiData as $item)
                                        <tr>
                                            <td>{{ ucfirst($item->jenis) }}</td>
                                            <td>{{ $item->komoditas }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->bulan_tahun)->translatedFormat('F Y') }}
                                            </td>
                                            <td>{{ number_format($item->jumlah, 2, ',', '.') }}</td>
                                            <td>{{ $item->metode }}</td>
                                            <td>{{ $item->region->kota }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @else
                <div class="card shadow mb-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="card-body">
                        <p class="text-muted">Tidak ada data prediksi pangan untuk
                            {{ $kota ? "kota $kota" : 'seluruh Indonesia' }}.</p>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Chart Labels:', @json($chartLabels));
            console.log('Chart Datasets:', @json($chartDatasets));

            if (@json($chartLabels).length > 0) {
                new Chart(document.getElementById('prediksiChart'), {
                    type: 'line',
                    data: {
                        labels: @json($chartLabels),
                        datasets: @json($chartDatasets)
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
                document.getElementById('prediksiChart').parentElement.innerHTML =
                    '<p class="text-muted">Tidak ada data untuk grafik prediksi.</p>';
            }
        });
    </script>
@endsection
