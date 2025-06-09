<div class="modal fade" id="editPrediksiModal{{ $prediksiPangan->id }}" tabindex="-1"
    aria-labelledby="editPrediksiModalLabel{{ $prediksiPangan->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPrediksiModalLabel{{ $prediksiPangan->id }}">Edit Data Prediksi Pangan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('daerah.prediksi.update', $prediksiPangan->id) }}" method="POST">
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
                        <label for="status{{ $prediksiPangan->id }}">Status</label>
                        <select class="form-control" id="status{{ $prediksiPangan->id }}" name="status" required>
                            <option value="draft"
                                {{ old('status', $prediksiPangan->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="disetujui"
                                {{ old('status', $prediksiPangan->status) == 'disetujui' ? 'selected' : '' }}>Disetujui
                            </option>
                            <option value="revisi"
                                {{ old('status', $prediksiPangan->status) == 'revisi' ? 'selected' : '' }}>Revisi
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
