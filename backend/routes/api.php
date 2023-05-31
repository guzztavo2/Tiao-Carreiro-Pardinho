<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\SongController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UtilsController;
use App\Models\FrontEndCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Response;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['controller' => UtilsController::class], function () {

});
Route::get('/reset-data', function (Request $request) {
    \App\Models\DataFetcher::fetchData();
});
Route::controller('')->get('/get-code', function (Request $request) {
    $code = FrontEndCode::getCode();
    header('code:' . FrontEndCode::crypt($code->code));
    return response()->json(['expiration' => $code->expiration], 200);
});

Route::get('album/{id}/image', [AlbumController::class, 'getIndexedImage']);

Route::group(['middleware' => 'front-end.only',], function () {
    Route::group([
        'controller' => UserController::class,
        'prefix' => '/user',
    ], function () {
        Route::post('/check-username', 'checkUserName');
        Route::post('/registro', 'Registro');
        Route::post('/login', 'Login');
        Route::group(['middleware' => 'auth:sanctum'], function () {
            Route::get('/user', 'getUser');
            Route::get('/logout', 'logout');
        });


    });
    Route::group([
        'prefix' => '/album',
        'controller' => AlbumController::class,
        'middleware' => 'front-end.only'
    ], function () {
        Route::get('/', 'getAll');
        Route::middleware(['middleware' => 'auth:sanctum'])->post('/', 'create');

        Route::group(['prefix' => '/{id}'], function () {

            Route::get('/', 'getIndexedElement');


            Route::group(['middleware' => 'auth:sanctum'], function () {
                Route::delete('/', 'deleteIndexed');
                Route::post('/', 'updateIndexed');
            });

            Route::group(['prefix' => '/song', 'controller' => SongController::class], function () {
                Route::get('/', 'getAll');
                Route::post('/', 'create');

                Route::group(['prefix' => '/{id_song}'], function () {
                    Route::group(['middleware' => 'auth:sanctum'], function () {
                        Route::delete('/', 'deleteIndexed');
                        Route::post('/', 'updateIndexed');
                    });
                    Route::get('/', 'getIndexedElement');
                    Route::get('/play', 'playPreview');
                });
            });
        });
    });
});