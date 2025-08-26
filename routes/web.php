<?php

use App\Http\Controllers\Admin\AtributController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DosenController;
use App\Http\Controllers\Admin\DosenPenelitianController;
use App\Http\Controllers\Admin\JudulController;
use App\Http\Controllers\Admin\KeahlianController;
use App\Http\Controllers\Admin\KeahlianDosenController;
use App\Http\Controllers\Admin\KehalianJudulDosenController;
use App\Http\Controllers\Admin\KonsentrasiController;
use App\Http\Controllers\Admin\ProdiController;
use App\Http\Controllers\Admin\MatkulDosenController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\NaiveBayesController;
use App\Http\Controllers\Admin\NaiveCobaController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserMenuController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\App\TitleAnalysisController;
use App\Http\Controllers\App\TitleClassificationController;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\Auth\LoginController as Auths;
use App\Http\Controllers\Api\MahasiswaProxyController;
use App\Http\Controllers\App\PengajuanController;
use App\Http\Controllers\SkPembimbingController;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/{any}', [App\Http\Controllers\PagesController::class, 'index'])->where('any', '.*');


// Auth::routes();

// Route::resource('photos', PhotoController::class)->except(['create', 'store', 'update', 'destroy']);
// Route::resource('photos', PhotoController::class)->only(['index', 'show']);



