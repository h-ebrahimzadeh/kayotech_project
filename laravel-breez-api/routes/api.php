<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
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

//Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return response()->json([
        'user' => auth()->user(),
        'role' => auth()->user()->getRoleNames()
    ]);
});

Route::group(['middleware'=>'auth:sanctum'],function (){
    Route::put('/user/update', [UserController::class, 'update'])->name('user.update');

});
Route::group(['middleware' => ['auth:sanctum', 'role:admin|Super-Admin']], function () {
    Route::group([
        'prefix' => 'admin',
        'as' => 'admin.',
    ], function () {
        Route::get('/users', [UserController::class, 'index'])->name('users');
        Route::put('/user/suspend/{user}', [UserController::class, 'suspend'])->name('user.suspend');
        Route::put('/user/unsuspend/{user}', [UserController::class, 'unsuspend'])->name('user.unsuspend');

    });
});
