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

Route::get('/', 'Auth\LoginController@showLoginForm');

Auth::routes(['register' => false]);
Route::get('/', 'HomeController@index')->name('home');
Route::get('/users', 'UserController@index')->name('users');
Route::get('/users/{user}', 'UserController@index');
Route::post('/users', 'UserController@store');
Route::post('/users/{user}', 'UserController@update');
Route::delete('/users/{user}', 'UserController@delete');
Route::get('/organisations', 'OrganisationController@index')->name('organisations');
Route::get('/organisations/{organisation}', 'OrganisationController@index');
Route::post('/organisations', 'OrganisationController@store');
Route::post('/organisations/{organisation}', 'OrganisationController@update');
Route::delete('/organisations/{organisation}', 'OrganisationController@delete');
