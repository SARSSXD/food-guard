@extends('user.layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Data Produksi Pangan</h4>
                    <div class="form-group mb-3">
                        <label for="komoditas">Filter Komoditas</label>
                        <select class="form-control" id="komoditas">
                            <option value="">Semua</option>
                            <option value="Beras">Beras</option>
                            <option value="Jagung">Jagung</option>
                            <option value="Kedelai">Kedelai</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="lokasi">Filter Lokasi</label>
                        <select class="form-control" id="lokasi">
                            <option value="">Semua</option>
                            @foreach ($lokasi as $l)
                                <option value="{{ $l->name }}">{{ $l->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Komoditas</th>
                                    <th>Volume (Ton)</th>
                                    <th>Lokasi</th>
                                    <th>Waktu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($produksiPangan as $data)
                                    <tr>
                                        <td>{{ $data->komoditas }}</td>
                                        <td>{{ $data->volume }}</td>
                                        <td>{{ $data->lokasi->name }}</td>
                                        <td>{{ $data->waktu}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const komoditasFilter = document.getElementById('komoditas');
            const lokasiFilter = document.getElementById('lokasi');
            const rows = document.querySelectorAll('table tbody tr');

            function filterTable() {
                const komoditas = komoditasFilter.value.toLowerCase();
                const lokasi = lokasiFilter.value.toLowerCase();

                rows.forEach(row => {
                    const komoditasCell = row.cells[0].textContent.toLowerCase();
                    const lokasiCell = row.cells[2].textContent.toLowerCase();
                    const showRow = (!komoditas || komoditasCell === komoditas) && (!lokasi ||
                        lokasiCell === lokasi);
                    row.style.display = showRow ? '' : 'none';
                });
            }

            komoditasFilter.addEventListener('change', filterTable);
            lokasiFilter.addEventListener('change', filterTable);
        });
    </script>
@endsection
