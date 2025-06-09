<div class="modal fade" id="editProduksiModal{{ $produksiPangan->id }}" tabindex="-1"
    aria-labelledby="editProduksiModalLabel{{ $produksiPangan->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProduksiModalLabel{{ $produksiPangan->id }}">Edit Data Produksi Pangan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('daerah.produksi.update', $produksiPangan->id) }}" method="POST">
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
                        <label for="komoditas{{ $produksiPangan->id }}">Komoditas</label>
                        <input type="text" class="form-control" id="komoditas{{ $produksiPangan->id }}"
                            name="komoditas" value="{{ old('komoditas', $produksiPangan->komoditas) }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="jumlah{{ $produksiPangan->id }}">Jumlah (Ton)</label>
                        <input type="number" step="0.01" class="form-control" id="jumlah{{ $produksiPangan->id }}"
                            name="jumlah" value="{{ old('jumlah', $produksiPangan->jumlah) }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="id_lokasi{{ $produksiPangan->id }}">Lokasi</label>
                        <select class="form-control" id="id_lokasi{{ $produksiPangan->id }}" name="id_lokasi" required>
                            <option value="{{ $wilayah->id }}"
                                {{ old('id_lokasi', $produksiPangan->id_lokasi) == $wilayah->id ? 'selected' : '' }}>
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
