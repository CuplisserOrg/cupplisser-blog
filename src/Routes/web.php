<?php
use Illuminate\Support\Facades\Route;
Route::group(['prefix'=> 'admin/blog', 'middleware' => ['web', 'auth'], 'as'=>'cblog::', 'namespace'=> 'Cupplisser\Blog\Controllers'], function() {
    Route::get("/", "BlogPostCtrl@index");
    Route::resource('posts', "BlogPostCtrl", ['except' => ['show']]);
    Route::resource('pages', "BlogPageCtrl", ['except' => ['show']]);
    Route::resource('tags', "BlogTagCtrl",['except' => ['create', 'show']]);
    Route::resource('categories', "BlogCategoryCtrl",['except' => ['show']]);
    Route::resource('comments', "BlogCommentCtrl");

});

Route::prefix('blog')->namespace("Cupplisser\Blog\Controllers")->group(function ($route) {
    $route->get("get_tags", "BlogCtrl@loadTags");
    $route->get("get_categories", "BlogCtrl@loadCategories");
});
