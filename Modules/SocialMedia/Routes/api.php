<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\SocialMedia\Http\Controllers\api\SocialMediaController;

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

Route::middleware('auth:api')->get('/socialmedia', function (Request $request) {
    return $request->user();
});

Route::apiResource('social-media', SocialMediaController::class)->except('edit','create');