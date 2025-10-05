<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\SdmController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboardController;
use App\Http\Controllers\SuperAdmin\KelolaAkunController;
use App\Http\Controllers\SuperAdmin\ProjectController as SuperAdminProjectController;
use App\Http\Controllers\SuperAdmin\LaporanController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\PerizinanController;
use App\Http\Controllers\Admin\PemantauanController;
use App\Http\Controllers\User\UserProfileController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;

// ==========================================
// ROUTE UNTUK HALAMAN UTAMA (LANDING PAGE)
// ==========================================
// Ketika pengunjung membuka website (http://example.com/), 
// mereka akan melihat halaman landing.blade.php
Route::get('/', function () {
    return view('landing');
})->name('landing');

// Temporary debug route
Route::get('/debug-file', function () {
    $filePath = 'documents/0VITjpfnq9vcegx5KHjD80Mw2XJlwOy88LUBgorG.pdf';
    $exists = Storage::disk('public')->exists($filePath);
    $fullPath = Storage::disk('public')->path($filePath);
    
    return response()->json([
        'file_path' => $filePath,
        'exists' => $exists,
        'full_path' => $fullPath,
        'file_exists_php' => file_exists($fullPath),
        'storage_path' => storage_path('app/public'),
        'public_path' => public_path('storage')
    ]);
});

// ==========================================
// ROUTE UNTUK SISTEM LOGIN/REGISTER
// ==========================================
// Ini akan membuat route otomatis untuk:
// - Login    : http://example.com/login
// - Register : http://example.com/register
// - Logout   : http://example.com/logout
// - Reset Password : http://example.com/password/reset
Auth::routes();

