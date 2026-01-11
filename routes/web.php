<?php

use App\Models\Daftar;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\OrganisasiController;
use App\Http\Controllers\ChatBotController;
use App\Http\Controllers\Admin\BeasiswaController;
use App\Http\Controllers\Admin\DaftarController;
use App\Http\Controllers\Admin\JurusanController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\ConversationController;

// ⭐ TAMBAHAN BARU untuk Widget
use App\Http\Controllers\WidgetChatController;
use App\Http\Controllers\WidgetAdminController;
use App\Http\Controllers\Admin\KnowledgeController;

// Landing Page
Route::get('/', [LandingController::class, 'index'])->name('landing_page');

// Contact Form
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

// =====================================
// 🆕 WIDGET PUBLIC ROUTES (NO AUTH)
// =====================================
Route::prefix('widget')->group(function () {
    // Chat tanpa login
    Route::post('/chat', [WidgetChatController::class, 'chat'])
        ->name('widget.chat');
    
    // Verify admin code (Public API with rate limit)
    Route::post('/verify-admin', [WidgetAdminController::class, 'verifyCode'])
        ->middleware('throttle:10,1')
        ->name('widget.verify-admin');
    
    // Add knowledge (Public tapi butuh valid admin code)
    Route::post('/add-knowledge', [WidgetAdminController::class, 'addKnowledge'])
        ->middleware('throttle:20,1')
        ->name('widget.add-knowledge');
});

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');
});

// Authenticated Routes (User Biasa)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile Route
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    
    // Chat History & create chat
    Route::post('/chat/create', [DashboardController::class, 'startChat'])->name('chat.create');
    Route::get('/chat/history', [DashboardController::class, 'history'])->name('chat.history');
    Route::get('/chat/{chatId}', [DashboardController::class, 'chat'])->name('chat.show');
    
    // Route untuk AI Chatbot (User & Admin)
    Route::post('/chatbot/send', [ChatBotController::class, 'chat'])->name('chatbot.chat');

    // History Chat (SIMPLE)
    Route::get('/conversations', [ConversationController::class, 'index'])->name('conversations.index');
    Route::post('/conversations', [ConversationController::class, 'store'])->name('conversations.store');
    Route::delete('/conversations/{id}', [ConversationController::class, 'destroy'])->name('conversations.destroy');
});

// ✅ Admin Routes (HANYA untuk role admin)
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/pengguna', [AdminDashboardController::class, 'pengguna'])->name('admin.pengguna');
    Route::get('/riwayat', [AdminDashboardController::class, 'riwayat'])->name('admin.riwayat');
    Route::get('/knowledge', [AdminDashboardController::class, 'knowledge'])->name('admin.knowledge');

    // Training AI Routes
    Route::get('/training', [ChatBotController::class, 'showTraining'])->name('admin.training');
    Route::post('/training/update-prompt', [ChatBotController::class, 'updatePrompt'])->name('admin.training.update');
    Route::get('/training/get-prompt', [ChatBotController::class, 'getPrompt'])->name('admin.training.get');
    Route::post('/training/reset-prompt', [ChatBotController::class, 'resetPrompt'])->name('admin.training.reset');

    Route::get('/pengaturan', [AdminDashboardController::class, 'pengaturan'])->name('admin.pengaturan');
    
    // Admin Profile
    Route::get('/profile', [AdminProfileController::class, 'index'])->name('admin.profile');
    Route::post('/profile', [AdminProfileController::class, 'update'])->name('admin.profile.update');

    // 🆕 Widget Admin Code Management
    Route::get('/widget-settings', [WidgetAdminController::class, 'settings'])->name('admin.widget.settings');
    Route::post('/widget-settings/generate-code', [WidgetAdminController::class, 'generateNewCode'])->name('admin.widget.generate-code');

    // CRUD Organisasi
    Route::get('/organisasi', [OrganisasiController::class, 'index'])->name('admin.organisasi.index');
    Route::get('/organisasi/create', [OrganisasiController::class, 'create'])->name('admin.organisasi.create');
    Route::post('/organisasi', [OrganisasiController::class, 'store'])->name('admin.organisasi.store');
    Route::get('/organisasi/{id}/edit', [OrganisasiController::class, 'edit'])->name('admin.organisasi.edit');
    Route::put('/organisasi/{id}', [OrganisasiController::class, 'update'])->name('admin.organisasi.update');
    Route::delete('/organisasi/{id}', [OrganisasiController::class, 'destroy'])->name('admin.organisasi.destroy');
    
    // CRUD Beasiswa
    Route::get('/beasiswa', [BeasiswaController::class, 'index'])->name('admin.beasiswa.index');
    Route::get('/beasiswa/create', [BeasiswaController::class, 'create'])->name('admin.beasiswa.create');
    Route::post('/beasiswa', [BeasiswaController::class, 'store'])->name('admin.beasiswa.store');
    Route::get('/beasiswa/{id}/edit', [BeasiswaController::class, 'edit'])->name('admin.beasiswa.edit');
    Route::put('/beasiswa/{id}', [BeasiswaController::class, 'update'])->name('admin.beasiswa.update');
    Route::delete('/beasiswa/{id}', [BeasiswaController::class, 'destroy'])->name('admin.beasiswa.destroy');
    
    // CRUD Daftar
    Route::get('/daftar', [DaftarController::class, 'index'])->name('admin.daftar.index');
    Route::get('/daftar/create', [DaftarController::class, 'create'])->name('admin.daftar.create');
    Route::post('/daftar', [DaftarController::class, 'store'])->name('admin.daftar.store');
    Route::get('/daftar/{id}/edit', [DaftarController::class, 'edit'])->name('admin.daftar.edit');
    Route::put('/daftar/{id}', [DaftarController::class, 'update'])->name('admin.daftar.update');
    Route::delete('/daftar/{id}', [DaftarController::class, 'destroy'])->name('admin.daftar.destroy');
    
    // CRUD Jurusan
    Route::get('/jurusan', [JurusanController::class, 'index'])->name('admin.jurusan.index');
    Route::get('/jurusan/create', [JurusanController::class, 'create'])->name('admin.jurusan.create');
    Route::post('/jurusan', [JurusanController::class, 'store'])->name('admin.jurusan.store');
    Route::get('/jurusan/{id}/edit', [JurusanController::class, 'edit'])->name('admin.jurusan.edit');
    Route::put('/jurusan/{id}', [JurusanController::class, 'update'])->name('admin.jurusan.update');
    Route::delete('/jurusan/{id}', [JurusanController::class, 'destroy'])->name('admin.jurusan.destroy');
});

