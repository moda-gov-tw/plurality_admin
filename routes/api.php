<?php

use App\Http\Controllers\ContentManagement\News\NewsController;
use App\Http\Controllers\ContentManagement\Exhibition\ExhibitionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::get('/api/news', [NewsController::class, 'newsForApi']);
Route::get('/api/find-news', [NewsController::class, 'findNewsForApi']);
Route::get('/api/exhibition', [ExhibitionController::class, 'exhibitionForApi']);


