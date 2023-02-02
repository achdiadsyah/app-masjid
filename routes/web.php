<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::middleware(['IsLicensed'])->group(function () {
    Route::get('/', function () {
        return view('auth.login');
    });
    
    Route::get('displaytv', [App\Http\Controllers\DisplayCOntroller::class, 'displayTv'])->name('display');
    Route::get('jadwal-sholat', [App\Http\Controllers\DisplayCOntroller::class, 'jadwalSholat'])->name('jadwal');
    Route::get('slide-data', [App\Http\Controllers\DisplayCOntroller::class, 'getSlideData'])->name('slide');
    Route::get('revision', [App\Http\Controllers\SettingController::class, 'getRevision'])->name('revision');
    
    Auth::routes([
        'register'  => false,
        'reset' => false,
        'verify' => false,
    ]);
    
    Route::middleware(['auth'])->group(function () {
        Route::get('home', [App\Http\Controllers\HomeController::class, 'showHomePage'])->name('home');
    
        Route::prefix('kas')->name('kas.')->group(function () {
            Route::get('masuk', [App\Http\Controllers\KasController::class, 'showKasMasukPage'])->name('masuk');
            Route::post('masuk', [App\Http\Controllers\KasController::class, 'addDataKasMasuk'])->name('masuk-add');
            Route::get('keluar', [App\Http\Controllers\KasController::class, 'showKasKeluarPage'])->name('keluar');
            Route::post('keluar', [App\Http\Controllers\KasController::class, 'addDataKasKeluar'])->name('keluar-add');
            Route::delete('kas-delete', [App\Http\Controllers\KasController::class, 'deleteDataKas'])->name('kas-delete');
            
            Route::get('laporan', [App\Http\Controllers\KasController::class, 'showLaporanKas'])->name('laporan');
            Route::post('laporan-show', [App\Http\Controllers\KasController::class, 'getLaporan'])->name('laporan-show');
        });
    
        Route::prefix('jadwal')->name('jadwal.')->group(function () {
            Route::get('sholat', [App\Http\Controllers\JadwalController::class, 'showSholatUmumPage'])->name('sholat');
            Route::post('sholat-add', [App\Http\Controllers\JadwalController::class, 'sholatUmumAdd'])->name('sholat-add');
            Route::delete('sholat-delete', [App\Http\Controllers\JadwalController::class, 'sholatUmumDelete'])->name('sholat-delete');
            
            Route::get('sholat-khusus', [App\Http\Controllers\JadwalController::class, 'showSholatKhususPage'])->name('sholat-khusus');
            Route::post('sholat-khusus-add', [App\Http\Controllers\JadwalController::class, 'sholatKhususAdd'])->name('sholat-khusus-add');
            Route::delete('sholat-khusus-delete', [App\Http\Controllers\JadwalController::class, 'sholatKhususDelete'])->name('sholat-khusus-delete');
    
            Route::get('pengajian/shubuh', [App\Http\Controllers\PengajianController::class, 'showPengajianShubuhPage'])->name('pengajian-shubuh');
            Route::get('pengajian/magrib', [App\Http\Controllers\PengajianController::class, 'showPengajianMagribPage'])->name('pengajian-magrib');
            Route::get('pengajian/wanita', [App\Http\Controllers\PengajianController::class, 'showPengajianWanitaPage'])->name('pengajian-wanita');
            
            Route::post('pengajian-add', [App\Http\Controllers\PengajianController::class, 'addPengajian'])->name('pengajian-add');
            Route::delete('pengajian-delete', [App\Http\Controllers\PengajianController::class, 'deletePengajian'])->name('pengajian-delete');
        });
    
        Route::middleware(['IsAdmin'])->group(function () {
            Route::prefix('setting')->name('setting.')->group(function () {

                Route::get('app', [App\Http\Controllers\SettingController::class, 'showAppSettingPage'])->name('app');
                Route::post('app-update', [App\Http\Controllers\SettingController::class, 'updateAppSetting'])->name('app-update');

                Route::get('user', [App\Http\Controllers\SettingController::class, 'showUserSettingPage'])->name('user');
                Route::post('user-add', [App\Http\Controllers\SettingController::class, 'addUserSettingPage'])->name('user-add');
                Route::delete('user-delete', [App\Http\Controllers\SettingController::class, 'deleteUserSettingPage'])->name('user-delete');
                

                Route::get('running-text', [App\Http\Controllers\SettingController::class, 'showRunningTextPage'])->name('running-text');
                Route::post('running-text-add', [App\Http\Controllers\SettingController::class, 'addRunningText'])->name('running-text-add');
                Route::delete('running-text-delete', [App\Http\Controllers\SettingController::class, 'deleteRunningText'])->name('running-text-delete');

                Route::get('wallpaper-gallery', [App\Http\Controllers\SettingController::class, 'showWallpaperGalleryPage'])->name('wallpaper-gallery');
                Route::post('wallpaper-gallery-add', [App\Http\Controllers\SettingController::class, 'addWallpaperGalleryPage'])->name('wallpaper-gallery-add');
                Route::delete('wallpaper-gallery-delete', [App\Http\Controllers\SettingController::class, 'deleteWallpaperGalleryPage'])->name('wallpaper-gallery-delete');
            });
        });
    });
});