@extends('daerah.layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Data Produksi Pangan Terbaru</h4>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Komoditas</th>
                                    <th>Volume (Ton)</th>
                                    <th>Lokasi</th>
                                    <th>Waktu</th>
                                    <th>Status Validasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($produksiPangan as $data)
                                    <tr>
                                        <td>{{ $data->komoditas }}</td>
                                        <td>{{ $data->volume }}</td>
                                        <td>{{ $data->lokasi->name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($data->waktu)->format('d M Y') }}</td>
                                        <td>{{ $data->status_valid }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Input Data Produksi Pangan</h4>
                    <form method="POST" action="{{ url('daerah/produksi/store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="komoditas">Komoditas</label>
                            <select class="form-control" id="komoditas" name="komoditas" required>
                                <option value="Beras">Beras</option>
                                <option value="Jagung">Jagung</option>
                                <option value="Kedelai">Kedelai</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="volume">Volume (Ton)</label>
                            <input type="number" class="form-control" id="volume" name="volume" required>
                        </div>
                        <div class="form-group">
                            <label for="lokasi">Lokasi</label>
                            <select class="form-control" id="lokasi" name="Id_lokasi" required>
                                @foreach ($lokasi as $l)
                                    <option value="{{ $l->Id_lokasi }}">{{ $l->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="waktu">Waktu</label>
                            <input type="date" class="form-control" id="waktu" name="waktu" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
