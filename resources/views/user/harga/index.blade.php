@extends('user.layouts.app')

@section('content')
    <section class="section">
        <div class="container">
            <h2 class="mb-4" data-aos="fade-up">Data Harga Pangan</h2>

            <!-- Filter -->
            <div class="card shadow mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card-body">
                    <form method="GET" action="{{ route('harga-pangan.index') }}">
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

            <!-- Cards Harga -->
            <div class="row">
                @foreach ($komoditasList as $komoditas)
                    <div class="col-md-4 mb-4" data-aos="fade-up">
                        <div class="card shadow border-0 h-100"
                            style="background: url('{{ asset('/assetslp/img/' . strtolower($komoditas) . '.jpeg') }}') center/cover no-repeat;">
                            <div class="card-body text-white d-flex flex-column justify-content-between"
                                style="background: rgba(0, 0, 0, 0.6);">
                                <h5 class="card-title">
                                    {{ $kota ? "Harga $komoditas di $kota" : "Rata-rata Harga $komoditas" }}
                                    {{ !$hargaData[$komoditas] ? 'Tidak Tersedia' : '' }}
                                </h5>
                                <p class="card-text fs-3 fw-bold">
                                    {{ $hargaData[$komoditas] ? 'Rp ' . number_format($hargaData[$komoditas], 0, ',', '.') . '/kg' : 'N/A' }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
