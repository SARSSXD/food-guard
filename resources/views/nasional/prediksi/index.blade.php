<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prediksi Pangan Indonesia</title>
</head>

<body>
    @extends('nasional.layouts.app')

    @section('content')
        <div class="container-fluid">
            <!-- Page Heading -->
            <h1 class="h3 mb-4 text-gray-800">Prediksi Pangan Indonesia</h1>

            <!-- Form Pencarian -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Filter Data</h6>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('nasional.prediksi.index') }}">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="wilayah" class="font-weight-bold">Provinsi</label>
                                <select name="wilayah" id="wilayah" class="form-control">
                                    <option value="">Semua Provinsi</option>
                                    @foreach ($wilayahList as $wilayah)
                                        <option value="{{ $wilayah->id }}"
                                            {{ request('wilayah') == $wilayah->id ? 'selected' : '' }}>
                                            {{ $wilayah->provinsi }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="tahun" class="font-weight-bold">Tahun</label>
                                <select name="tahun" id="tahun" class="form-control">
                                    <option value="">Semua Tahun</option>
                                    @foreach ($tahunList as $tahun)
                                        <option value="{{ $tahun }}"
                                            {{ request('tahun') == $tahun ? 'selected' : '' }}>
                                            {{ $tahun }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="komoditas" class="font-weight-bold">Komoditas</label>
                                <select name="komoditas" id="komoditas" class="form-control">
                                    <option value="">Semua Komoditas</option>
                                    @foreach ($komoditasList as $komoditas)
                                        <option value="{{ $komoditas }}"
                                            {{ request('komoditas') == $komoditas ? 'selected' : '' }}>
                                            {{ $komoditas }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="jenis" class="font-weight-bold">Jenis</label>
                                <select name="jenis" id="jenis" class="form-control">
                                    <option value="">Semua Jenis</option>
                                    @foreach ($jenisList as $jenis)
                                        <option value="{{ $jenis }}"
                                            {{ request('jenis') == $jenis ? 'selected' : '' }}>
                                            {{ ucfirst($jenis) }}
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
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Total Prediksi Pangan per Komoditas (Skala Nasional)</h6>
                </div>
                <div class="card-body">
                    <canvas id="prediksiKomoditasChart"></canvas>
                </div>
            </div>

            <!-- Tabel Data -->
            @if ($prediksiPangan->isNotEmpty())
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Daftar Prediksi Pangan Agregat</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="prediksiTable" width="100%" cellspacing="0">
                                <thead class="bg-blue-900 text-white">
                                    <tr>
                                        <th>Jenis</th>
                                        <th>Komoditas</th>
                                        <th>Bulan-Tahun</th>
                                        <th>Provinsi</th>
                                        <th>Jumlah (Ton)</th>
                                        <th>Metode</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($prediksiPangan as $item)
                                        <tr>
                                            <td>{{ ucfirst($item->jenis) }}</td>
                                            <td>{{ $item->komoditas }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->bulan_tahun)->translatedFormat('F Y') }}
                                            </td>
                                            <td>{{ $item->region->provinsi }}</td>
                                            <td>{{ number_format($item->jumlah, 2, ',', '.') }}</td>
                                            <td>{{ $item->metode }}</td>
                                            <td>{{ ucfirst($item->status) }}</td>
                                            <td>
                                                <button class="btn btn-primary btn-sm" data-toggle="modal"
                                                    data-target="#messageModal"
                                                    data-provinsi="{{ $item->region->provinsi }}"
                                                    data-komoditas="{{ $item->komoditas }}"
                                                    data-bulan-tahun="{{ \Carbon\Carbon::parse($item->bulan_tahun)->translatedFormat('F Y') }}">
                                                    <i class="fas fa-envelope"></i> Kirim Pesan
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- Form Ekspor -->
                        <form method="POST" action="{{ route('nasional.prediksi.export') }}" class="mt-4">
                            @csrf
                            <input type="hidden" name="wilayah" value="{{ request('wilayah') }}">
                            <input type="hidden" name="tahun" value="{{ request('tahun') }}">
                            <input type="hidden" name="komoditas" value="{{ request('komoditas') }}">
                            <input type="hidden" name="jenis" value="{{ request('jenis') }}">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-download"></i> Ekspor Excel
                            </button>
                        </form>
                    </div>
                </div>
            @elseif (request('wilayah') || request('tahun') || request('komoditas') || request('jenis'))
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <p class="text-gray-600">Tidak ada data prediksi pangan agregat untuk filter yang dipilih.</p>
                    </div>
                </div>
            @else
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <p class="text-gray-600">Tidak ada data prediksi pangan agregat tersedia.</p>
                    </div>
                </div>
            @endif

            <!-- Modal Kirim Pesan -->
            <div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="messageModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="messageModalLabel">Kirim Pesan</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="POST" action="{{ route('nasional.prediksi.message') }}">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="provinsi">Provinsi</label>
                                    <input type="text" class="form-control" id="provinsi" name="provinsi" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="komoditas">Komoditas</label>
                                    <input type="text" class="form-control" id="komoditas" name="komoditas" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="bulan_tahun">Bulan-Tahun</label>
                                    <input type="text" class="form-control" id="bulan_tahun" name="bulan_tahun"
                                        readonly>
                                </div>
                                <div class="form-group">
                                    <label for="pesan">Pesan</label>
                                    <textarea class="form-control" id="pesan" name="pesan" rows="4" required></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Kirim</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <style>
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
        <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
        <script>
            $(document).ready(function() {
                // Debug data grafik
                console.log('Chart Labels:', @json($chartLabels));
                console.log('Chart Datasets:', @json($chartDatasets));

                $('#prediksiTable').DataTable({
                    paging: false,
                    searching: false,
                    info: false
                });

                // Populate modal fields
                $('#messageModal').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget);
                    var provinsi = button.data('provinsi');
                    var komoditas = button.data('komoditas');
                    var bulanTahun = button.data('bulan-tahun');

                    var modal = $(this);
                    modal.find('#provinsi').val(provinsi);
                    modal.find('#komoditas').val(komoditas);
                    modal.find('#bulan_tahun').val(bulanTahun);
                });

                // Chart.js
                if (@json($chartLabels).length > 0) {
                    const prediksiKomoditasChart = new Chart(document.getElementById('prediksiKomoditasChart'), {
                        type: 'line',
                        data: {
                            labels: @json($chartLabels),
                            datasets: @json($chartDatasets).map(dataset => ({
                                ...dataset,
                                fill: false,
                                tension: 0.3,
                                pointRadius: 5,
                                pointHoverRadius: 7
                            }))
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
                    console.warn('No chart data available');
                    $('#prediksiKomoditasChart').replaceWith('<p>Tidak ada data untuk ditampilkan pada grafik.</p>');
                }
            });
        </script>
    @endsection
</body>

</html>
