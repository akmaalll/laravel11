<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DosenController;
use App\Http\Controllers\Admin\JudulController;
use App\Http\Controllers\admin\JudulKlasifikasiController;
use App\Http\Controllers\Admin\KeahlianController;
use App\Http\Controllers\Admin\ProdiController;
use App\Http\Controllers\Admin\MahasiswaController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\PembimbingController;
use App\Http\Controllers\Admin\PengajuanJudulController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TodoController;
use App\Http\Controllers\Admin\UserMenuController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\App\TitleAnalysisController;
use App\Http\Controllers\App\TitleClassificationController;
use App\Http\Controllers\App\TitleSimilarityController;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\Auth\LoginController as Auths;
use App\Http\Controllers\Api\MahasiswaProxyController;

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


    Route::group(['prefix' => 'mahasiswa', 'middleware' => ['auth']], function () {
        Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
        Route::group(['prefix' => '/pengajuan-judul'], function () {
            Route::get('/', [App\Http\Controllers\App\PengajuanController::class, 'index'])->name('pengajuan.index');
            Route::get('/data', [App\Http\Controllers\App\PengajuanController::class, 'data'])->name('pengajuan.data');
            Route::prefix('create')->group(function () {
                Route::post('/store', [App\Http\Controllers\App\PengajuanController::class, 'store'])->name('pengajuan.store');
                Route::get('/step-1', [App\Http\Controllers\App\PengajuanController::class, 'step1'])->name('pengajuan.step1');
                Route::get('/step-2', [App\Http\Controllers\App\PengajuanController::class, 'step2'])->name('pengajuan.step2');
                Route::get('/step-3', [App\Http\Controllers\App\PengajuanController::class, 'step3'])->name('pengajuan.step3');
            });
            Route::post('/api/check-title-similarity', [TitleClassificationController::class, 'checkTitleSimilarity'])
                ->name('check.title.similarity');
            // Route::get('/{id}/edit', [PengajuanJudulController::class, 'edit'])->name('pengajuan-judul.edit');
            // Route::put('/{id}', [PengajuanJudulController::class, 'update'])->name('pengajuan-judul.update');
            // Route::delete('/{id}', [PengajuanJudulController::class, 'destroy'])->name('pengajuan-judul.delete');
        });
    });


    // ADMIN_ROUTES
    Route::group(['prefix' => 'admin'], function () {

        Route::get('/', [DashboardController::class, 'index'])->name('admin');
        // routes/web.php
        // Route::get('/pengajuan/{id}/rekomendasi', [PembimbingController::class, 'getRecommendation']);
        // Route::post('/pengajuan/{id}/assign-pembimbing', [PembimbingController::class, 'assignSupervisors']);

        # APPS 
        Route::group(['prefix' => '/pengajuan-judul'], function () {
            Route::get('/', [PengajuanJudulController::class, 'index'])->name('pengajuan-judul.index');
            Route::get('/data', [PengajuanJudulController::class, 'data'])->name('pengajuan-judul.data');
            Route::get('/datas', [PengajuanJudulController::class, 'datas'])->name('pengajuan-judul.datas');
            Route::get('/create', [PengajuanJudulController::class, 'create'])->name('pengajuan-judul.create');
            Route::post('/store', [PengajuanJudulController::class, 'store'])->name('pengajuan-judul.store');
            Route::get('/{id}/edit', [PengajuanJudulController::class, 'edit'])->name('pengajuan-judul.edit');
            Route::put('/{id}', [PengajuanJudulController::class, 'update'])->name('pengajuan-judul.update');
            Route::delete('/{id}', [PengajuanJudulController::class, 'destroy'])->name('pengajuan-judul.delete');
            Route::put('/{id}/assign-supervisor', [PengajuanJudulController::class, 'assignSupervisor'])->name('pengajuan-judul.assign-supervisor');
            Route::get('/dosen', [PengajuanJudulController::class, 'getDosen'])->name('admin.pengajuan-judul.dosen');
            Route::put('/{id}/update-status', [PengajuanJudulController::class, 'updateStatus'])
                ->name('pengajuan-judul.update-status');

            // Route::get('/rekomendasi-naive-bayes/{pengajuanId}', [PembimbingController::class, 'rekomendasiNaiveBayes'])->name('admin.pengajuan-judul.rekomendasi_naive_bayes');
        });

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



        # MENU MASTER DATA 
        Route::group(['prefix' => '/mahasiswa'], function () {
            Route::get('/', [MahasiswaController::class, 'index'])->name('mahasiswa.index');
            Route::get('/data', [MahasiswaController::class, 'data'])->name('mahasiswa.data');
            Route::get('/create', [MahasiswaController::class, 'create'])->name('mahasiswa.create');
            Route::post('/store', [MahasiswaController::class, 'store'])->name('mahasiswa.store');
            Route::get('/{id}/edit', [MahasiswaController::class, 'edit'])->name('mahasiswa.edit');
            Route::put('/{id}', [MahasiswaController::class, 'update'])->name('mahasiswa.update');
            Route::delete('/{id}', [MahasiswaController::class, 'destroy'])->name('mahasiswa.delete');
            // Route::get('get-prodi-code', [MahasiswaController::class, 'getProdiCode'])->name('getProdiCode');
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

        Route::group(['prefix' => '/keahlian'], function () {
            Route::get('/', [KeahlianController::class, 'index'])->name('keahlian.index');
            Route::get('/data', [KeahlianController::class, 'data'])->name('keahlian.data');
            Route::get('/create', [KeahlianController::class, 'create'])->name('keahlian.create');
            Route::post('/store', [KeahlianController::class, 'store'])->name('keahlian.store');
            Route::get('/{id}/edit', [KeahlianController::class, 'edit'])->name('keahlian.edit');
            Route::put('/{id}', [KeahlianController::class, 'update'])->name('keahlian.update');
            Route::delete('/{id}', [KeahlianController::class, 'destroy'])->name('keahlian.delete');
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

        Route::group(['prefix' => '/pembimbing'], function () {
            Route::get('/test', function () {
                return view('admin.pembimbing.test');
            });
            Route::get('/naive-bayes-test', function () {
                return view('admin.pembimbing.naive-bayes-test');
            })->name('pembimbing.naive-bayes-test');
            Route::get('/assignment', [PembimbingController::class, 'showAssignment'])->name('pembimbing.assignment');
            Route::post('/assign-with-recommendation/{pengajuanId}', [PembimbingController::class, 'assignWithRecommendation'])->name('pembimbing.assign-with-recommendation');
            Route::get('/', [PembimbingController::class, 'index'])->name('pembimbing.index');
            Route::get('/data', [PembimbingController::class, 'data'])->name('pembimbing.data');
            Route::get('/create', [PembimbingController::class, 'create'])->name('pembimbing.create');
            Route::post('/store', [PembimbingController::class, 'store'])->name('pembimbing.store');
            Route::get('/{id}/edit', [PembimbingController::class, 'edit'])->name('pembimbing.edit');
            Route::put('/{id}', [PembimbingController::class, 'update'])->name('pembimbing.update');
            Route::delete('/{id}', [PembimbingController::class, 'destroy'])->name('pembimbing.delete');

            Route::get('/recommendation-naive-bayes/{pengajuanId}', [PembimbingController::class, 'getRecommendationNaiveBayes'])
                ->name('pembimbing.recommendation.naive-bayes');

            Route::post('/train-naive-bayes', [PembimbingController::class, 'trainNaiveBayesModel'])
                ->name('pembimbing.train-naive-bayes');

            Route::post('/save-training-data', [PembimbingController::class, 'saveTrainingData'])
                ->name('pembimbing.save-training-data');

            Route::post('/assign/{pengajuanId}', [PembimbingController::class, 'assignSupervisors'])
                ->name('pembimbing.assign');

            // Get available dosens
            Route::get('/dosens/available', [PembimbingController::class, 'getAvailableDosens'])
                ->name('pembimbing.dosens.available');

            // Get pembimbing history
            Route::get('/history/{pengajuanId}', [PembimbingController::class, 'getPembimbingHistory'])
                ->name('pembimbing.history');
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
Route::get('/api/mahasiswa-list', MahasiswaProxyController::class);
