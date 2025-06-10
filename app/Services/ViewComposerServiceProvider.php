<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\ProduksiPangan;
use App\Models\PrediksiPangan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;

class ViewComposerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer(['nasional.layouts.app', 'nasional.partials.sidebar'], function ($view) {
            try {
                $pendingProduksiCount = ProduksiPangan::where('status_valid', 'pending')
                    ->where('created_at', '<', Carbon::now()->subDays(7))
                    ->count();

                $pendingPrediksiPangan = PrediksiPangan::where('status', 'draft')
                    ->where('created_at', '<', Carbon::now()->subDays(7))
                    ->count();

                Log::info('View Composer executed', [
                    'pending_produksi_count' => $pendingProduksiCount,
                    'pending_prediksi_pangan' => $pendingPrediksiPangan
                ]);

                $view->with([
                    'pendingProduksiCount' => $pendingProduksiCount,
                    'pendingPrediksiPangan' => $pendingPrediksiPangan
                ]);
            } catch (\Exception $e) {
                Log::error('View Composer failed', ['error' => $e->getMessage()]);
                $view->with([
                    'pendingProduksiCount' => 0,
                    'pendingPrediksiPangan' => 0
                ]);
            }
        });
    }
}