Route::domain('')->group(function () { // development
    // Route::domain('permohonan.bpfkmakassar.go.id')->group(function () { // production

    // Auth::routes();
    Route::get('/auth/login', [Auths::class, 'index'])->name('admin.login');
    Route::post('/auth/login', [Auths::class, 'login'])->name('login');
    // Route::get('/auth/register', [App\Http\Controllers\HomeController::class, 'register']);
    // Route::post('/auth/register', [App\Http\Controllers\HomeController::class, 'registerStore']);

    Route::get('/logout', [Auths::class, 'logout'])->middleware('auth')->name('logout');

    // Route untuk unauthorized access
    Route::get('/unauthorized', function () {
        return view('errors.unauthorized');
    })->name('unauthorized');

    // Test route untuk debugging
    Route::get('/test-admin', function () {
        return 'Test route working';
    })->name('test.admin');

    // Route untuk similarity check
    Route::post('/title/similarity', [TitleAnalysisController::class, 'checkTitleSimilarity'])->name('title.similarity');

    // Route untuk classification
    Route::post('/title/classify', [TitleAnalysisController::class, 'classifyTitleTopic'])->name('title.classify');

    // Route untuk combined analysis
    Route::post('/title/analyze', [TitleAnalysisController::class, 'analyzeTitle'])->name('title.analyze');


    Route::group(['prefix' => 'mahasiswa', 'middleware' => ['auth', 'checkRole:3']], function () {
        Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
        Route::group(['prefix' => '/pengajuan-judul'], function () {
            Route::get('/', [PengajuanController::class, 'index'])->name('pengajuan.index');
            Route::get('/data', [PengajuanController::class, 'data'])->name('pengajuan.data');
            Route::get('/{id}/detail', [PengajuanController::class, 'show'])->name('judul.detail');
            Route::delete('/{id}', [PengajuanController::class, 'destroy'])->name('pengajuan.destroy');
            Route::post('/judul/{id}/approve', [PengajuanController::class, 'approveByNim2'])->name('judul.approve');
            Route::post('/judul/{id}/reject', [PengajuanController::class, 'rejectByNim2'])->name('judul.reject');
            Route::get('/judul/{id}/edit-step2', [PengajuanController::class, 'editStep2'])->name('judul.edit.step2');
            Route::prefix('create')->group(function () {
                Route::post('/store', [PengajuanController::class, 'store'])->name('pengajuan.store');
                Route::get('/step-1', [PengajuanController::class, 'step1'])->name('pengajuan.step1');
                Route::get('/step-2', [PengajuanController::class, 'step2'])->name('pengajuan.step2');
                Route::get('/step-3', [PengajuanController::class, 'step3'])->name('pengajuan.step3');
            });
        });
    });


    // ADMIN_ROUTES
    Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'checkRole:1|2']], function () {

        Route::get('/', [DashboardController::class, 'index'])->name('admin');
        Route::get('/tes', [DashboardController::class, 'data'])->name('data.test');
        // routes/web.php
        // Route::get('/pengajuan/{id}/rekomendasi', [PembimbingController::class, 'getRecommendation']);
        // Route::post('/pengajuan/{id}/assign-pembimbing', [PembimbingController::class, 'assignSupervisors']);

        // Route::get('/rekomendasi-pembimbing', [NaiveBayesController::class, 'index'])->name('assignment');
        // Route::get('/judul-pengajuan/{id}', [NaiveBayesController::class, 'getJudulPengajuan'])->name('getjudul.pengajuan');
        // Route::post('/save-assignment', [NaiveBayesController::class, 'saveAssignment'])->name('save.assignment');

        Route::get('/rekomendasi-pembimbing', [NaiveCobaController::class, 'index'])->name('assignment');
        Route::get('/judul-pengajuan/{id}', [NaiveCobaController::class, 'getJudulPengajuan'])->name('getjudul.pengajuan.tes');
        Route::get('/hasil-algoritma', [NaiveCobaController::class, 'hasilAlgoritma'])->name('hasil.algoritma');
        Route::post('/simpan-assignment', [NaiveCobaController::class, 'assign'])->name('pembimbing.assign');

        Route::get('/sk-pembimbing/{id}/pdf', [SkPembimbingController::class, 'generatePDF'])->name('sk-pembimbing.pdf');


        # APPS ROUTES
        Route::group(['prefix' => '/judul'], function () {
            Route::get('/', [JudulController::class, 'index'])->name('judul.index');
            Route::get('/data', [JudulController::class, 'data'])->name('judul.data');
            Route::get('/create', [JudulController::class, 'create'])->name('judul.create');
            Route::post('/store', [JudulController::class, 'store'])->name('judul.store');
            Route::get('/{id}/edit', [JudulController::class, 'edit'])->name('judul.edit');
            Route::put('/{id}', [JudulController::class, 'update'])->name('judul.update');
            Route::delete('/{id}', [JudulController::class, 'destroy'])->name('judul.delete');
            Route::post('/api/check-title-similarity', [TitleClassificationController::class, 'checkTitleSimilarity'])
                ->name('admin.check.title.similarity');
        });

        Route::group(['prefix' => '/prodi'], function () {
            Route::get('/', [ProdiController::class, 'index'])->name('prodi.index');
            Route::get('/data', [ProdiController::class, 'data'])->name('prodi.data');
            Route::get('/create', [ProdiController::class, 'create'])->name('prodi.create');
            Route::post('/store', [ProdiController::class, 'store'])->name('prodi.store');
            Route::get('/{id}/edit', [ProdiController::class, 'edit'])->name('prodi.edit');
            Route::put('/{id}', [ProdiController::class, 'update'])->name('prodi.update');
            Route::delete('/{id}', [ProdiController::class, 'destroy'])->name('prodi.delete');
        });

        Route::group(['prefix' => '/dosen-penelitian'], function () {
            Route::get('/', [DosenPenelitianController::class, 'index'])->name('dosen-penelitian.index');
            Route::get('/data', [DosenPenelitianController::class, 'data'])->name('dosen-penelitian.data');
            Route::get('/create', [DosenPenelitianController::class, 'create'])->name('dosen-penelitian.create');
            Route::post('/store', [DosenPenelitianController::class, 'store'])->name('dosen-penelitian.store');
            Route::get('/{id}/edit', [DosenPenelitianController::class, 'edit'])->name('dosen-penelitian.edit');
            Route::put('/{id}', [DosenPenelitianController::class, 'update'])->name('dosen-penelitian.update');
            Route::delete('/{id}', [DosenPenelitianController::class, 'destroy'])->name('dosen-penelitian.delete');
        });

        Route::group(['prefix' => '/keahlian'], function () {
            Route::get('/', [KeahlianController::class, 'index'])->name('keahlian.index');
            Route::get('/data', [KeahlianController::class, 'data'])->name('keahlian.data');
            Route::get('/create', [KeahlianController::class, 'create'])->name('keahlian.create');
            Route::post('/store', [KeahlianController::class, 'store'])->name('keahlian.store');
            Route::get('/{id}/edit', [KeahlianController::class, 'edit'])->name('keahlian.edit');
            Route::put('/{id}', [KeahlianController::class, 'update'])->name('keahlian.update');
            Route::delete('/{id}', [KeahlianController::class, 'destroy'])->name('keahlian.delete');
        });
        Route::group(['prefix' => '/konsentrasi'], function () {
            Route::get('/', [KonsentrasiController::class, 'index'])->name('konsentrasi.index');
            Route::get('/data', [KonsentrasiController::class, 'data'])->name('konsentrasi.data');
            Route::get('/create', [KonsentrasiController::class, 'create'])->name('konsentrasi.create');
            Route::post('/store', [KonsentrasiController::class, 'store'])->name('konsentrasi.store');
            Route::get('/{id}/edit', [KonsentrasiController::class, 'edit'])->name('konsentrasi.edit');
            Route::put('/{id}', [KonsentrasiController::class, 'update'])->name('konsentrasi.update');
            Route::delete('/{id}', [KonsentrasiController::class, 'destroy'])->name('konsentrasi.delete');
        });

        Route::group(['prefix' => '/atribut'], function () {
            Route::get('/', [AtributController::class, 'index'])->name('atribut.index');
            Route::get('/data', [AtributController::class, 'data'])->name('atribut.data');
            Route::get('/create', [AtributController::class, 'create'])->name('atribut.create');
            Route::post('/store', [AtributController::class, 'store'])->name('atribut.store');
            Route::get('/{id}/edit', [AtributController::class, 'edit'])->name('atribut.edit');
            Route::put('/{id}', [AtributController::class, 'update'])->name('atribut.update');
            Route::delete('/{id}', [AtributController::class, 'destroy'])->name('atribut.delete');
        });

        Route::group(['prefix' => '/keahlian-dosen'], function () {
            Route::get('/', [KeahlianDosenController::class, 'index'])->name('keahlian-dosen.index');
            Route::get('/data', [KeahlianDosenController::class, 'data'])->name('keahlian-dosen.data');
            Route::get('/create', [KeahlianDosenController::class, 'create'])->name('keahlian-dosen.create');
            Route::post('/store', [KeahlianDosenController::class, 'store'])->name('keahlian-dosen.store');
            Route::get('/{id}/edit', [KeahlianDosenController::class, 'edit'])->name('keahlian-dosen.edit');
            Route::put('/{id}', [KeahlianDosenController::class, 'update'])->name('keahlian-dosen.update');
            Route::delete('/{id}', [KeahlianDosenController::class, 'destroy'])->name('keahlian-dosen.delete');
        });

        Route::group(['prefix' => '/matkul-dosen'], function () {
            Route::get('/', [MatkulDosenController::class, 'index'])->name('matkul-dosen.index');
            Route::get('/data', [MatkulDosenController::class, 'data'])->name('matkul-dosen.data');
            Route::get('/create', [MatkulDosenController::class, 'create'])->name('matkul-dosen.create');
            Route::post('/store', [MatkulDosenController::class, 'store'])->name('matkul-dosen.store');
            Route::get('/{id}/edit', [MatkulDosenController::class, 'edit'])->name('matkul-dosen.edit');
            Route::put('/{id}', [MatkulDosenController::class, 'update'])->name('matkul-dosen.update');
            Route::delete('/{id}', [MatkulDosenController::class, 'destroy'])->name('matkul-dosen.delete');
        });

        Route::group(['prefix' => '/dosen'], function () {
            Route::get('/', [DosenController::class, 'index'])->name('dosen.index');
            Route::get('/data', [DosenController::class, 'data'])->name('dosen.data');
            Route::get('/create', [DosenController::class, 'create'])->name('dosen.create');
            Route::post('/store', [DosenController::class, 'store'])->name('dosen.store');
            Route::get('/{id}/edit', [DosenController::class, 'edit'])->name('dosen.edit');
            Route::put('/{id}', [DosenController::class, 'update'])->name('dosen.update');
            Route::delete('/{id}', [DosenController::class, 'destroy'])->name('dosen.delete');
        });

        Route::group(['prefix' => '/keahlian-judul-dosen'], function () {
            Route::get('/', [KehalianJudulDosenController::class, 'index'])->name('keahlian-judul-dosen.index');
            Route::get('/data', [KehalianJudulDosenController::class, 'data'])->name('keahlian-judul-dosen.data');
            Route::get('/create', [KehalianJudulDosenController::class, 'create'])->name('keahlian-judul-dosen.create');
            Route::post('/store', [KehalianJudulDosenController::class, 'store'])->name('keahlian-judul-dosen.store');
            Route::get('/{id}/edit', [KehalianJudulDosenController::class, 'edit'])->name('keahlian-judul-dosen.edit');
            Route::put('/{id}', [KehalianJudulDosenController::class, 'update'])->name('keahlian-judul-dosen.update');
            Route::delete('/{id}', [KehalianJudulDosenController::class, 'destroy'])->name('keahlian-judul-dosen.delete');
        });


        # USER SETTING
        Route::group(['prefix' => '/roles'], function () {
            Route::get('/', [RoleController::class, 'index'])->name('roles.index');
            Route::get('/data', [RoleController::class, 'data'])->name('roles.data');
            Route::get('/create', [RoleController::class, 'create'])->name('roles.create');
            Route::post('/store', [RoleController::class, 'store'])->name('roles.store');
            Route::get('/{id}/edit', [RoleController::class, 'edit'])->name('roles.edit');
            Route::put('/{id}', [RoleController::class, 'update'])->name('roles.update');
            Route::delete('/{id}', [RoleController::class, 'destroy'])->name('roles.delete');
        });

        Route::group(['prefix' => '/menus'], function () {
            Route::get('/', [MenuController::class, 'index'])->name('menus.index');
            Route::get('/data', [MenuController::class, 'data'])->name('menus.data');
            Route::get('/create', [MenuController::class, 'create'])->name('menus.create');
            Route::post('/store', [MenuController::class, 'store'])->name('menus.store');
            Route::get('/{id}/edit', [MenuController::class, 'edit'])->name('menus.edit');
            Route::put('/{id}', [MenuController::class, 'update'])->name('menus.update');
            Route::delete('/{id}', [MenuController::class, 'destroy'])->name('menus.delete');
        });

        Route::group(['prefix' => '/user-menus'], function () {
            Route::get('/', [UserMenuController::class, 'index'])->name('user-menus.index');
            Route::get('/data', [UserMenuController::class, 'data'])->name('user-menus.data');
            Route::post('/store', [UserMenuController::class, 'store'])->name('user-menus.store');
            Route::get('/{id}/edit', [UserMenuController::class, 'edit'])->name('user-menus.edit');
            Route::get('/{id}/show', [UserMenuController::class, 'show'])->name('user-menus.show');
            Route::delete('/{id}', [UserMenuController::class, 'destroy'])->name('user-menus.delete');
        });
        Route::get('user-menus/create/{id}', [UserMenuController::class, 'create'])->name('user-menus.create');


        Route::group(['prefix' => '/users'], function () {
            Route::get('/', [UsersController::class, 'index'])->name('users.index');
            Route::get('/data', [UsersController::class, 'data'])->name('users.data');
            Route::get('/create', [UsersController::class, 'create'])->name('users.create');
            Route::post('/store', [UsersController::class, 'store'])->name('users.store');
            Route::get('/{id}/edit', [UsersController::class, 'edit'])->name('users.edit');
            Route::put('/{id}', [UsersController::class, 'update'])->name('users.update');
            Route::delete('/{id}', [UsersController::class, 'destroy'])->name('users.delete');
        });

        Route::group(['prefix' => '/settings'], function () {
            Route::get('/', [SettingController::class, 'index'])->name('settings.index');
            Route::get('/data', [SettingController::class, 'data'])->name('settings.data');
            Route::get('/create', [SettingController::class, 'create'])->name('settings.create');
            Route::post('/store', [SettingController::class, 'store'])->name('settings.store');
            Route::get('/{id}/edit', [SettingController::class, 'edit'])->name('settings.edit');
            Route::put('/{id}', [SettingController::class, 'update'])->name('settings.update');
            Route::delete('/{id}', [SettingController::class, 'destroy'])->name('settings.delete');
        });
    });
});


// Proxy API Mahasiswa untuk frontend (tanpa middleware, agar tidak kena CORS)
Route::group(['prefix' => '/api'], function () {
    Route::post('/check-title-similarity', [TitleClassificationController::class, 'checkTitleSimilarity'])
        ->name('check.title.similarity');
    Route::get('/mahasiswa-list', MahasiswaProxyController::class);
    // Route::get('/dosen/{nidn}/predict', [KeahlianController::class, 'predict']);
    // Route::post('/dosen/{nidn}/assign-keahlian', [KeahlianController::class, 'assignKeahlian']);
    // Route::post('/generate-keahlian-dosen', [KeahlianController::class, 'generateAllKeahlian'])->name('keahlian.generate-all');
});
