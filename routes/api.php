<?php

use App\Http\Controllers;
use Illuminate\Support\Facades\Route;

//Аутентификация и выход
Route::post('/login', [Controllers\UserController::class, 'login']);
//Route::middleware('auth:api')->get('/logout', [Controllers\UserController::class, 'logout']);
Route::middleware('auth:api')->get('/logout', [Controllers\UserController::class, 'logout']);

//АДМИНИСТРАТОР
//Просмотр всех сотрудников и добавление нового
Route::apiResource('user', Controllers\UserController::class, ['only' => ['index', 'store']]);

//Работа со сменой
Route::prefix('work-shift')->group(function () {
    //Создание смены
    Route::post('/', [Controllers\WorkShiftController::class, 'store']);
    //Открытие из закрытие смены
    Route::get('/{workShift}/open', [Controllers\WorkShiftController::class, 'open']);
    Route::get('/{workShift}/close', [Controllers\WorkShiftController::class, 'close']);
    //Добавление работника на смену
    Route::post('/{workShift}/user', [Controllers\WorkShiftController::class, 'addUser']);
    //Просмотр заказов на определенную смену. ДОСТУПЕН и ОФИЦИАНТУ
    Route::get('/{workShift}/order', [Controllers\WorkShiftController::class, 'orders']);
});

//ОФИЦИАНТ
//Просмотр конкретного заказа. Создание заказа для определенного столика
Route::apiResource('order', Controllers\UserController::class, ['only' => ['show', 'store']]);
Route::prefix('order')
    ->group(function () {
        //Добавление и удалении позиции в заказе
        Route::post('/{order}/position', [Controllers\OrderController::class, 'addPosition']);
        Route::delete('/{order}/position/{orderMenu}', [Controllers\OrderController::class, 'removePosition']);
        //Изменение статуса заказа. ДОСТУПЕН и ПОВАРУ
        Route::patch('/{order}/change-status', [Controllers\OrderController::class, 'changeStatus']);
//ПОВАР
        //Просмотр заказов текущей смены
        Route::get('/taken', [Controllers\OrderController::class, 'takenOrders']);
    });

