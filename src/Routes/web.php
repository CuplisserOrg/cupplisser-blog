<?php
use Illuminate\Support\Facades\Route;
Route::group(['prefix'=> 'admin/blog', 'middleware' => 'web', 'as'=>'cblog::'], function() {
    Route::get("/", "Cupplisser\Blog\Controllers\BlogPostCtrl@index")->name('posts.index');
    Route::resource('posts', "Cupplisser\Blog\Controllers\BlogPostCtrl", ['except' => ['show']]);
    Route::resource('tags', "Cupplisser\Blog\Controllers\BlogTagCtrl",['except' => ['create', 'show']]);
    Route::resource('categories', "Cupplisser\Blog\Controllers\BlogCategoryCtrl",['except' => ['show']]);
    Route::resource('comments', "Cupplisser\Blog\Controllers\BlogCommentCtrl");
});
