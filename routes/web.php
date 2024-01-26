<?php

use App\Http\Controllers\V1\ItemController;
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

Route::get('/', [ItemController::class, 'getItems']);

Route::prefix('items')->group(function () {
    Route::get('/{item_id}', [ItemController::class, 'getItem']);
});
