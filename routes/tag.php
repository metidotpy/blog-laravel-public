<?php
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckAuth;


Route::get("tag/{slug}/", [TagController::class, "detail"])->name("tag.detail");
Route::middleware([CheckAuth::class, "verified"])->group(function (){
    Route::get("tag/action/create/", [TagController::class, "create"])->name("tag.create");
    Route::post("tag/action/create/", [TagController::class, "store"])->name("tag.store");
    Route::get("tag/action/update/{id}/", [TagController::class, "edit"])->name("tag.edit");
    Route::put("tag/action/update/{tag}/", [TagController::class, "update"])->name("tag.update");
    Route::delete('/tag/action/delete/{id}/', [TagController::class, 'destroy'])->name('tag.delete');
});
?>