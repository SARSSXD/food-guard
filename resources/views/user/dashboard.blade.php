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
                            <option value="Jawa Barat">Jawa Barat</option>
                            <option value="Jawa Timur">Jawa Timur</option>
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
                                <!-- Data dummy untuk ilustrasi -->
                                <tr>
                                    <td>Beras</td>
                                    <td>5000</td>
                                    <td>Jawa Barat</td>
                                    <td>25 Mei 2025</td>
                                </tr>
                                <tr>
                                    <td>Jagung</td>
                                    <td>3000</td>
                                    <td>Jawa Timur</td>
                                    <td>24 Mei 2025</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
