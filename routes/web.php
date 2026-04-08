<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;



Route::get('/', function() {
    return redirect('/article');
});



Route::get('/article', [ArticleController::class, 'publicIndex'])->name('article.index');
Route::get('/articles/{id}', [ArticleController::class], 'show')->name('article.show');



/** Admin */

Route::get('/admin/articles', [ArticleController::class, 'adminIndex'])->name('admin.articles.index');
Route::get('/admin/articles/create', [ArticleController::class, 'create'])->name('admin.articles.create');
Route::post('/admin/articles/', [ArticleController::class, 'store'])->name('admin.articles.store');
Route::get('/admin/articles/{id}/edit', [ArticleController::class, 'edit'])->name('admin.articles.edit');
Route::put('/admin/articles/{id}', [ArticleController::class, 'update'])->name('admin.articles.update');
Route::delete('/admin/articles/{id}', [ArticleController::class, 'destroy'])->name('admin.articles.destroy');

