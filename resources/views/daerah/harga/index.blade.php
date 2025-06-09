@extends('daerah.layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Data Harga Pangan</h4>
                    <button type="button" class="btn btn-primary btn-sm float-end" data-bs-toggle="modal"
                        data-bs-target="#createHargaModal">
                        Tambah Data
                    </button>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nama Pasar</th>
                                    <th>Komoditas</th>
                                    <th>Harga per Kg (Rp)</th>
                                    <th>Tanggal</th>
                                    <th>Lokasi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($harga as $item)
                                    <tr>
                                        <td>{{ $item->nama_pasar }}</td>
                                        <td>{{ $item->komoditas }}</td>
                                        <td>{{ number_format($item->harga_per_kg, 2) }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                                        <td>{{ $item->region->provinsi }} - {{ $item->region->kota }}</td>
                                        <td>
                                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editHargaModal{{ $item->id }}">
                                                Edit
                                            </button>
                                            <form action="{{ route('daerah.harga.destroy', $item->id) }}" method="POST"
                                                style="display: inline-block;" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @include('daerah.harga.edit', [
                                        'hargaPangan' => $item,
                                        'wilayah' => $wilayah,
                                    ])
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada data harga pangan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('daerah.harga.create')

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
