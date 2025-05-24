<?php

use App\Http\Controllers\Admin\VerificationAdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CompetitionController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\VerificationRequestController;
use Illuminate\Support\Facades\Route;

/**
 * 🔹 Strona główna i dashboard
 */
Route::get('/', function () {
    return view('welcome', ['categories' => \App\Models\Category::all()]);
})->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/**
 * 🔹 Profil użytkownika (edycja / usunięcie)
 */
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/**
 * 🔹 Zawody strzeleckie
 */
Route::prefix('shooting-competitions')->group(function () {

    Route::get('/', [CompetitionController::class, 'index'])->name('shooting-competitions.index');

    Route::middleware(['auth', 'verified_or_admin'])->group(function () {
        Route::get('/create', [CompetitionController::class, 'create'])->name('shooting-competitions.create');
        Route::post('/', [CompetitionController::class, 'store'])->name('shooting-competitions.store');
    });

    Route::middleware('auth')->group(function () {
        Route::post('/{competition}/join', [CompetitionController::class, 'join'])->name('shooting-competitions.join');
        Route::post('/{competition}/leave', [CompetitionController::class, 'leave'])->name('shooting-competitions.leave');
        Route::get('/my', [CompetitionController::class, 'userCompetitions'])->name('shooting-competitions.user');
        Route::get('/{competition}/report', [CompetitionController::class, 'downloadReport'])->name('shooting-competitions.download-report');
    });

    Route::get('/{competition}', [CompetitionController::class, 'show'])->name('shooting-competitions.show');
});

/**
 * 🔹 Kategorie i tematy
 */
Route::resource('categories', CategoryController::class)->only(['show']);

Route::prefix('categories/{category}/topics')->middleware('auth')->group(function () {
    Route::get('/create', [TopicController::class, 'create'])->name('topics.create');
    Route::post('/', [TopicController::class, 'store'])->name('topics.store');

    Route::get('/{topic}/edit', [CategoryController::class, 'editTopic'])->name('categories.topics.edit');
    Route::put('/{topic}', [CategoryController::class, 'updateTopic'])->name('categories.topics.update');
    Route::delete('/{topic}', [CategoryController::class, 'destroyTopic'])->name('categories.topics.destroy');
});

Route::resource('topics', TopicController::class)->only(['show']);

/**
 * 🔹 Komentarze
 */
Route::middleware('auth')->prefix('comments')->group(function () {
    Route::post('/', [CommentController::class, 'store'])->name('comments.store');
    Route::get('/{comment}/edit', [CommentController::class, 'edit'])->name('comments.edit');
    Route::put('/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

/**
 * 🔹 Przesyłanie obrazów
 */
Route::post('/upload-image', [ImageUploadController::class, 'upload'])->name('image.upload');

/**
 * 🔹 Zgłoszenie użytkowników
 */
Route::middleware('auth')->group(function () {
    Route::get('/verification-request', [VerificationRequestController::class, 'create'])->name('verification.request');
    Route::post('/verification-request', [VerificationRequestController::class, 'store'])->name('verification.submit');
    Route::post('/verification', [VerificationRequestController::class, 'store'])->name('verification.store');
});

/**
 * 🔹 Panel administratora
 */
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/verification-requests', [VerificationAdminController::class, 'index'])->name('admin.verification.index');
    Route::post('/verification-requests/{id}/approve', [VerificationAdminController::class, 'approve'])->name('admin.verification.approve');
    Route::post('/verification-requests/{id}/reject', [VerificationAdminController::class, 'reject'])->name('admin.verification.reject');
});

/**
 * 🔹 Autoryzacja Laravel Breeze
 */
require __DIR__.'/auth.php';
