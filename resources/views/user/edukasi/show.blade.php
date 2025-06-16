@extends('user.layouts.app')

@section('content')
    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="card shadow mb-4" data-aos="fade-up">
                        <img src="{{ asset('/assetslp/img/gizi.jpg') }}" class="card-img-top"
                            alt="{{ $artikel->judul }}">
                        <div class="card-body">
                            <h2 class="card-title mb-3">{{ $artikel->judul }}</h2>
                            <div class="d-flex flex-wrap gap-3 mb-4 text-muted">
                                <span><i class="fas fa-folder"></i> {{ $artikel->kategori }}</span>
                                <span><i class="fas fa-user"></i> {{ $artikel->author->name ?? 'Unknown' }}</span>
                                <span><i class="fas fa-eye"></i> {{ $artikel->jumlah_akses }} akses</span>
                                <span><i class="fas fa-calendar"></i>
                                    {{ $artikel->created_at->translatedFormat('d F Y') }}</span>
                            </div>
                            <div class="artikel-content">
                                {!! nl2br(e($artikel->isi)) !!}
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between align-items-center">
                            <a href="{{ route('edukasi.index', ['kategori' => request()->query('kategori')]) }}"
                                class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <span class="text-muted">Diperbarui:
                                {{ $artikel->updated_at->translatedFormat('d F Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .artikel-content {
            line-height: 1.8;
            font-size: 1.1rem;
        }

        .artikel-content p {
            margin-bottom: 1.5rem;
        }
    </style>
@endsection
