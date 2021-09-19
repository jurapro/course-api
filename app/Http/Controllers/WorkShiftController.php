<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\GetOrdersRequest;
use App\Http\Requests\Shift\CloseRequest;
use App\Http\Requests\Shift\OpenRequest;
use App\Http\Requests\Shift\ShiftWorkerRequest;
use App\Http\Requests\Shift\WorkShiftRequest;
use App\Http\Resources\WorkShiftOrdersResource;
use App\Http\Resources\WorkShiftResource;
use App\Models\ShiftWorker;
use App\Models\WorkShift;

class WorkShiftController extends Controller
{
    public function store(WorkShiftRequest $request)
    {
        return WorkShift::create($request->all());
    }

    public function open(WorkShift $workShift, OpenRequest $request)
    {
        return new WorkShiftResource($workShift->open());
    }

    public function close(WorkShift $workShift, CloseRequest $request)
    {
        return new WorkShiftResource($workShift->close());
    }

    public function addUser(WorkShift $workShift, ShiftWorkerRequest $request)
    {
        ShiftWorker::create([
            'work_shift_id' => $workShift->id,
            'user_id' => $request->user_id
        ]);

        return response()->json([
            'data' => [
                'id_user' => $request->user_id,
                'status' => 'added'
            ]
        ])->setStatusCode(201, 'Created');
    }

    public function orders(WorkShift $workShift, GetOrdersRequest $request)
    {
        return new WorkShiftOrdersResource($workShift);
    }
}
