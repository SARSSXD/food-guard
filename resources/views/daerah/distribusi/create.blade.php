<div class="modal fade" id="createDistribusiModal" tabindex="-1" aria-labelledby="createDistribusiModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createDistribusiModalLabel">Tambah Data Distribusi Pangan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('daerah.distribusi.store') }}" method="POST">
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
                        <label for="id_wilayah_tujuan">Wilayah Tujuan</label>
                        <select class="form-control" id="id_wilayah_tujuan" name="id_wilayah_tujuan" required>
                            @foreach ($wilayah as $w)
                                <option value="{{ $w->id }}"
                                    {{ old('id_wilayah_tujuan') == $w->id ? 'selected' : '' }}>
                                    {{ $w->provinsi }} - {{ $w->kota }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="komoditas">Komoditas</label>
                        <input type="text" class="form-control" id="komoditas" name="komoditas"
                            value="{{ old('komoditas') }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="jumlah">Jumlah (Ton)</label>
                        <input type="number" step="0.01" class="form-control" id="jumlah" name="jumlah"
                            value="{{ old('jumlah') }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="tanggal_kirim">Tanggal Kirim</label>
                        <input type="date" class="form-control" id="tanggal_kirim" name="tanggal_kirim"
                            value="{{ old('tanggal_kirim') }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="dikirim" {{ old('status') == 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                            <option value="ditunda" {{ old('status') == 'ditunda' ? 'selected' : '' }}>Ditunda</option>
                            <option value="terlambat" {{ old('status') == 'terlambat' ? 'selected' : '' }}>Terlambat
                            </option>
                            <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
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
