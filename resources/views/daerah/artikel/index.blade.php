@extends('daerah.layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Data Artikel Gizi</h4>
                    <button type="button" class="btn btn-primary btn-sm float-end" data-bs-toggle="modal"
                        data-bs-target="#createArtikelModal">
                        Tambah Artikel
                    </button>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Judul</th>
                                    <th>Kategori</th>
                                    <th>Isi</th>
                                    <th>Jumlah Akses</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($artikel as $item)
                                    <tr>
                                        <td>{{ $item->judul }}</td>
                                        <td>{{ $item->kategori }}</td>
                                        <td
                                            style="
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    max-width: 300px;
">
                                            {{ $item->isi }}
                                        </td>

                                        <td>{{ $item->jumlah_akses }}</td>
                                        <td>
                                            @if ($item->id_penulis == Auth::user()->id)
                                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#editArtikelModal{{ $item->id }}">
                                                    Edit
                                                </button>
                                                <form action="{{ route('daerah.artikel.destroy', $item->id) }}"
                                                    method="POST" style="display: inline-block;" class="delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                                </form>
                                            @else
                                                dapat diubah oleh penulis artikel ini saja
                                            @endif
                                        </td>
                                    </tr>
                                    @include('daerah.artikel.edit', ['artikelGizi' => $item])
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Tidak ada artikel gizi.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('daerah.artikel.create')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    if (confirm('Apakah Anda yakin ingin menghapus artikel ini?')) {
                        this.submit();
                    }
                });
            });
        });
    </script>
@endsection
