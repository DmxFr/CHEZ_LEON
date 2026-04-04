<?php
use Illuminate\Support\Facades\Route;

// Importation des contrôleurs
use App\Http\Controllers\PublicHomeController;
use App\Http\Controllers\FreeTourController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\Auth\{LoginController, RegisterController};
use App\Http\Controllers\Simple\{DashboardController, ProfileController, DeviceViewController, ExperienceController};
use App\Http\Controllers\Complex\{DeviceManagementController, ReportController, ZoneController};
use App\Http\Controllers\Admin\{AdminDashboardController, AdminUserController, AdminCategoryController, AdminZoneController, AdminIntegrityController, AdminHistoryController, AdminSettingsController, AdminNewsController};

// ── MODULE PUBLIC (Visiteurs) ─────────────────────────────────────────────
Route::prefix('')->name('public.')->group(function () {
    Route::get('/', [PublicHomeController::class, 'index'])->name('home');
    Route::get('/visite-guidee', [FreeTourController::class, 'index'])->name('tour.index');
    Route::get('/visite-guidee/{step}', [FreeTourController::class, 'show'])->name('tour.show');
    Route::get('/actualites', [NewsController::class, 'index'])->name('news.index');
    Route::get('/actualites/{slug}', [NewsController::class, 'show'])->name('news.show');
    Route::get('/inscription', [RegisterController::class, 'showForm'])->name('register');
    Route::post('/inscription', [RegisterController::class, 'store'])->name('register.store');
    Route::get('/connexion', [LoginController::class, 'showForm'])->name('login');
    Route::post('/connexion', [LoginController::class, 'login'])->name('login.post');
    Route::post('/deconnexion', [LoginController::class, 'logout'])->name('logout');
});

// ── MODULE SIMPLE (Utilisateurs simples approuvés) ────────────────────────
Route::middleware(['auth', 'role:simple,complex,admin', 'track.login'])->prefix('espace')->name('simple.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profil', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profil/modifier', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profil', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profil/{pseudo}', [ProfileController::class, 'showPublic'])->name('profile.public');
    Route::get('/objets', [DeviceViewController::class, 'index'])->name('devices.index');
    Route::get('/objets/{device}', [DeviceViewController::class, 'show'])->middleware('track.device.view')->name('devices.show');
    Route::get('/experience', [ExperienceController::class, 'index'])->name('xp.index');
});

// ── MODULE COMPLEXE (Avancé/Expert uniquement) ────────────────────────────
Route::middleware(['auth', 'role:complex,admin', 'level:advanced', 'track.login'])->prefix('gestion')->name('complex.')->group(function () {
    Route::get('/objets', [DeviceManagementController::class, 'index'])->name('devices.index');
    Route::get('/objets/creer', [DeviceManagementController::class, 'create'])->name('devices.create');
    Route::post('/objets', [DeviceManagementController::class, 'store'])->name('devices.store');
    Route::get('/objets/{device}', [DeviceManagementController::class, 'show'])->name('devices.show');
    Route::get('/objets/{device}/modifier', [DeviceManagementController::class, 'edit'])->name('devices.edit');
    Route::put('/objets/{device}', [DeviceManagementController::class, 'update'])->name('devices.update');
    Route::delete('/objets/{device}', [DeviceManagementController::class, 'destroy'])->name('devices.destroy');
    Route::post('/objets/{device}/controle', [DeviceManagementController::class, 'control'])->name('devices.control');
    Route::put('/objets/{device}/zone', [DeviceManagementController::class, 'assignZone'])->name('devices.assign-zone');
    Route::get('/rapports', [ReportController::class, 'index'])->name('reports.index');
    
    // --- ROUTES PLACEHOLDERS (En construction) ---
    Route::get('/zones', function() { return 'Page Zones en construction'; })->name('zones.index');
});

// ── MODULE ADMINISTRATION (Admin + Expert) ────────────────────────────────
Route::middleware(['auth', 'role:admin', 'level:expert', 'track.login'])->prefix('administration')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/utilisateurs', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/utilisateurs/en-attente', [AdminUserController::class, 'pending'])->name('users.pending');
    Route::post('/utilisateurs/{user}/approuver', [AdminUserController::class, 'approve'])->name('users.approve');
    Route::post('/utilisateurs/{user}/xp', [AdminUserController::class, 'adjustXp'])->name('users.xp');

    // --- ROUTES PLACEHOLDERS (En construction) ---
    Route::get('/categories', function() { return 'Page Catégories en construction'; })->name('categories.index');
    Route::get('/zones', function() { return 'Page Zones Admin en construction'; })->name('zones.index');
    Route::get('/integrite', function() { return 'Page Intégrité en construction'; })->name('integrity.index');
});