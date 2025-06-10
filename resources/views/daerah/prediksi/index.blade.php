@extends('daerah.layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <h4 class="card-title">Prediksi Stok Pangan - {{ $wilayah->provinsi }} - {{ $wilayah->kota }}</h4>
        <form method="GET" class="form-inline">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari komoditas, jenis, atau metode..." value="{{ request()->query('search') }}">
                <button type="submit" class="btn btn-primary">Cari</button>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Daftar Prediksi</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Komoditas</th>
                                <th>Jenis</th>
                                <th>Bulan-Tahun</th>
                                <th>Jumlah (Ton)</th>
                                <th>Metode</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($prediksi as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->komoditas }}</td>
                                    <td>{{ $item->jenis }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->bulan_tahun)->format('m-Y') }}</td>
                                    <td>{{ number_format($item->jumlah, 2) }}</td>
                                    <td>{{ $item->metode }}</td>
                                    <td>{{ $item->status }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada data prediksi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Pesan dari Pemerintah Nasional</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Provinsi</th>
                                <th>Komoditas</th>
                                <th>Bulan-Tahun</th>
                                <th>Pesan</th>
                                <th>Dikirim Oleh</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pesan as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->provinsi }}</td>
                                    <td>{{ $item->komoditas }}</td>
                                    <td>{{ $item->bulan_tahun }}</td>
                                    <td>{{ $item->pesan }}</td>
                                    <td>{{ $item->creator->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada pesan dari nasional.</td>
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