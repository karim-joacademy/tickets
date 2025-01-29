<?php

use App\Http\Controllers\Api\V1\TicketControllers\TicketController;
use Illuminate\Support\Facades\Route;

Route::apiResource('tickets', TicketController::class);
