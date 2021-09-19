<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\AddPositionRequest;
use App\Http\Requests\Order\AddRequest;
use App\Http\Requests\Order\ChangeStatusRequest;
use App\Http\Requests\Order\RemovePositionRequest;
use App\Http\Requests\Order\ShowRequest;
use App\Http\Resources\OrderResource;
use App\Http\Resources\OrdersDetailResource;
use App\Models\Order;
use App\Models\OrderMenu;
use App\Models\StatusOrder;
use App\Models\WorkShift;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    public function store(AddRequest $request)
    {
        $order = Order::create([
            'table_id' => $request->table_id,
            'number_of_person' => $request->number_of_person,
            'shift_worker_id' => Auth::user()->getShiftWorker($request->work_shift_id)->id,
            'status_order_id' => StatusOrder::where(['code' => 'taken'])->first()->id
        ]);

        return new OrderResource($order);
    }

    public function show(Order $order, ShowRequest $request)
    {
        return new OrdersDetailResource($order);
    }


    public function changeStatus(Order $order, ChangeStatusRequest $request)
    {
        $order->changeStatus($request->status);

        return [
            'data' => [
                'id' => $order->id,
                'status' => $request->status
            ]
        ];
    }

    public function takenOrders()
    {
        $orders = WorkShift::where(['active' => true])
            ->first()
            ->orders
            ->filter(function ($order) {
                return collect(['preparing', 'taken'])->contains($order->status->code);
            });

        return OrderResource::collection($orders);
    }

    public function addPosition(Order $order, AddPositionRequest $request)
    {
        OrderMenu::create([
            'order_id' => $order->id,
            'menu_id' => $request->menu_id,
            'count' => $request->count,
        ]);

        return new OrdersDetailResource($order);
    }

    public function removePosition(Order $order, OrderMenu $orderMenu, RemovePositionRequest $request)
    {
        $orderMenu->delete();
        return new OrdersDetailResource($order);
    }
}
