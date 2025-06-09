<div class="modal fade" id="editDistribusiModal{{ $distribusiPangan->id }}" tabindex="-1"
    aria-labelledby="editDistribusiModalLabel{{ $distribusiPangan->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDistribusiModalLabel{{ $distribusiPangan->id }}">Edit Data Distribusi
                    Pangan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('daerah.distribusi.update', $distribusiPangan->id) }}" method="POST">
                @csrf
                @method('PUT')
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
                        <label for="id_wilayah_tujuan{{ $distribusiPangan->id }}">Wilayah Tujuan</label>
                        <select class="form-control" id="id_wilayah_tujuan{{ $distribusiPangan->id }}"
                            name="id_wilayah_tujuan" required>
                            @foreach ($wilayah as $w)
                                <option value="{{ $w->id }}"
                                    {{ old('id_wilayah_tujuan', $distribusiPangan->id_wilayah_tujuan) == $w->id ? 'selected' : '' }}>
                                    {{ $w->provinsi }} - {{ $w->kota }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="komoditas{{ $distribusiPangan->id }}">Komoditas</label>
                        <input type="text" class="form-control" id="komoditas{{ $distribusiPangan->id }}"
                            name="komoditas" value="{{ old('komoditas', $distribusiPangan->komoditas) }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="jumlah{{ $distribusiPangan->id }}">Jumlah (Ton)</label>
                        <input type="number" step="0.01" class="form-control"
                            id="jumlah{{ $distribusiPangan->id }}" name="jumlah"
                            value="{{ old('jumlah', $distribusiPangan->jumlah) }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="tanggal_kirim{{ $distribusiPangan->id }}">Tanggal Kirim</label>
                        <input type="date" class="form-control" id="tanggal_kirim{{ $distribusiPangan->id }}"
                            name="tanggal_kirim" value="{{ old('tanggal_kirim', $distribusiPangan->tanggal_kirim) }}"
                            required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="status{{ $distribusiPangan->id }}">Status</label>
                        <select class="form-control" id="status{{ $distribusiPangan->id }}" name="status" required>
                            <option value="dikirim"
                                {{ old('status', $distribusiPangan->status) == 'dikirim' ? 'selected' : '' }}>Dikirim
                            </option>
                            <option value="ditunda"
                                {{ old('status', $distribusiPangan->status) == 'ditunda' ? 'selected' : '' }}>Ditunda
                            </option>
                            <option value="terlambat"
                                {{ old('status', $distribusiPangan->status) == 'terlambat' ? 'selected' : '' }}>
                                Terlambat</option>
                            <option value="selesai"
                                {{ old('status', $distribusiPangan->status) == 'selesai' ? 'selected' : '' }}>Selesai
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
