<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'PostsController@index')->name('home');

Route::resource('/posts', 'PostsController');//->except(['edit']);

Route::resource('/answers', 'AnswersController')->only(['store','update', 'show']);
/*
Route::get('/{id}, array('as' => 'test.route', function($id){
    return $id;
}));*/


//Route::get('', '');

//Route::get('/posts/index/{page}', 'PostsController@index')->name('index');
//Route::get('/posts/edit/{post}/{page}', 'PostsController@edit')->name('posts.edit');

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
