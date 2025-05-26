@extends('nasional.layouts.app')

@section('content')
    <div class="row">
        @if ($pendingCount > 0)
            <div class="col-lg-12 grid-margin">
                <div class="alert alert-warning" role="alert">
                    <strong>Peringatan:</strong> Ada {{ $pendingCount }} data produksi pangan dengan status "pending" yang
                    belum divalidasi lebih dari 3 hari.
                </div>
            </div>
        @endif
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Data Produksi Pangan per Daerah</h4>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Komoditas</th>
                                    <th>Volume (Ton)</th>
                                    <th>Lokasi</th>
                                    <th>Waktu</th>
                                    <th>Status Validasi</th>
                                    <th>Pembuat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($produksiPangan as $data)
                                    <tr>
                                        <td>{{ $data->komoditas }}</td>
                                        <td>{{ number_format($data->volume, 2) }}</td>
                                        <td>{{ $data->lokasi->name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($data->waktu)->format('d M Y') }}</td>
                                        <td>
                                            <span
                                                class="badge {{ $data->status_valid == 'terverifikasi' ? 'badge-success' : 'badge-warning' }}">
                                                {{ ucfirst($data->status_valid) }}
                                            </span>
                                        </td>
                                        <td>{{ $data->creator->name }}</td>
                                        <td>
                                            @if ($data->status_valid == 'pending')
                                                <form method="POST"
                                                    action="{{ url('nasional/produksi/validasi/' . $data->Id_produksipangan) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-primary">Validasi</button>
                                                </form>
                                            @else
                                                <button class="btn btn-sm btn-success" disabled>Sudah Terverifikasi</button>
                                            @endif
                                        </td>
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
                    <h4 class="card-title">Tren Produksi Pangan Nasional</h4>
                    @if (empty($datasets) || collect($datasets)->pluck('data')->flatten()->sum() == 0)
                        <p class="text-muted">Tidak ada data produksi pangan yang tersedia untuk ditampilkan di grafik.</p>
                    @else
                        <canvas id="produksi-chart"></canvas>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Datasets:', @json($datasets));
            console.log('Labels:', @json($labels));
            @if (!empty($datasets) && collect($datasets)->pluck('data')->flatten()->sum() > 0)
                try {
                    var ctx = document.getElementById('produksi-chart').getContext('2d');
                    var chart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: @json($labels),
                            datasets: @json($datasets)
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Volume (Ton)'
                                    }
                                },
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Bulan'
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    display: true,
                                    position: 'top'
                                }
                            }
                        }
                    });
                } catch (error) {
                    console.error('Error rendering chart:', error);
                }
            @else
                console.log('No data available for chart.');
            @endif
        });
    </script>
@endsection
