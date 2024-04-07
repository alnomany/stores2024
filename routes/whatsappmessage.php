<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\addons\WhatsappmessageController;
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


Route::group(['namespace' => 'admin', 'prefix' => 'admin'], function () {

    Route::middleware('VendorMiddleware')->group(function () {
        Route::post('/settings/whatsapp_update', [WhatsappmessageController::class, 'whatsapp_update']);
    });
});
