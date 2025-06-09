<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Cadangan Pangan</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @extends('nasional.layouts.app')

    @section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Detail Cadangan Pangan</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th>Komoditas</th>
                                    <td>{{ $cadanganPangan->komoditas }}</td>
                                </tr>
                                <tr>
                                    <th>Jumlah (Ton)</th>
                                    <td>{{ number_format($cadanganPangan->jumlah, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Tahun</th>
                                    <td>{{ $cadanganPangan->periode }}</td>
                                </tr>
                                <tr>
                                    <th>Provinsi</th>
                                    <td>{{ $cadanganPangan->region->provinsi }}</td>
                                </tr>
                                <tr>
                                    <th>Status Validasi</th>
                                    <td>{{ $cadanganPangan->status_valid }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <a href="{{ route('nasional.cadangan.index') }}" class="btn btn-secondary mt-3">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
</body>
</html>