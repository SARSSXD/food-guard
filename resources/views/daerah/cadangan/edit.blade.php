<div class="modal fade" id="editCadanganModal{{ $cadanganPangan->id }}" tabindex="-1"
    aria-labelledby="editCadanganModalLabel{{ $cadanganPangan->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCadanganModalLabel{{ $cadanganPangan->id }}">Edit Data Cadangan Pangan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('daerah.cadangan.update', $cadanganPangan->id) }}" method="POST">
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
                        <label for="komoditas{{ $cadanganPangan->id }}">Komoditas</label>
                        <input type="text" class="form-control @error('komoditas') is-invalid @enderror"
                            id="komoditas{{ $cadanganPangan->id }}" name="komoditas"
                            value="{{ old('komoditas', $cadanganPangan->komoditas) }}" required>
                        @error('komoditas')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="jumlah{{ $cadanganPangan->id }}">Jumlah (Ton)</label>
                        <input type="number" step="0.01" class="form-control @error('jumlah') is-invalid @enderror"
                            id="jumlah{{ $cadanganPangan->id }}" name="jumlah"
                            value="{{ old('jumlah', $cadanganPangan->jumlah) }}" required>
                        @error('jumlah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="periode{{ $cadanganPangan->id }}">Periode (Tahun)</label>
                        <input type="number" class="form-control @error('periode') is-invalid @enderror"
                            id="periode{{ $cadanganPangan->id }}" name="periode"
                            value="{{ old('periode', $cadanganPangan->periode) }}" required>
                        @error('periode')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="id_lokasi{{ $cadanganPangan->id }}">Lokasi</label>
                        <select class="form-control @error('id_lokasi') is-invalid @enderror"
                            id="id_lokasi{{ $cadanganPangan->id }}" name="id_lokasi" required>
                            <option value="{{ $wilayah->id }}"
                                {{ old('id_lokasi', $cadanganPangan->id_lokasi) == $wilayah->id ? 'selected' : '' }}>
                                {{ $wilayah->provinsi }} - {{ $wilayah->kota }}
                            </option>
                        </select>
                        @error('id_lokasi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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
