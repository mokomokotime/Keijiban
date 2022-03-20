<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', 'Auth\Login\LoginController@login')->name('user.login');
Route::post('/login', 'Auth\Login\LoginController@login')->name('user.login');

Route::get('/register', 'Auth\Register\RegisterController@register')->name('user.register');
Route::post('/register', 'Auth\Register\RegisterController@register')->name('user.register');

Route::get('/added', 'Auth\Register\RegisterController@added');
Route::post('/added', 'Auth\Register\RegisterController@added');

Route::group(['middleware' => ['auth']], function(){

Route::get('/top','User\Post\PostsController@index')->name('user.index');

Route::get('/logout', 'Auth\Login\LoginController@logout');

Route::get('/post', 'User\Post\PostsController@newpost');
Route::post('/newpost', 'User\Post\PostsController@store')->name('post.newpost');

Route::get('/mypost', 'User\Post\PostsController@mypost');
Route::get('/favoritepost', 'User\Post\PostsController@favoritepost');
Route::get('/search', 'User\Post\PostsController@search');
Route::get('/subcategorypost', 'User\Post\PostsController@subcategorypost')

//詳細画面
Route::get('/{id}/post', 'User\Post\PostsController@detailpost')->name('post.detailpost');
Route::get('/{id}/{user}/post/edit', 'User\Post\PostsController@edit');
Route::post('/post/update', 'User\Post\PostsController@postupdate')->name('post.update');
Route::post('/post/delete', 'User\Post\PostsController@postdelete');

//コメント機能
Route::post('/newcomment', 'User\Post\PostCommentsController@commentstore')->name('post.newcomment');
Route::get('/{id}/{user}/comment/edit', 'User\Post\PostCommentsController@commentedit');
Route::post('/comment/update', 'User\Post\PostCommentsController@commentupdate')->name('comment.update');
Route::post('/comment/delete', 'User\Post\PostCommentsController@commentdelete');

//いいね機能
Route::get('/favorite', 'User\Post\PostFavoritesController@postfavorite');
Route::post('/favorite', 'User\Post\PostFavoritesController@postfavorite');
Route::get('/commentfavorite', 'User\Post\PostCommentFavoritesController@commentfavorite');
Route::post('/commentfavorite', 'User\Post\PostCommentFavoritesController@commentfavorite');

//カテゴリー追加機能
Route::get('/category', 'Admin\Post\PostMainCategoriesController@categoryindex');
Route::post('/newmaincategory', 'Admin\Post\PostMainCategoriesController@newmaincategory');
Route::post('/newsubcategory', 'Admin\Post\PostSubCategoriesController@newsubcategory');

});
