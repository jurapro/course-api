<?php

use App\Http\Controllers;
use Illuminate\Support\Facades\Route;

//Аутентификация и выход
Route::post('/login', [Controllers\UserController::class, 'login'])->withoutMiddleware(['auth:api']);
Route::get('/logout', [Controllers\UserController::class, 'logout']);

//АДМИНИСТРАТОР
//Просмотр всех сотрудников и добавление нового
Route::middleware('role:admin')
    ->apiResource('user', Controllers\UserController::class, ['only' => ['index', 'store']]);

//Работа со сменой
Route::middleware('role:admin')
    ->prefix('work-shift')->group(function () {
        //Создание смены
        Route::post('/', [Controllers\WorkShiftController::class, 'store']);
        //Открытие из закрытие смены
        Route::get('/{workShift}/open', [Controllers\WorkShiftController::class, 'open']);
        Route::get('/{workShift}/close', [Controllers\WorkShiftController::class, 'close']);
        //Добавление работника на смену
        Route::post('/{workShift}/user', [Controllers\WorkShiftController::class, 'addUser']);
    });

//Просмотр заказов на определенную смену. ДОСТУПЕН и ОФИЦИАНТУ
Route::middleware('role:admin|waiter')
    ->get('work-shift/{workShift}/order', [Controllers\WorkShiftController::class, 'orders']);

//ПОВАР
//Просмотр заказов текущей смены
Route::middleware('role:cook')
    ->get('order/taken', [Controllers\OrderController::class, 'takenOrders']);

//Изменение статуса заказа. ДОСТУПЕН и ПОВАРУ
Route::middleware('role:waiter|cook')
    ->patch('order/{order}/change-status', [Controllers\OrderController::class, 'changeStatus']);

//ОФИЦИАНТ
//Просмотр конкретного заказа. Создание заказа для определенного столика
Route::middleware('role:waiter')
    ->apiResource('order', Controllers\UserController::class, ['only' => ['show', 'store']]);

Route::middleware('role:waiter')
    ->prefix('order')->group(function () {
        //Добавление и удалении позиции в заказе
        Route::post('/{order}/position', [Controllers\OrderController::class, 'addPosition']);
        Route::delete('/{order}/position/{orderMenu}', [Controllers\OrderController::class, 'removePosition']);
    });




