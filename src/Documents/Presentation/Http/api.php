<?php

use Illuminate\Support\Facades\Route;
use Modules\Documents\Presentation\Http\Api\UploadDocumentController;

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

Route::post('/documents/upload', UploadDocumentController::class)->name('documents.upload');
