<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use App\Models\KKN;
use App\Models\KKNAktivitas;
use App\Models\PermintaanAkademik;
use App\Models\PermintaanAkademikProgress;
use App\Models\AktivitasMahasiswaLog;
use App\Observers\KKNObserver;
use App\Observers\KKNAktivitasObserver;
use App\Observers\PermintaanAkademikObserver;
use App\Observers\PermintaanAkademikProgressObserver;
use App\Observers\AktivitasMahasiswaLogObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);
        
        // Register observers untuk auto-sync realtime
        KKN::observe(KKNObserver::class);
        KKNAktivitas::observe(KKNAktivitasObserver::class);
        PermintaanAkademik::observe(PermintaanAkademikObserver::class);
        PermintaanAkademikProgress::observe(PermintaanAkademikProgressObserver::class);
        AktivitasMahasiswaLog::observe(AktivitasMahasiswaLogObserver::class);
    }
}
