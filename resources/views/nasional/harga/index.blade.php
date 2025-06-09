@extends('nasional.layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <form method="GET" action="{{ route('nasional.harga.index') }}">
            <div class="row">
                <div class="col-md-4 form-group mb-2">
                    <label for="wilayah" class="mr-2">Provinsi:</label>
                    <select name="wilayah" id="wilayah" class="form-control">
                        <option value="">Semua Provinsi</option>
                        @foreach($wilayahList as $wilayah)
                            <option value="{{ $wilayah->id }}" {{ request('wilayah') == $wilayah->id ? 'selected' : '' }}>
                                {{ $wilayah->provinsi }} - {{ $wilayah->kota }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 form-group mb-2">
                    <label for="komoditas" class="mr-2">Komoditas:</label>
                    <select name="komoditas" id="komoditas" class="form-control">
                        <option value="">Semua Komoditas</option>
                        @foreach($komoditasList as $komoditas)
                            <option value="{{ $komoditas }}" {{ request('komoditas') == $komoditas ? 'selected' : '' }}>
                                {{ $komoditas }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 form-group mb-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">Cari</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Daftar Harga Pangan Nasional</h4>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Provinsi</th>
                                <th>Komoditas</th>
                                <th>Harga/kg</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($hargaPangan as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->region->provinsi ?? '-' }}</td>
                                    <td>{{ $item->komoditas }}</td>
                                    <td>Rp {{ number_format($item->harga_per_kg, 0, ',', '.') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#pesanModal"
                                            data-wilayah="{{ $item->region->provinsi ?? '-' }}"
                                            data-komoditas="{{ $item->komoditas }}"
                                            data-tahun="{{ \Carbon\Carbon::parse($item->tanggal)->year }}">
                                            Kirim Pesan
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada data tersedia.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Kirim Pesan -->
<div class="modal fade" id="pesanModal" tabindex="-1" role="dialog" aria-labelledby="pesanModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="POST" action="{{ route('nasional.harga.kirim-pesan') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pesanModalLabel">Kirim Pesan Terkait Harga Pangan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="modalWilayah">Provinsi</label>
                        <input type="text" name="wilayah" class="form-control" id="modalWilayah" readonly>
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
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#pesanModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            $('#modalWilayah').val(button.data('wilayah'));
            $('#modalKomoditas').val(button.data('komoditas'));
            $('#modalTahun').val(button.data('tahun'));
        });
    });
</script>
@endpush