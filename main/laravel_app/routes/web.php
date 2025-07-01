<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MEME_Controller;
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

Route::get('/', function () {return redirect('/lmao');});

Route::get('/lmao', [MEME_Controller::class, 'get_data']);

Route::get('/meme_donate', fn() => view('meme_donate'));

Route::post('/meme_donate', [MEME_Controller::class,'store']);