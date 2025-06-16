@extends('user.layouts.app')

@section('content')
    <section class="section">
        <div class="container">
            <h2 class="mb-4" data-aos="fade-up">Data Distribusi Pangan</h2>

            <!-- Filter -->
            <div class="card shadow mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card-body">
                    <form method="GET" action="{{ route('distribusi.index') }}">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="kota" class="form-label fw-bold">Kota Tujuan</label>
                                <select name="kota" id="kota" class="form-control">
                                    <option value="">Semua Kota</option>
                                    @foreach ($kotaList as $kotaItem)
                                        <option value="{{ $kotaItem }}" {{ $kota == $kotaItem ? 'selected' : '' }}>
                                            {{ $kotaItem }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-search"></i> Cari
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Info Distribusi -->
            <div class="card shadow mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card-body">
                    <h5 class="card-title">Total Distribusi Pangan {{ $kota ? "ke $kota" : 'Nasional' }}</h5>
                    <p class="card-text fs-3 fw-bold text-primary">
                        {{ number_format($totalDistribusi, 2, ',', '.') }} Ton
                    </p>
                    <p class="card-text text-muted">
                        Data distribusi pangan {{ $kota ? "ke kota $kota" : 'di seluruh Indonesia' }}.
                    </p>
                </div>
            </div>

            <!-- Tabel Distribusi -->
            @if ($distribusiData->isNotEmpty())
                <div class="card shadow mb-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="card-body">
                        <h5 class="card-title">Daftar Distribusi Pangan</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th>Komoditas</th>
                                        <th>Jumlah (Ton)</th>
                                        <th>Tanggal Kirim</th>
                                        <th>Status</th>
                                        <th>Kota Tujuan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($distribusiData as $item)
                                        <tr>
                                            <td>{{ $item->komoditas }}</td>
                                            <td>{{ number_format($item->jumlah, 2, ',', '.') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->tanggal_kirim)->format('d-m-Y') }}</td>
                                            <td>{{ ucfirst($item->status) }}</td>
                                            <td>{{ $item->region->kota }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @else
                <div class="card shadow mb-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="card-body">
                        <p class="text-muted">Tidak ada data distribusi pangan untuk
                            {{ $kota ? "kota $kota" : 'seluruh Indonesia' }}.</p>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
