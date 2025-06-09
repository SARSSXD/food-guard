@extends('daerah.layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Data Prediksi Pangan</h4>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Jenis</th>
                                    <th>Komoditas</th>
                                    <th>Lokasi</th>
                                    <th>Bulan-Tahun</th>
                                    <th>Jumlah (Ton)</th>
                                    <th>Metode</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($prediksi as $item)
                                    <tr>
                                        <td>{{ $item->jenis }}</td>
                                        <td>{{ $item->komoditas }}</td>
                                        <td>{{ $item->region->provinsi }} - {{ $item->region->kota }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->bulan_tahun)->format('m-Y') }}</td>
                                        <td>{{ $item->jumlah }}</td>
                                        <td>{{ $item->metode }}</td>
                                        <td>{{ $item->status }}</td>
                                        <td>
                                            @if ($item->id_lokasi == Auth::user()->id_region)
                                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#editPrediksiModal{{ $item->id }}">
                                                    Edit
                                                </button>
                                            @else
                                                <span>-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @if ($item->id_lokasi == Auth::user()->id_region)
                                        @include('daerah.prediksi.edit', [
                                            'prediksiPangan' => $item,
                                            'wilayah' => $wilayah,
                                        ])
                                    @endif
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">Tidak ada data prediksi pangan.</td>
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
