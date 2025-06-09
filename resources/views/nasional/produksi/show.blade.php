@extends('nasional.layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Detail Produksi Pangan</h4>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>Komoditas</th>
                            <td>{{ $produksiPangan->komoditas }}</td>
                        </tr>
                        <tr>
                            <th>Jumlah (Ton)</th>
                            <td>{{ number_format($produksiPangan->jumlah, 2) }}</td>
                        </tr>
                        <tr>
                            <th>Tahun</th>
                            <td>{{ $produksiPangan->periode }}</td>
                        </tr>
                        <tr>
                            <th>Provinsi</th>
                            <td>{{ $produksiPangan->region->provinsi }}</td>
                        </tr>
                        <tr>
                            <th>Status Validasi</th>
                            <td>{{ $produksiPangan->status_valid }}</td>
                        </tr>
                        <tr>
                            <th>Dibuat Oleh</th>
                            <td>{{ $produksiPangan->creator->name }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Dibuat</th>
                            <td>{{ $produksiPangan->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>
                    <a href="{{ route('nasional.produksi.index') }}" class="btn btn-secondary mt-3">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
</div>