@extends('nasional.layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <h4 class="card-title">Informasi Prediksi & Stok Pangan</h4>
        <form method="GET" action="{{ route('nasional.prediksi.index') }}">
            <div class="row">
                <div class="col-md-3 form-group mb-2">
                    <label>Provinsi</label>
                    <select name="provinsi" class="form-control">
                        <option value="">Semua Provinsi</option>
                        @foreach($wilayahList as $wilayah)
                            <option value="{{ $wilayah->id }}" {{ request('provinsi') == $wilayah->id ? 'selected' : '' }}>
                                {{ $wilayah->provinsi }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 form-group mb-2">
                    <label>Komoditas</label>
                    <select name="komoditas" class="form-control">
                        <option value="">Semua Komoditas</option>
                        @foreach($komoditasList as $komoditas)
                            <option value="{{ $komoditas }}" {{ request('komoditas') == $komoditas ? 'selected' : '' }}>
                                {{ $komoditas }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 form-group mb-2">
                    <label>Jenis</label>
                    <select name="jenis" class="form-control">
                        <option value="">Semua Jenis</option>
                        @foreach($jenisList as $jenis)
                            <option value="{{ $jenis }}" {{ request('jenis') == $jenis ? 'selected' : '' }}>
                                {{ $jenis }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 form-group mb-2">
                    <label>Tahun</label>
                    <select name="tahun" class="form-control">
                        <option value="">Semua Tahun</option>
                        @foreach($tahunList as $tahun)
                            <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>
                                {{ $tahun }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-12 form-group">
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
                <h5 class="card-title">Grafik Tren Prediksi</h5>
                <canvas id="prediksiChart" height="100"></canvas>
            </div>
        </div>
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
                                <th>Provinsi</th>
                                <th>Komoditas</th>
                                <th>Jenis</th>
                                <th>Bulan-Tahun</th>
                                <th>Jumlah (Ton)</th>
                                <th>Metode</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($prediksi as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->region->provinsi ?? '-' }}</td>
                                    <td>{{ $item->komoditas }}</td>
                                    <td>{{ $item->jenis }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->bulan_tahun)->format('m-Y') }}</td>
                                    <td>{{ number_format($item->jumlah, 2) }}</td>
                                    <td>{{ $item->metode }}</td>
                                    <td>{{ $item->status }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#pesanModal"
                                            data-id="{{ $item->id }}"
                                            data-wilayah="{{ $item->region->provinsi ?? '-' }}"
                                            data-komoditas="{{ $item->komoditas }}"
                                            data-bulan-tahun="{{ \Carbon\Carbon::parse($item->bulan_tahun)->format('Y-m') }}">
                                            Kirim Pesan
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">Tidak ada data prediksi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Kirim Pesan atau Ubah Status -->
<div class="modal fade" id="pesanModal" tabindex="-1" aria-labelledby="pesanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('nasional.prediksi.update', ['prediksiPangan' => ':id']) }}">
            @csrf
            @method('PATCH')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pesanModalLabel">Kirim Pesan atau Ubah Status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Provinsi</label>
                        <input type="text" name="provinsi" id="modalWilayah" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label>Komoditas</label>
                        <input type="text" name="komoditas" id="modalKomoditas" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label>Bulan-Tahun</label>
                        <input type="text" name="bulan_tahun" id="modalBulanTahun" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control" required>
                            <option value="draft">Draft</option>
                            <option value="disetujui">Disetujui</option>
                            <option value="revisi">Revisi</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi Pesan (wajib jika Revisi)</label>
                        <textarea name="pesan" class="form-control" rows="4"></textarea>
                    </div>
                    <input type="hidden" name="id" id="modalId">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Kirim</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Tambah Prediksi -->
<div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('nasional.prediksi.store') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahModalLabel">Tambah Prediksi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Jenis</label>
                        <select name="jenis" class="form-control" required>
                            <option value="produksi">Produksi</option>
                            <option value="cadangan">Cadangan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Komoditas</label>
                        <input type="text" name="komoditas" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Provinsi</label>
                        <select name="id_lokasi" class="form-control" required>
                            @foreach($wilayahList as $wilayah)
                                <option value="{{ $wilayah->id }}">{{ $wilayah->provinsi }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Bulan-Tahun</label>
                        <input type="month" name="bulan_tahun" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Jumlah (Ton)</label>
                        <input type="number" name="jumlah" step="0.01" min="0" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Metode</label>
                        <input type="text" name="metode" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control" required>
                            <option value="draft">Draft</option>
                            <option value="disetujui">Disetujui</option>
                            <option value="revisi">Revisi</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    $(document).ready(function() {
        $('#pesanModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var wilayah = button.data('wilayah');
            var komoditas = button.data('komoditas');
            var bulanTahun = button.data('bulan-tahun');

            var modal = $(this);
            modal.find('#modalId').val(id);
            modal.find('#modalWilayah').val(wilayah);
            modal.find('#modalKomoditas').val(komoditas);
            modal.find('#modalBulanTahun').val(bulanTahun);
            modal.find('form').attr('action', '{{ route('nasional.prediksi.update', ['prediksiPangan' => ':id']) }}'.replace(':id', id));
        });

        var ctx = document.getElementById('prediksiChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: @json($chartData),
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah (Ton)'
                        }
                    }
                }
            }
        });
    });
</script>
@endpush
@endsection