@extends('daerah.layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Data Distribusi Pangan</h4>
                    <button type="button" class="btn btn-primary btn-sm float-end" data-bs-toggle="modal"
                        data-bs-target="#createDistribusiModal">
                        Tambah Data
                    </button>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Wilayah Tujuan</th>
                                    <th>Komoditas</th>
                                    <th>Jumlah (Ton)</th>
                                    <th>Tanggal Kirim</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($distribusi as $item)
                                    <tr>
                                        <td>{{ $item->region->provinsi }} - {{ $item->region->kota }}</td>
                                        <td>{{ $item->komoditas }}</td>
                                        <td>{{ $item->jumlah }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->tanggal_kirim)->format('d-m-Y') }}</td>
                                        <td>{{ $item->status }}</td>
                                        <td>
                                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editDistribusiModal{{ $item->id }}">
                                                Edit
                                            </button>
                                            <form action="{{ route('daerah.distribusi.destroy', $item->id) }}"
                                                method="POST" style="display: inline-block;" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @include('daerah.distribusi.edit', [
                                        'distribusiPangan' => $item,
                                        'wilayah' => $wilayah,
                                    ])
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada data distribusi pangan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('daerah.distribusi.create')

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
