<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::get("/", function () {
    return view("welcome");
});

Route::get("/login", [PostController::class, "login"])->name("login");
Route::post("/login-check", [PostController::class, "login_check"])->name("login-check");
Route::get("/logout", [PostController::class, "logout"])->name("logout");
Route::get("/add-post", [PostController::class, "add_post"])->name("add-post");
Route::post("/save-post", [PostController::class, "save_post"])->name("save-post");
Route::get("/all-posts", [PostController::class, "all_posts"])->name("all-posts");
Route::get("/all-reviews", [PostController::class, "all_reviews"])->name("all-reviews");
Route::get("/view-post/{id}", [PostController::class, "view_post"])->name("view-post");
Route::get("/edit-post/{id}", [PostController::class, "edit_post"])->name("edit-post");
Route::get("/add-review/{id}", [PostController::class, "add_review"])->name("add-review");
Route::get("/edit-review/{id}/{post_id}/{status}", [PostController::class, "edit_review"])->name("edit-review");
Route::post("/save-review", [PostController::class, "save_review"])->name("save-review");
