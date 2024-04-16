<?php
use App\Http\Controllers\ContentManagement\News\NewsController;
use App\Http\Controllers\ContentManagement\Exhibition\ExhibitionController;

/*
|--------------------------------------------------------------------------
| 內容管理 routes
| middleware auth : \App\Http\Middleware\Authenticate::class
| middleware verified : Illuminate\Auth\Middleware\EnsureEmailIsVerified::class
|
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'content-management', 'middleware' => ['auth']], function()
{   

    /*
    |--------------------------------------------------------------------------
    | READ
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | pages
    |--------------------------------------------------------------------------
    */

    //最新消息
    Route::get('news-list', [NewsController::class, 'list'])->middleware(['permission:read news'])->name('content-management.news-list');
    Route::get('create-news', [NewsController::class, 'create'])->middleware(['permission:create news'])->name('content-management.create-news');
    Route::get('edit-news', [NewsController::class, 'edit'])->middleware(['permission:update news'])->name('content-management.edit-news');
    Route::post('store-news', [NewsController::class, 'store'])->middleware(['permission:create news'])->name('content-management.store-news');
    Route::post('modify-news', [NewsController::class, 'modify'])->middleware(['permission:update news'])->name('content-management.modify-news');

    //活動資訊
    Route::get('exhibition-list', [ExhibitionController::class, 'list'])->middleware(['permission:read exhibition'])->name('content-management.exhibition-list');
    Route::get('create-exhibition', [ExhibitionController::class, 'create'])->middleware(['permission:create exhibition'])->name('content-management.create-exhibition');
    Route::get('edit-exhibition', [ExhibitionController::class, 'edit'])->middleware(['permission:update exhibition'])->name('content-management.edit-exhibition');
    Route::post('store-exhibition', [ExhibitionController::class, 'store'])->middleware(['permission:create exhibition'])->name('content-management.store-exhibition');
    Route::post('modify-exhibition', [ExhibitionController::class, 'modify'])->middleware(['permission:update exhibition'])->name('content-management.modify-exhibition');

    /*
    |--------------------------------------------------------------------------
    | modals
    |--------------------------------------------------------------------------
    */

    
    /*
    |--------------------------------------------------------------------------
    | tables
    |--------------------------------------------------------------------------
    */

    //最新消息列表 : ajax get content
    Route::get('news-list-table-header', [NewsController::class, 'tableHeader'])->middleware(['permission:read news'])->name('content-management.news-list-table-header');
    Route::get('news-list-table', [NewsController::class, 'table'])->middleware(['permission:read news'])->name('content-management.news-list-table');

    //活動資訊列表 : ajax get content
    Route::get('exhibition-list-table-header', [ExhibitionController::class, 'tableHeader'])->middleware(['permission:read exhibition'])->name('content-management.exhibition-list-table-header');
    Route::get('exhibition-list-table', [ExhibitionController::class, 'table'])->middleware(['permission:read exhibition'])->name('content-management.exhibition-list-table');
    
    /*
    |--------------------------------------------------------------------------
    | ajaxs
    |--------------------------------------------------------------------------
    */

    //上傳內容圖片
    Route::post('upload-image', [NewsController::class, 'uploadContentImage'])->middleware(['permission:create news'])->name('content-management.upload-image');

    //刪除news
    Route::post('delete-news', [NewsController::class, 'delete'])->middleware(['permission:delete news'])->name('content-management.delete-news');

    //取得news
    Route::get('get-news/{id}', [NewsController::class, 'news'])->middleware(['permission:read news'])->name('content-management.get-news');

    //刪除exhibition
    Route::post('delete-exhibition', [ExhibitionController::class, 'delete'])->middleware(['permission:delete exhibition'])->name('content-management.delete-exhibition');

    //取得exhibition
    Route::get('get-exhibition/{id}', [ExhibitionController::class, 'exhibition'])->middleware(['permission:read exhibition'])->name('content-management.get-exhibition');


});


?>