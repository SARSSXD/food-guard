<div class="modal fade" id="editArtikelModal{{ $artikelGizi->id }}" tabindex="-1"
    aria-labelledby="editArtikelModalLabel{{ $artikelGizi->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class12="modal-title" id="editArtikelModalLabel{{ $artikelGizi->id }}">Edit Artikel Gizi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('daerah.artikel.update', $artikelGizi->id) }}" method="POST">
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
                        <label for="judul{{ $artikelGizi->id }}">Judul</label>
                        <input type="text" class="form-control" id="judul{{ $artikelGizi->id }}" name="judul"
                            value="{{ old('judul', $artikelGizi->judul) }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="isi{{ $artikelGizi->id }}">Isi</label>
                        <textarea class="form-control" id="isi{{ $artikelGizi->id }}" name="isi" rows="6" required>{{ old('isi', $artikelGizi->isi) }}</textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label for="kategori{{ $artikelGizi->id }}">Kategori</label>
                        <select class="form-control" id="kategori{{ $artikelGizi->id }}" name="kategori" required>
                            <option value="anak"
                                {{ old('kategori', $artikelGizi->kategori) == 'anak' ? 'selected' : '' }}>Anak</option>
                            <option value="ibu_hamil"
                                {{ old('kategori', $artikelGizi->kategori) == 'ibu_hamil' ? 'selected' : '' }}>Ibu
                                Hamil</option>
                            <option value="lansia"
                                {{ old('kategori', $artikelGizi->kategori) == 'lansia' ? 'selected' : '' }}>Lansia
                            </option>
                            <option value="lainnya"
                                {{ old('kategori', $artikelGizi->kategori) == 'lainnya' ? 'selected' : '' }}>Lainnya
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
