<?php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TagController;
use App\Http\Middleware\SetDraftMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckAuth;

Route::middleware(["auth", "verified"])->group( function () {
    Route::get("/user/panel/", [DashboardController::class, "panel"])->name("dashboard.panel");
    // Route::delete("/tag/action/delete/{id}/", [TagController::class, "destroy"])->name("tag.delete");
});


Route::get("/", [PostController::class, "index"])->name("blog.index");
Route::get("/{slug}", [PostController::class, "show"])->name("blog.detail");
Route::get("/preview/{slug}/", [PostController::class, "preview"])->middleware([CheckAuth::class, "verified"])->name("blog.preview");
Route::get("/post/create/", [PostController::class, "create"])->name("blog.create")->middleware([CheckAuth::class, "verified"]);
Route::post("/post/create/", [PostController::class, "store"])->middleware([CheckAuth::class, "verified", SetDraftMiddleware::class])->name("blog.store");
Route::get("/post/edit/{id}/", [PostController::class, "edit"])->middleware([CheckAuth::class, "verified"])->name("blog.edit");
Route::put("/post/edit/{post}/", [PostController::class, "update"])->middleware([CheckAuth::class, "verified", SetDraftMiddleware::class])->name("blog.update");
Route::delete("post/delete/{post}/", [PostController::class, "destroy"])->middleware([CheckAuth::class, "verified"])->name("blog.delete");
?>