<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Harga Pangan Indonesia</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    @extends('nasional.layouts.app')

    @section('content')
        <div class="container-fluid">
            <!-- Page Heading -->
            <h1 class="h3 mb-4 text-gray-800">Harga Pangan Indonesia</h1>

            <!-- Form Pencarian -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Filter Data</h6>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('nasional.harga.index') }}">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="wilayah" class="font-weight-bold">Provinsi</label>
                                <select name="wilayah" id="wilayah" class="form-control">
                                    <option value="">Semua Provinsi</option>
                                    @foreach($wilayahList as $wilayah)
                                        <option value="{{ $wilayah->id }}" {{ request('wilayah') == $wilayah->id ? 'selected' : '' }}>
                                            {{ $wilayah->provinsi }} - {{ $wilayah->kota }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="komoditas" class="font-weight-bold">Komoditas</label>
                                <select name="komoditas" id="komoditas" class="form-control">
                                    <option value="">Semua Komoditas</option>
                                    @foreach($komoditasList as $komoditas)
                                        <option value="{{ $komoditas }}" {{ request('komoditas') == $komoditas ? 'selected' : '' }}>
                                            {{ $komoditas }}
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

            <!-- Tabel Data -->
            @if ($hargaPangan->isNotEmpty())
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Daftar Harga Pangan</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="hargaTable" width="100%" cellspacing="0">
                                <thead class="bg-blue-900 text-white">
                                    <tr>
                                        <th>No</th>
                                        <th>Provinsi</th>
                                        <th>Komoditas</th>
                                        <th>Harga/kg</th>
                                        <th>Tanggal</th>
                                        {{-- <th>Aksi</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($hargaPangan as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $item->region->provinsi . ' - ' . $item->region->kota ?? '-' }}</td>
                                            <td>{{ $item->komoditas ?? '-' }}</td>
                                            <td>Rp {{ number_format($item->harga_per_kg, 0, ',', '.') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                                            {{-- <td>
                                                <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#pesanModal"
                                                    data-id-wilayah="{{ $item->id_lokasi ?? '' }}"
                                                    data-wilayah="{{ $item->region->provinsi . ' - ' . $item->region->kota ?? '' }}"
                                                    data-komoditas="{{ $item->komoditas ?? '' }}"
                                                    data-tahun="{{ \Carbon\Carbon::parse($item->tanggal)->year ?? '' }}">
                                                    Kirim Pesan
                                                </button>
                                            </td> --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- Form Ekspor -->
                        <form method="POST" action="{{ route('nasional.harga.export') }}" class="mt-4">
                            @csrf
                            <input type="hidden" name="wilayah" value="{{ request('wilayah') }}">
                            <input type="hidden" name="komoditas" value="{{ request('komoditas') }}">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-download"></i> Ekspor Excel
                            </button>
                        </form>
                    </div>
                </div>
            @elseif (request('wilayah') || request('komoditas'))
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <p class="text-gray-600">Tidak ada data harga pangan untuk filter yang dipilih.</p>
                    </div>
                </div>
            @endif

            <!-- Modal Kirim Pesan -->
            <div class="modal fade" id="pesanModal" tabindex="-1" role="dialog" aria-labelledby="pesanModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form method="POST" action="{{ route('nasional.harga.kirim-pesan') }}" id="pesanForm">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="pesanModalLabel">Kirim Pesan Terkait Harga Pangan</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="id_wilayah" id="modalIdWilayah">
                                <div class="form-group">
                                    <label for="modalWilayah">Provinsi</label>
                                    <input type="text" class="form-control" id="modalWilayah" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="modalKomoditas">Komoditas</label>
                                    <input type="text" name="komoditas" class="form-control" id="modalKomoditas" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="modalTahun">Tahun</label>
                                    <input type="text" name="tahun" class="form-control" id="modalTahun" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="pesan">Deskripsi Pesan</label>
                                    <textarea name="pesan" class="form-control" id="pesan" rows="4" required></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Kirim</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <style>
            th, td {
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

    {{-- @section('scripts')
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#hargaTable').DataTable({
                    "paging": false,
                    "searching": false,
                    "info": false
                });

                $('#pesanModal').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget);
                    var idWilayah = button.data('id-wilayah');
                    var wilayah = button.data('wilayah');
                    var komoditas = button.data('komoditas');
                    var tahun = button.data('tahun');

                    // Debugging: Log data ke konsol
                    console.log('Data Modal:', {
                        id_wilayah: idWilayah,
                        wilayah: wilayah,
                        komoditas: komoditas,
                        tahun: tahun
                    });

                    $('#modalIdWilayah').val(idWilayah);
                    $('#modalWilayah').val(wilayah);
                    $('#modalKomoditas').val(komoditas);
                    $('#modalTahun').val(tahun);
                });

                // Debugging: Log saat form disubmit
                $('#pesanForm').on('submit', function(e) {
                    console.log('Form Data:', $(this).serialize());
                });
            });
        </script>
    @endsection --}}
</body>
</html>