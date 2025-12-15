<?php

namespace App\Providers;

use App\Http\Services\Repositories\AnggotaKelompokRepository;
use App\Http\Services\Repositories\AtributRepository;
use App\Http\Services\Repositories\BaseRepository;
use App\Http\Services\Repositories\Contracts\AnggotaKelompokContract;
use App\Http\Services\Repositories\Contracts\AtributContract;
use App\Http\Services\Repositories\Contracts\BaseContract;
use App\Http\Services\Repositories\Contracts\DosenContract;
use App\Http\Services\Repositories\Contracts\DosenPenelitianContract;
use App\Http\Services\Repositories\Contracts\DosenPenelitianKeahlianContract;
use App\Http\Services\Repositories\Contracts\DosenRecommenderContract;
use App\Http\Services\Repositories\Contracts\JudulContract;
use App\Http\Services\Repositories\Contracts\KeahlianContract;
use App\Http\Services\Repositories\Contracts\KeahlianDosenContract;
use App\Http\Services\Repositories\Contracts\KeahlianJudulDosenContract;
use App\Http\Services\Repositories\Contracts\KelompokContract;
use App\Http\Services\Repositories\Contracts\KonsentrasiContract;
use App\Http\Services\Repositories\Contracts\MahasiswaContract;
use App\Http\Services\Repositories\Contracts\MatkulDosenContract;
use App\Http\Services\Repositories\Contracts\MenuContract;
use App\Http\Services\Repositories\Contracts\PembimbingContract;
use App\Http\Services\Repositories\Contracts\PengajuanJudulContract;
use App\Http\Services\Repositories\Contracts\PengusulJudulContract;
use App\Http\Services\Repositories\Contracts\ProdiContract;
use App\Http\Services\Repositories\Contracts\RoleContract;
use App\Http\Services\Repositories\Contracts\SettingContract;
use App\Http\Services\Repositories\Contracts\UserMenuContract;
use App\Http\Services\Repositories\Contracts\UsersContract;
use App\Http\Services\Repositories\DosenPenelitianKeahlianRepository;
use App\Http\Services\Repositories\DosenPenelitianRepository;
use App\Http\Services\Repositories\DosenRecommenderRepository;
use App\Http\Services\Repositories\DosenRepository;
use App\Http\Services\Repositories\JudulRepository;
use App\Http\Services\Repositories\KeahlianDosenRepository;
use App\Http\Services\Repositories\KeahlianJudulDosenRepository;
use App\Http\Services\Repositories\KeahlianRepository;
use App\Http\Services\Repositories\KelompokRepository;
use App\Http\Services\Repositories\KonsentrasiRepository;
use App\Http\Services\Repositories\MahasiswaRepository;
use App\Http\Services\Repositories\MatkulDosenRepository;
use App\Http\Services\Repositories\MenuRepository;
use App\Http\Services\Repositories\PembimbingRepository;
use App\Http\Services\Repositories\PengajuanJudulRepository;
use App\Http\Services\Repositories\PengusulJudulRepository;
use App\Http\Services\Repositories\ProdiRepository;
use App\Http\Services\Repositories\RoleRepository;
use App\Http\Services\Repositories\SettingRepository;
use App\Http\Services\Repositories\UserMenuRepository;
use App\Http\Services\Repositories\UsersRepository;
use Illuminate\Support\ServiceProvider;

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
        $this->app->bind(BaseContract::class, BaseRepository::class);

        $this->app->bind(MenuContract::class, MenuRepository::class);
        $this->app->bind(RoleContract::class, RoleRepository::class);
        $this->app->bind(SettingContract::class, SettingRepository::class);
        $this->app->bind(UserMenuContract::class, UserMenuRepository::class);
        $this->app->bind(UsersContract::class, UsersRepository::class);

        $this->app->bind(JudulContract::class, JudulRepository::class);
        $this->app->bind(DosenContract::class, DosenRepository::class);
        $this->app->bind(ProdiContract::class, ProdiRepository::class);
        $this->app->bind(KeahlianContract::class, KeahlianRepository::class);
        $this->app->bind(DosenRecommenderContract::class, DosenRecommenderRepository::class);
        $this->app->bind(MatkulDosenContract::class, MatkulDosenRepository::class);
        $this->app->bind(DosenPenelitianContract::class, DosenPenelitianRepository::class);
        $this->app->bind(KeahlianJudulDosenContract::class, KeahlianJudulDosenRepository::class);
        $this->app->bind(KeahlianDosenContract::class, KeahlianDosenRepository::class);
        $this->app->bind(AtributContract::class, AtributRepository::class);
        $this->app->bind(DosenPenelitianKeahlianContract::class, DosenPenelitianKeahlianRepository::class);


        $this->app->bind(KonsentrasiContract::class, KonsentrasiRepository::class);
        $this->app->bind(PengusulJudulContract::class, PengusulJudulRepository::class);
        $this->app->bind(PembimbingContract::class, PembimbingRepository::class);
    }
}
