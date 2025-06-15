<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Distribusi Pangan Indonesia</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
</head>

<body>
    @extends('nasional.layouts.app')

    @section('content')
        <div class="container-fluid">
            <!-- Page Heading -->
            <h1 class="h3 mb-4 text-gray-800">Distribusi Pangan Indonesia</h1>

            <!-- Form Pencarian -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Filter Data</h6>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('nasional.distribusi.index') }}">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="wilayah" class="font-weight-bold">Provinsi Tujuan</label>
                                <select name="wilayah" id="wilayah" class="form-control">
                                    <option value="">Semua Provinsi</option>
                                    @foreach ($wilayahList as $wilayah)
                                        <option value="{{ $wilayah->id }}"
                                            {{ request('wilayah') == $wilayah->id ? 'selected' : '' }}>
                                            {{ $wilayah->provinsi }} - {{ $wilayah->kota }}
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
                                            {{ request('komoditas') == $komoditas ? 'selected' : '' }}>{{ $komoditas }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="tanggal" class="font-weight-bold">Tanggal Kirim</label>
                                <input type="date" name="tanggal" id="tanggal" class="form-control"
                                    value="{{ request('tanggal') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="status" class="font-weight-bold">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="">Semua Status</option>
                                    @foreach ($statusList as $status)
                                        <option value="{{ $status }}"
                                            {{ request('status') == $status ? 'selected' : '' }}>{{ ucfirst($status) }}
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
            @if ($distribusiPangan->isNotEmpty())
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Daftar Distribusi Pangan</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="distribusiTable" width="100%" cellspacing="0">
                                <thead class="bg-blue-900 text-white">
                                    <tr>
                                        <th>Komoditas</th>
                                        <th>Jumlah (Ton)</th>
                                        <th>Tanggal Kirim</th>
                                        <th>Status</th>
                                        <th>Provinsi Tujuan</th>
                                        <th>Dibuat Oleh</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($distribusiPangan as $item)
                                        <tr>
                                            <td>{{ $item->komoditas }}</td>
                                            <td>{{ number_format($item->jumlah, 2) }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->tanggal_kirim)->format('d-m-Y') }}</td>
                                            <td>{{ ucfirst($item->status) }}</td>
                                            <td>{{ $item->region->provinsi }} - {{ $item->region->kota }}</td>
                                            <td>{{ $item->creator->name ?? '-' }}</td>
                                            <td>
                                                <a href="{{ route('nasional.distribusi.show', $item->id) }}"
                                                    class="btn btn-info btn-sm">Detail</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- Form Ekspor -->
                        <form method="POST" action="{{ route('nasional.distribusi.export') }}" class="mt-4">
                            @csrf
                            <input type="hidden" name="wilayah" value="{{ request('wilayah') }}">
                            <input type="hidden" name="komoditas" value="{{ request('komoditas') }}">
                            <input type="hidden" name="tanggal" value="{{ request('tanggal') }}">
                            <input type="hidden" name="status" value="{{ request('status') }}">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-download"></i> Ekspor Excel
                            </button>
                        </form>
                    </div>
                </div>
            @elseif (request('wilayah') || request('komoditas') || request('tanggal') || request('status'))
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <p class="text-gray-600">Tidak ada data distribusi pangan untuk filter yang dipilih.</p>
                    </div>
                </div>
            @endif
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
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#distribusiTable').DataTable({
                    "paging": false,
                    "searching": false,
                    "info": false
                });
            });
        </script>
    @endsection
</body>

</html>
