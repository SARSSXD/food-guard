<div class="modal fade" id="createArtikelModal" tabindex="-1" aria-labelledby="createArtikelModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createArtikelModalLabel">Tambah Artikel Gizi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('daerah.artikel.store') }}" method="POST">
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
                        <label for="judul">Judul</label>
                        <input type="text" class="form-control" id="judul" name="judul"
                            value="{{ old('judul') }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="isi">Isi</label>
                        <textarea class="form-control" id="isi" name="isi" rows="6" required>{{ old('isi') }}</textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label for="kategori">Kategori</label>
                        <select class="form-control" id="kategori" name="kategori" required>
                            <option value="anak" {{ old('kategori') == 'anak' ? 'selected' : '' }}>Anak</option>
                            <option value="ibu_hamil" {{ old('kategori') == 'ibu_hamil' ? 'selected' : '' }}>Ibu Hamil
                            </option>
                            <option value="lansia" {{ old('kategori') == 'lansia' ? 'selected' : '' }}>Lansia</option>
                            <option value="lainnya" {{ old('kategori') == 'lainnya' ? 'selected' : '' }}>Lainnya
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