// ==========================================
// ROUTE UNTUK HALAMAN SUPER ADMIN
// ==========================================
// Hanya bisa diakses oleh super admin (role 1)
Route::middleware(['auth', 'role:1'])->prefix('super-admin')->name('super_admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [SuperAdminDashboardController::class, 'index'])->name('dashboard');

    // Ketersediaan SDM
    Route::get('/ketersediaan-sdm', [App\Http\Controllers\SuperAdmin\SdmController::class, 'index'])->name('ketersediaan_sdm');
    Route::get('/ketersediaan-sdm/search', [App\Http\Controllers\SuperAdmin\SdmController::class, 'search'])->name('ketersediaan_sdm.search');
    Route::get('/ketersediaan-sdm/{project_id}/create', [App\Http\Controllers\SuperAdmin\SdmController::class, 'create'])->name('ketersediaan_sdm.create');
    Route::post('/ketersediaan-sdm', [App\Http\Controllers\SuperAdmin\SdmController::class, 'store'])->name('ketersediaan_sdm.store');
    Route::get('/ketersediaan-sdm/{id}', [App\Http\Controllers\SuperAdmin\SdmController::class, 'detail'])->name('ketersediaan_sdm.detail');
    Route::get('/ketersediaan-sdm/{id}/edit', [App\Http\Controllers\SuperAdmin\SdmController::class, 'edit'])->name('ketersediaan_sdm.edit');
    Route::put('/ketersediaan-sdm/{id}', [App\Http\Controllers\SuperAdmin\SdmController::class, 'update'])->name('ketersediaan_sdm.update');
    Route::delete('/ketersediaan-sdm/{id}', [App\Http\Controllers\SuperAdmin\SdmController::class, 'destroy'])->name('ketersediaan_sdm.destroy');

    // Kelola Akun
    Route::get('/kelola-akun', [KelolaAkunController::class, 'index'])->name('kelola_akun');
    Route::get('/kelola-akun/create', [KelolaAkunController::class, 'create'])->name('kelola_akun.create');
    Route::post('/kelola-akun', [KelolaAkunController::class, 'store'])->name('kelola_akun.store');
    Route::get('/kelola-akun/{id}/edit', [KelolaAkunController::class, 'edit'])->name('kelola_akun.edit');
    Route::put('/kelola-akun/{id}', [KelolaAkunController::class, 'update'])->name('kelola_akun.update');
    Route::post('/kelola-akun/toggle-status/{id}', [KelolaAkunController::class, 'toggleStatus'])->name('kelola_akun.toggle_status');

    // Profile Management
    Route::get('/profile', [App\Http\Controllers\SuperAdmin\ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [App\Http\Controllers\SuperAdmin\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [App\Http\Controllers\SuperAdmin\ProfileController::class, 'updatePassword'])->name('profile.update_password');

    // Pemantauan routes
    Route::get('/pemantauan', [App\Http\Controllers\SuperAdmin\PemantauanController::class, 'index'])->name('pemantauan.index');
    Route::get('/pemantauan/search', [App\Http\Controllers\SuperAdmin\PemantauanController::class, 'search'])->name('pemantauan.search');
    Route::get('/pemantauan/{project}/tld', [App\Http\Controllers\SuperAdmin\PemantauanController::class, 'tld'])->name('pemantauan.tld');
    Route::get('/pemantauan/{project}/pendos', [App\Http\Controllers\SuperAdmin\PemantauanController::class, 'pendos'])->name('pemantauan.pendos');
    Route::get('/pemantauan/{projectId}/tld/{userId}/detail', [App\Http\Controllers\SuperAdmin\PemantauanController::class, 'tldDetail'])->name('pemantauan.tld.detail');
    Route::get('/pemantauan/{projectId}/tld/create', [App\Http\Controllers\SuperAdmin\PemantauanController::class, 'tldCreate'])->name('pemantauan.tld.create');
    Route::post('/pemantauan/{projectId}/tld/store', [App\Http\Controllers\SuperAdmin\PemantauanController::class, 'tldStore'])->name('pemantauan.tld.store');
    Route::get('/pemantauan/{projectId}/tld/{userId}/edit/{dosisId}', [App\Http\Controllers\SuperAdmin\PemantauanController::class, 'tldEdit'])->name('pemantauan.tld.edit');
    Route::put('/pemantauan/{projectId}/tld/{userId}/update/{dosisId}', [App\Http\Controllers\SuperAdmin\PemantauanController::class, 'tldUpdate'])->name('pemantauan.tld.update');
    Route::delete('/pemantauan/{projectId}/tld/{userId}/destroy/{dosisId}', [App\Http\Controllers\SuperAdmin\PemantauanController::class, 'tldDestroy'])->name('pemantauan.tld.destroy');

    // Pemantauan Dosis Pendose routes
    Route::get('/pemantauan/{projectId}/pendos/{userId}/detail', [App\Http\Controllers\SuperAdmin\PemantauanController::class, 'pendosDetail'])->name('pemantauan.pendos.detail');
    Route::get('/pemantauan/{projectId}/pendos/create', [App\Http\Controllers\SuperAdmin\PemantauanController::class, 'pendosCreate'])->name('pemantauan.pendos.create');
    Route::post('/pemantauan/{projectId}/pendos/store', [App\Http\Controllers\SuperAdmin\PemantauanController::class, 'pendosStore'])->name('pemantauan.pendos.store');
    Route::get('/pemantauan/{projectId}/pendos/{userId}/edit/{dosisId}', [App\Http\Controllers\SuperAdmin\PemantauanController::class, 'pendosEdit'])->name('pemantauan.pendos.edit');
    Route::put('/pemantauan/{projectId}/pendos/{userId}/update/{dosisId}', [App\Http\Controllers\SuperAdmin\PemantauanController::class, 'pendosUpdate'])->name('pemantauan.pendos.update');
    Route::delete('/pemantauan/{projectId}/pendos/{userId}/destroy/{dosisId}', [App\Http\Controllers\SuperAdmin\PemantauanController::class, 'pendosDestroy'])->name('pemantauan.pendos.destroy');

    // Pengangkutan Sumber Radioaktif
    // Route::get('/pengangkutan-sumber-radioaktif', [App\Http\Controllers\SuperAdmin\PengangkutanSumberRadioaktifController::class, 'index'])
    //     ->name('pengangkutan_sumber_radioaktif');

    // Projects
    Route::get('/projects/search', [SuperAdminProjectController::class, 'search'])->name('projects.search');
    Route::resource('projects', SuperAdminProjectController::class);

    // Perizinan
    Route::get('/perizinan', [App\Http\Controllers\SuperAdmin\PerizinanController::class, 'index'])->name('perizinan.index');
    Route::get('/perizinan/search', [App\Http\Controllers\SuperAdmin\PerizinanController::class, 'search'])->name('perizinan.search');
    Route::get('/perizinan/{project_id}/create', [App\Http\Controllers\SuperAdmin\PerizinanController::class, 'create'])->name('perizinan.create');
    Route::post('/perizinan', [App\Http\Controllers\SuperAdmin\PerizinanController::class, 'store'])->name('perizinan.store');
    Route::get('/perizinan/{id}', [App\Http\Controllers\SuperAdmin\PerizinanController::class, 'detail'])->name('perizinan.detail');
    Route::get('/perizinan/{id}/edit', [App\Http\Controllers\SuperAdmin\PerizinanController::class, 'edit'])->name('perizinan.edit');
    Route::put('/perizinan/{id}', [App\Http\Controllers\SuperAdmin\PerizinanController::class, 'update'])->name('perizinan.update');
    Route::delete('/perizinan/{id}', [App\Http\Controllers\SuperAdmin\PerizinanController::class, 'destroy'])->name('perizinan.destroy');

    // Ketersediaan SDM
    Route::prefix('sdm')->name('sdm.')->group(function () {
        Route::get('/', [App\Http\Controllers\SuperAdmin\SdmController::class, 'index'])->name('index');
        Route::get('/search', [App\Http\Controllers\SuperAdmin\SdmController::class, 'search'])->name('search');
        Route::get('/{project_id}/create', [App\Http\Controllers\SuperAdmin\SdmController::class, 'create'])->name('create');
        Route::post('/{project_id}', [App\Http\Controllers\SuperAdmin\SdmController::class, 'store'])->name('store');
        Route::get('/{id}', [App\Http\Controllers\SuperAdmin\SdmController::class, 'detail'])->name('detail');
        Route::delete('/{project_id}/user/{user_id}', [App\Http\Controllers\SuperAdmin\SdmController::class, 'destroy'])->name('destroy');
    });

    // Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');
    Route::get('/laporan/{id}', [LaporanController::class, 'projectDetail'])->name('laporan.project_detail');
    Route::get('/laporan/{id}/download', [LaporanController::class, 'downloadProjectReport'])->name('laporan.project.download');

    // Dokumen
    Route::resource('documents', App\Http\Controllers\SuperAdmin\DocumentController::class);
    Route::get('documents/{document}/download', [App\Http\Controllers\SuperAdmin\DocumentController::class, 'download'])->name('documents.download');

    // Document Categories for AJAX
    Route::post('document_categories', [App\Http\Controllers\SuperAdmin\DocumentCategoryController::class, 'store'])->name('document_categories.store');

    // Pemantauan TLD & Pendos sebagai menu terpisah
    Route::get('/tld', [App\Http\Controllers\SuperAdmin\PemantauanController::class, 'search'])->name('tld.search');
    Route::get('/pendos', [App\Http\Controllers\SuperAdmin\PemantauanController::class, 'search'])->name('pendos.search');

    // Detail TLD & Pendos dengan URL baru
    Route::get('/tld/{project}', [App\Http\Controllers\SuperAdmin\PemantauanController::class, 'tld'])->name('tld.detail');
    Route::get('/pendos/{project}', [App\Http\Controllers\SuperAdmin\PemantauanController::class, 'pendos'])->name('pendos.detail');

    // Detail user TLD & Pendos dengan URL baru
    Route::get('/tld/{projectId}/{userId}/detail', [App\Http\Controllers\SuperAdmin\PemantauanController::class, 'tldDetail'])->name('tld.user.detail');
    Route::get('/pendos/{projectId}/{userId}/detail', [App\Http\Controllers\SuperAdmin\PemantauanController::class, 'pendosDetail'])->name('pendos.user.detail');

    // Create TLD & Pendos dengan URL baru
    Route::get('/tld/{project}/create', [App\Http\Controllers\SuperAdmin\PemantauanController::class, 'tldCreate'])->name('tld.create');
    Route::get('/pendos/{project}/create', [App\Http\Controllers\SuperAdmin\PemantauanController::class, 'pendosCreate'])->name('pendos.create');

    // Jenis Pekerja (Bidang) CRUD untuk modal
    Route::get('/jenis-pekerja/list', [App\Http\Controllers\SuperAdmin\JenisPekerjaController::class, 'list'])->name('jenis_pekerja.list');
    Route::post('/jenis-pekerja/store', [App\Http\Controllers\SuperAdmin\JenisPekerjaController::class, 'store'])->name('jenis_pekerja.store');
    Route::put('/jenis-pekerja/update/{id}', [App\Http\Controllers\SuperAdmin\JenisPekerjaController::class, 'update'])->name('jenis_pekerja.update');
    Route::delete('/jenis-pekerja/destroy/{id}', [App\Http\Controllers\SuperAdmin\JenisPekerjaController::class, 'destroy'])->name('jenis_pekerja.destroy');
});

// ==========================================
// ROUTE UNTUK HALAMAN ADMIN
// ==========================================
// Hanya bisa diakses oleh admin (role 2)
// Jika user biasa mencoba akses, akan dapat pesan error
// URL: http://example.com/admin/dashboard
Route::middleware(['auth', 'role:2'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // Kelola Akun
    Route::get('/kelola-akun', [App\Http\Controllers\Admin\KelolaAkunController::class, 'index'])->name('kelola_akun');
    Route::get('/kelola-akun/create', [App\Http\Controllers\Admin\KelolaAkunController::class, 'create'])->name('kelola_akun.create');
    Route::post('/kelola-akun', [App\Http\Controllers\Admin\KelolaAkunController::class, 'store'])->name('kelola_akun.store');
    Route::get('/kelola-akun/{id}/edit', [App\Http\Controllers\Admin\KelolaAkunController::class, 'edit'])->name('kelola_akun.edit');
    Route::put('/kelola-akun/{id}', [App\Http\Controllers\Admin\KelolaAkunController::class, 'update'])->name('kelola_akun.update');
    Route::post('/kelola-akun/toggle-status/{id}', [App\Http\Controllers\Admin\KelolaAkunController::class, 'toggleStatus'])->name('kelola_akun.toggle_status');

    // Profile Management
    Route::get('/profile', [App\Http\Controllers\Admin\ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [App\Http\Controllers\Admin\ProfileController::class, 'updatePassword'])->name('profile.update_password');

    // Pemantauan routes
    Route::get('/pemantauan', [PemantauanController::class, 'index'])->name('pemantauan.index');
    Route::get('/pemantauan/search', [PemantauanController::class, 'search'])->name('pemantauan.search');
    Route::get('/pemantauan/{project}/tld', [PemantauanController::class, 'tld'])->name('pemantauan.tld');
    Route::get('/pemantauan/{project}/pendos', [PemantauanController::class, 'pendos'])->name('pemantauan.pendos');
    Route::get('/pemantauan/{projectId}/tld/create', [PemantauanController::class, 'tldCreate'])->name('pemantauan.tld.create');
    Route::post('/pemantauan/{projectId}/tld/store', [PemantauanController::class, 'tldStore'])->name('pemantauan.tld.store');
    Route::get('/pemantauan/{projectId}/tld/{userId}/detail', [PemantauanController::class, 'tldDetail'])->name('pemantauan.tld.detail');
    Route::get('/pemantauan/{projectId}/tld/{userId}/edit/{dosisId}', [PemantauanController::class, 'tldEdit'])->name('pemantauan.tld.edit');
    Route::put('/pemantauan/{projectId}/tld/{userId}/update/{dosisId}', [PemantauanController::class, 'tldUpdate'])->name('pemantauan.tld.update');
    Route::delete('/pemantauan/{projectId}/tld/{userId}/destroy/{dosisId}', [PemantauanController::class, 'tldDestroy'])->name('pemantauan.tld.destroy');

    // SDM Management routes
    Route::get('/sdm', [App\Http\Controllers\Admin\SdmController::class, 'index'])->name('sdm.index');
    Route::get('/sdm/search', [App\Http\Controllers\Admin\SdmController::class, 'search'])->name('sdm.search');
    Route::get('/sdm/{id}/detail', [App\Http\Controllers\Admin\SdmController::class, 'detail'])->name('sdm.detail');
    Route::get('/sdm/{id}/create', [App\Http\Controllers\Admin\SdmController::class, 'create'])->name('sdm.create');
    Route::post('/sdm/{id}/store', [App\Http\Controllers\Admin\SdmController::class, 'store'])->name('sdm.store');
    Route::delete('/sdm/{project}/user/{id}', [App\Http\Controllers\Admin\SdmController::class, 'removeUser'])->name('sdm.destroy');
    Route::get('/sdm/search-users', [App\Http\Controllers\Admin\SdmController::class, 'searchUsers'])->name('sdm.search-users');

    Route::get('/pengangkutan-sumber', function () {
        return view('admin.pengangkutan');
    })->name('pengangkutan');

    // Update perizinan route to use controller
    Route::get('/perizinan', [PerizinanController::class, 'index'])->name('perizinan.index');
    Route::get('/perizinan/search', [PerizinanController::class, 'search'])->name('perizinan.search');
    Route::get('/perizinan/{project_id}/create', [PerizinanController::class, 'create'])->name('perizinan.create');
    Route::post('/perizinan', [PerizinanController::class, 'store'])->name('perizinan.store');
    Route::get('/perizinan/{id}', [PerizinanController::class, 'detail'])->name('perizinan.detail');
    Route::get('/perizinan/{id}/edit', [PerizinanController::class, 'edit'])->name('perizinan.edit');
    Route::put('/perizinan/{id}', [PerizinanController::class, 'update'])->name('perizinan.update');
    Route::delete('/perizinan/{id}', [PerizinanController::class, 'destroy'])->name('perizinan.destroy');

    // Projects
    Route::get('/projects/search', [ProjectController::class, 'search'])->name('projects.search');
    Route::resource('projects', ProjectController::class)->except(['show']);

    // Reports
    Route::get('/laporan', [App\Http\Controllers\Admin\LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/project/{id}', [App\Http\Controllers\Admin\LaporanController::class, 'projectDetail'])->name('laporan.project_detail');
    Route::get('/laporan/project/{id}/download', [App\Http\Controllers\Admin\LaporanController::class, 'downloadProjectDetail'])->name('laporan.project.download');

    // Documents
    Route::get('/dokumen', [App\Http\Controllers\Admin\DocumentController::class, 'index'])->name('dokumen.index');
    Route::get('/dokumen/create', [App\Http\Controllers\Admin\DocumentController::class, 'create'])->name('dokumen.create');
    Route::post('/dokumen', [App\Http\Controllers\Admin\DocumentController::class, 'store'])->name('dokumen.store');
    Route::get('/dokumen/{document}/download', [App\Http\Controllers\Admin\DocumentController::class, 'download'])->name('dokumen.download');
    Route::get('/dokumen/{document}', [App\Http\Controllers\Admin\DocumentController::class, 'show'])->name('dokumen.show');
    Route::get('/dokumen/{document}/edit', [App\Http\Controllers\Admin\DocumentController::class, 'edit'])->name('dokumen.edit');
    Route::delete('/dokumen/{document}', [App\Http\Controllers\Admin\DocumentController::class, 'destroy'])->name('dokumen.destroy');
    Route::put('/dokumen/{document}', [App\Http\Controllers\Admin\DocumentController::class, 'update'])->name('dokumen.update');
    Route::get('/dokumen/search', [App\Http\Controllers\Admin\DocumentController::class, 'search'])->name('dokumen.search');

    // Pemantauan TLD & Pendos sebagai menu terpisah (ADMIN)
    Route::get('/tld', [PemantauanController::class, 'search'])->name('tld.search');
    Route::get('/pendos', [PemantauanController::class, 'search'])->name('pendos.search');

    // Document Categories for AJAX
    Route::post('document_categories', [App\Http\Controllers\Admin\DocumentCategoryController::class, 'store'])->name('dokumen_categories.store');

    // Detail TLD & Pendos dengan URL baru
    Route::get('/tld/{project}', [App\Http\Controllers\Admin\PemantauanController::class, 'tld'])->name('tld.detail');
    Route::get('/tld/{projectId}/{userId}/detail', [App\Http\Controllers\Admin\PemantauanController::class, 'tldDetail'])->name('tld.user.detail');
    Route::get('/tld/{projectId}/{userId}/edit/{dosisId}', [App\Http\Controllers\Admin\PemantauanController::class, 'tldEdit'])->name('tld.edit');
    Route::get('/pendos/{project}', [App\Http\Controllers\Admin\PemantauanController::class, 'pendos'])->name('pendos.detail');
    Route::get('/pemantauan/{projectId}/pendos/create', [App\Http\Controllers\Admin\PemantauanController::class, 'pendosCreate'])->name('pemantauan.pendos.create');
    Route::post('/pemantauan/{projectId}/pendos/store', [App\Http\Controllers\Admin\PemantauanController::class, 'pendosStore'])->name('pemantauan.pendos.store');
    Route::get('/pendos/{projectId}/{userId}/detail', [App\Http\Controllers\Admin\PemantauanController::class, 'pendosDetail'])->name('pendos.user.detail');
    Route::get('/pemantauan/{projectId}/pendos/{userId}/edit/{dosisId}', [App\Http\Controllers\Admin\PemantauanController::class, 'pendosEdit'])->name('pemantauan.pendos.edit');
    Route::delete('/pemantauan/{projectId}/pendos/{userId}/destroy/{dosisId}', [App\Http\Controllers\Admin\PemantauanController::class, 'pendosDestroy'])->name('pemantauan.pendos.destroy');
    Route::put('/pemantauan/{projectId}/pendos/{userId}/update/{dosisId}', [App\Http\Controllers\Admin\PemantauanController::class, 'pendosUpdate'])->name('pemantauan.pendos.update');
});

// ==========================================
// ROUTE UNTUK HALAMAN USER BIASA
// ==========================================
// Hanya bisa diakses oleh user biasa (role 3)
// Jika admin mencoba akses, akan dapat pesan error
// URL: http://example.com/user/dashboard
Route::middleware(['auth', 'role:3'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [UserProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile/update', [UserProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/update-password', [UserProfileController::class, 'updatePassword'])->name('profile.update_password');
});
