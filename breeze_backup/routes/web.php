<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\SetDraftMiddleware;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(["auth", "verified"])->group( function () {
    Route::get("/user/panel/", [DashboardController::class, "panel"])->name("dashboard.panel");
});


Route::get("/", [PostController::class, "index"])->name("blog.index");
Route::get("/{slug}", [PostController::class, "show"])->name("blog.detail");
Route::get("/preview/{slug}/", [PostController::class, "preview"])->middleware(["auth", "verified"])->name("blog.preview");
Route::get("/post/create/", [PostController::class, "create"])->name("blog.create")->middleware(["auth", "verified"]);
Route::post("/post/create/", [PostController::class, "store"])->middleware(["auth", "verified", SetDraftMiddleware::class])->name("blog.store");


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
