@extends('daerah.layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Data Cadangan Pangan</h4>
                    <button type="button" class="btn btn-primary btn-sm float-end" data-bs-toggle="modal"
                        data-bs-target="#createCadanganModal">
                        Tambah Data
                    </button>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Komoditas</th>
                                    <th>Jumlah (Ton)</th>
                                    <th>Lokasi</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($cadangan as $item)
                                    <tr>
                                        <td>{{ $item->komoditas }}</td>
                                        <td>{{ $item->jumlah }}</td>
                                        <td>{{ $item->region->provinsi }} - {{ $item->region->kota }}</td>
                                        <td>{{ $item->status_valid }}</td>
                                        <td>
                                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editCadanganModal{{ $item->id }}">
                                                Edit
                                            </button>
                                            <form action="{{ route('daerah.cadangan.destroy', $item->id) }}" method="POST"
                                                style="display: inline-block;" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @include('daerah.cadangan.edit', [
                                        'cadanganPangan' => $item,
                                        'wilayah' => $wilayah,
                                    ])
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Tidak ada data cadangan pangan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('daerah.cadangan.create')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                        this.submit();
                    }
                });
            });
        });
    </script>
@endsection
