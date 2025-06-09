@extends('nasional.layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Produksi Pangan Indonesia
                    @if($pendingCount > 0)
                        <a href="{{ route('nasional.produksi.pending') }}" class="badge badge-warning ms-2">
                            <i class="mdi mdi-grain"></i> {{ $pendingCount }} Pengajuan Pending
                        </a>
                    @endif
                </h4>

                <!-- Form Pencarian -->
                <form method="GET" action="{{ route('nasional.produksi.index') }}" class="mb-4">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="wilayah">Provinsi</label>
                            <select name="wilayah" id="wilayah" class="form-control">
                                <option value="">Semua Provinsi</option>
                                @foreach($wilayahList as $wilayah)
                                    <option value="{{ $wilayah->id }}" {{ request('wilayah') == $wilayah->id ? 'selected' : '' }}>
                                        {{ $wilayah->provinsi }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="tahun">Tahun</label>
                            <select name="tahun" id="tahun" class="form-control">
                                <option value="">Semua Tahun</option>
                                @foreach($tahunList as $tahun)
                                    <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="komoditas">Komoditas</label>
                            <select name="komoditas" id="komoditas" class="form-control">
                                <option value="">Semua Komoditas</option>
                                @foreach($komoditasList as $komoditas)
                                    <option value="{{ $komoditas }}" {{ request('komoditas') == $komoditas ? 'selected' : '' }}>{{ $komoditas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary">Cari</button>
                            <a href="{{ route('nasional.produksi.export', request()->only(['wilayah', 'tahun', 'komoditas'])) }}" class="btn btn-success ms-2">Ekspor CSV</a>
                        </div>
                    </div>
                </form>

                <!-- Tabel Data -->
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Komoditas</th>
                                <th>Jumlah (Ton)</th>
                                <th>Tahun</th>
                                <th>Provinsi</th>
                                <th>Status Validasi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($produksiPangan as $item)
                                <tr>
                                    <td>{{ $item->komoditas }}</td>
                                    <td>{{ number_format($item->jumlah, 2) }}</td>
                                    <td>{{ $item->periode }}</td>
                                    <td>{{ $item->region->provinsi }}</td>
                                    <td>{{ $item->status_valid }}</td>
                                    <td>
                                        <a href="{{ route('nasional.produksi.show', $item->id) }}" class="btn btn-info btn-sm">Detail</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada data produksi pangan.</td>
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