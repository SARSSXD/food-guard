<div class="modal fade" id="createHargaModal" tabindex="-1" aria-labelledby="createHargaModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createHargaModalLabel">Tambah Data Harga Pangan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('daerah.harga.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="form-group mb-3">
                        <label for="nama_pasar">Nama Pasar</label>
                        <input type="text" class="form-control" id="nama_pasar" name="nama_pasar"
                            value="{{ old('nama_pasar') }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="komoditas">Komoditas</label>
                        <input type="text" class="form-control" id="komoditas" name="komoditas"
                            value="{{ old('komoditas') }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="harga_per_kg">Harga per Kg (Rp)</label>
                        <input type="number" step="0.01" class="form-control" id="harga_per_kg" name="harga_per_kg"
                            value="{{ old('harga_per_kg') }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="tanggal">Tanggal Laporan</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal"
                            value="{{ old('tanggal') }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="id_lokasi">Lokasi</label>
                        <select class="form-control" id="id_lokasi" name="id_lokasi" required>
                            <option value="{{ $wilayah->id }}"
                                {{ old('id_lokasi') == $wilayah->id ? 'selected' : '' }}>
                                {{ $wilayah->provinsi }} - {{ $wilayah->kota }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>