@extends('user.layouts.app')

@section('content')
    <section class="section">
        <div class="container">
            <h2 class="mb-4" data-aos="fade-up">Edukasi Gizi</h2>

            <!-- Filter -->
            <div class="card shadow mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card-body">
                    <form method="GET" action="{{ route('edukasi.index') }}">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="kategori" class="form-label fw-bold">Kategori</label>
                                <select name="kategori" id="kategori" class="form-control">
                                    <option value="">Semua Kategori</option>
                                    @foreach ($kategoriList as $kategoriItem)
                                        <option value="{{ $kategoriItem }}"
                                            {{ $kategori == $kategoriItem ? 'selected' : '' }}>
                                            {{ $kategoriItem }}
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

            <!-- Ringkasan Kategori -->
            <div class="card shadow mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card-body">
                    <h5 class="card-title">Ringkasan Artikel Gizi</h5>
                    <ul class="list-group list-group-flush">
                        @foreach ($kategoriCounts as $kategoriItem => $count)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $kategoriItem }}
                                <span class="badge bg-primary rounded-pill">{{ $count }} artikel</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Daftar Artikel -->
            @if ($artikelData->isNotEmpty())
                <div class="row">
                    @foreach ($artikelData as $artikel)
                        <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="300">
                            <div class="card shadow h-100">
                                <img src="{{ asset('/assetslp/img/gizi.jpg') }}" class="card-img-top"
                                    alt="{{ $artikel->judul }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{ Str::limit($artikel->judul, 50) }}</h5>
                                    <p class="card-text text-muted">{{ $artikel->kategori }}</p>
                                    <p class="card-text"><small><i class="fas fa-eye"></i> {{ $artikel->jumlah_akses }}
                                            akses</small></p>
                                </div>
                                <div class="card-footer">
                                    <a href="{{ route('edukasi.show', $artikel->id) }}" class="btn btn-primary btn-sm">Baca
                                        Selengkapnya</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="card shadow mb-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="card-body">
                        <p class="text-muted">Tidak ada artikel gizi untuk kategori {{ $kategori ?: 'semua' }}.</p>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
