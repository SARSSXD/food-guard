<div class="modal fade" id="editHargaModal{{ $hargaPangan->id }}" tabindex="-1"
    aria-labelledby="editHargaModalLabel{{ $hargaPangan->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editHargaModalLabel{{ $hargaPangan->id }}">Edit Data Harga Pangan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('daerah.harga.update', $hargaPangan->id) }}" method="POST">
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
                        <label for="nama_pasar{{ $hargaPangan->id }}">Nama Pasar</label>
                        <input type="text" class="form-control" id="nama_pasar{{ $hargaPangan->id }}"
                            name="nama_pasar" value="{{ old('nama_pasar', $hargaPangan->nama_pasar) }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="komoditas{{ $hargaPangan->id }}">Komoditas</label>
                        <input type="text" class="form-control" id="komoditas{{ $hargaPangan->id }}" name="komoditas"
                            value="{{ old('komoditas', $hargaPangan->komoditas) }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="harga_per_kg{{ $hargaPangan->id }}">Harga per Kg (Rp)</label>
                        <input type="number" step="0.01" class="form-control"
                            id="harga_per_kg{{ $hargaPangan->id }}" name="harga_per_kg"
                            value="{{ old('harga_per_kg', $hargaPangan->harga_per_kg) }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="tanggal{{ $hargaPangan->id }}">Tanggal Laporan</label>
                        <input type="date" class="form-control" id="tanggal{{ $hargaPangan->id }}" name="tanggal"
                            value="{{ old('tanggal', $hargaPangan->tanggal) }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="id_lokasi{{ $hargaPangan->id }}">Lokasi</label>
                        <select class="form-control" id="id_lokasi{{ $hargaPangan->id }}" name="id_lokasi" required>
                            <option value="{{ $wilayah->id }}"
                                {{ old('id_lokasi', $hargaPangan->id_lokasi) == $wilayah->id ? 'selected' : '' }}>
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
