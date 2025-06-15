<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Distribusi Pangan</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    @extends('nasional.layouts.app')

    @section('content')
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Detail Distribusi Pangan</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>Komoditas</th>
                                        <td>{{ $distribusiPangan->komoditas }}</td>
                                    </tr>
                                    <tr>
                                        <th>Jumlah (Ton)</th>
                                        <td>{{ number_format($distribusiPangan->jumlah, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Kirim</th>
                                        <td>{{ \Carbon\Carbon::parse($distribusiPangan->tanggal_kirim)->format('d-m-Y') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>{{ ucfirst($distribusiPangan->status) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Provinsi Tujuan</th>
                                        <td>{{ $distribusiPangan->region->provinsi }} -
                                            {{ $distribusiPangan->region->kota }}</td>
                                    </tr>
                                    <tr>
                                        <th>Dibuat Oleh</th>
                                        <td>{{ $distribusiPangan->creator->name ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Dibuat</th>
                                        <td>{{ \Carbon\Carbon::parse($distribusiPangan->created_at)->format('d-m-Y H:i') }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <a href="{{ route('nasional.distribusi.index') }}" class="btn btn-secondary mt-3">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
</body>

</html>
