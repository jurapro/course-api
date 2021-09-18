<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\AddRequest;
use App\Http\Requests\Order\ShowRequest;
use App\Http\Resources\OrderResource;
use App\Http\Resources\OrdersDetailResource;
use App\Models\Order;
use App\Models\ShiftWorker;
use App\Models\StatusOrder;
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


    public function changeStatus()
    {
    }

    public function takenOrders()
    {
    }

    public function addPosition()
    {
    }

    public function removePosition()
    {
    }
}
