<?php

use Illuminate\Support\Facades\Route;
use Modules\Duties\Domain\Enums\DutyTypeEnum;
use Modules\Duties\Presentation\Http\Api\DutyEventsController;
use Modules\Duties\Presentation\Http\Api\ImportDutyController;

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

$types = collect(DutyTypeEnum::cases())->map(fn (DutyTypeEnum $type) => $type->value)->implode('|');

Route::get('/duties/events', DutyEventsController::class)->name('duties.events');
Route::post('/duties/import/{type}', ImportDutyController::class)->where('type', $types)->name('duties.import');
