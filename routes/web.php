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



Route::get('/', '\App\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');


/*
					 GET|HEAD | login                  | login            | App\Http\Controllers\Auth\LoginController@showLoginForm                | web,guest    |
|        | POST     | login                  |                  | App\Http\Controllers\Auth\LoginController@login                        | web,guest    |
|        | POST     | logout                 | logout           | App\Http\Controllers\Auth\LoginController@logout                       | web          |
|        | POST     | password/email         | password.email   | App\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail  | web,guest    |
|        | GET|HEAD | password/reset         | password.request | App\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm | web,guest    |
|        | POST     | password/reset         | password.update  | App\Http\Controllers\Auth\ResetPasswordController@reset                | web,guest    |
|        | GET|HEAD | password/reset/{token} | password.reset   | App\Http\Controllers\Auth\ResetPasswordController@showResetForm        | web,guest    |
|        | GET|HEAD | register               | register         | App\Http\Controllers\Auth\RegisterController@showRegistrationForm      | web,guest    |
|        | POST     | register               |                  | App\Http\Controllers\Auth\RegisterController@register                  | web,guest   
 */
Auth::routes(['except' => 'login']);




Route::get('/home', 'HomeController@index')->name('home');


Route::middleware(['auth'])->group(function () {

	/**    
    |        | POST      | clienti                | clienti.store    | App\Http\Controllers\ClientiController@store                           | web,auth     |
    |        | GET|HEAD  | clienti                | clienti.index    | App\Http\Controllers\ClientiController@index                           | web,auth     |
    |        | GET|HEAD  | clienti/create         | clienti.create   | App\Http\Controllers\ClientiController@create                          | web,auth     |
    |        | PUT|PATCH | clienti/{clienti}      | clienti.update   | App\Http\Controllers\ClientiController@update                          | web,auth     |
    |        | GET|HEAD  | clienti/{clienti}      | clienti.show     | App\Http\Controllers\ClientiController@show                            | web,auth     |
    |        | DELETE    | clienti/{clienti}      | clienti.destroy  | App\Http\Controllers\ClientiController@destroy                         | web,auth     |
    |        | GET|HEAD  | clienti/{clienti}/edit | clienti.edit     | App\Http\Controllers\ClientiController@edit                            | web,auth     |
	*/
		Route::resource('clienti', 'ClientiController')/*->middleware('log')*/;

});