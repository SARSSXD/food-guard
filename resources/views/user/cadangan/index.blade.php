@extends('user.layouts.app')

@section('content')
    <section class="section">
        <div class="container">
            <h2 class="mb-4" data-aos="fade-up">Data Cadangan Pangan</h2>

            <!-- Filter -->
            <div class="card shadow mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card-body">
                    <form method="GET" action="{{ route('cadangan.index') }}">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="kota" class="form-label fw-bold">Kota</label>
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

            <!-- Info Cadangan -->
            <div class="card shadow mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card-body">
                    <h5 class="card-title">Total Cadangan Pangan {{ $kota ? "di $kota" : 'Nasional' }}</h5>
                    <p class="card-text fs-3 fw-bold text-primary">
                        {{ number_format($totalCadangan, 2, ',', '.') }} Ton
                    </p>
                    <p class="card-text text-muted">
                        Data cadangan pangan yang telah terverifikasi
                        {{ $kota ? "untuk kota $kota" : 'di seluruh Indonesia' }}.
                    </p>
                </div>
            </div>

            <!-- Tabel Cadangan -->
            @if ($cadanganData->isNotEmpty())
                <div class="card shadow mb-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title mb-0">Daftar Cadangan Pangan</h5>
                            <form method="POST" action="{{ route('cadangan.export') }}">
                                @csrf
                                <input type="hidden" name="kota" value="{{ $kota }}">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-download"></i> Ekspor Excel
                                </button>
                            </form>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th>Komoditas</th>
                                        <th>Jumlah (Ton)</th>
                                        <th>Periode</th>
                                        {{-- <th>Status</th> --}}
                                        <th>Kota</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cadanganData as $item)
                                        <tr>
                                            <td>{{ $item->komoditas }}</td>
                                            <td>{{ number_format($item->jumlah, 2, ',', '.') }}</td>
                                            <td>{{ $item->periode }}</td>
                                            {{-- <td>{{ ucfirst($item->status_valid) }}</td> --}}
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
                        <p class="text-muted">Tidak ada data cadangan pangan yang terverifikasi untuk
                            {{ $kota ? "kota $kota" : 'seluruh Indonesia' }}.</p>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
