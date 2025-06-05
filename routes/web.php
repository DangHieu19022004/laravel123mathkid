<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('games/lop4')->name('games.lop4.')->group(function () {
    // Game hub
    Route::get('/phanso', [GameController::class, 'gameHub'])->name('phanso');
    
    // Cake game routes
    Route::get('/phanso/cake', [GameController::class, 'cakeGame'])->name('phanso.cake');
    Route::post('/phanso/cake/check', [GameController::class, 'checkCakeAnswer'])->name('phanso.cake.check');
    Route::post('/phanso/cake/reset', [GameController::class, 'resetCakeGame'])->name('phanso.cake.reset');
    
    // Apple game routes
    Route::get('/phanso/apple', [GameController::class, 'appleGame'])->name('phanso.apple');
    Route::post('/phanso/apple/check', [GameController::class, 'checkChiataoAnswer'])->name('phanso.apple.check');
    Route::post('/phanso/apple/reset', [GameController::class, 'resetAppleGame'])->name('phanso.apple.reset');
    
    // Bracket game routes
    Route::get('/phanso/bracket', [GameController::class, 'bracketGame'])->name('phanso.bracket');
    Route::post('/phanso/bracket/check', [GameController::class, 'checkBieuthucAnswer'])->name('phanso.bracket.check');
    Route::post('/phanso/bracket/reset', [GameController::class, 'resetBracketGame'])->name('phanso.bracket.reset');
});
