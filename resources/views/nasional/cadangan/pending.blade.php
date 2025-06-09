<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Cadangan Pangan Pending</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css" rel="stylesheet">
</head>
<body>
    @extends('nasional.layouts.app')

    @section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Pengajuan Cadangan Pangan Pending</h4>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Komoditas</th>
                                    <th>Jumlah (Ton)</th>
                                    <th>Tahun</th>
                                    <th>Provinsi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pendingCadangan as $item)
                                    <tr>
                                        <td>{{ $item->komoditas }}</td>
                                        <td>{{ number_format($item->jumlah, 2) }}</td>
                                        <td>{{ $item->periode }}</td>
                                        <td>{{ $item->region->provinsi }}</td>
                                        <td>
                                            <form action="{{ route('nasional.cadangan.validasi', $item->id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="action" value="approve">
                                                <button type="submit" class="btn btn-success btn-sm">Setujui</button>
                                            </form>
                                            <form action="{{ route('nasional.cadangan.validasi', $item->id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="action" value="reject">
                                                <button type="submit" class="btn btn-danger btn-sm">Tolak</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Tidak ada pengajuan pending.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
</body>
</html>