<?php

use App\Livewire\Marvel\Index;
use App\Livewire\Marvel\MisFavoritos;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//consumimos API marvel y mostramos datos
Route::get('/', Index::class)->name('dashboard');
// listamos los registros que hay en DB
Route::get('/mis-heroes', MisFavoritos::class)->name('mis.favoritos');
