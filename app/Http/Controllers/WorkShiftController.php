<?php

namespace App\Http\Controllers;

use App\Http\Requests\Shift\CloseRequest;
use App\Http\Requests\Shift\OpenRequest;
use App\Http\Requests\Shift\WorkShiftRequest;
use App\Http\Resources\WorkShiftResource;
use App\Models\WorkShift;

class WorkShiftController extends Controller
{
    public function store(WorkShiftRequest $request)
    {
        return WorkShift::create($request->all());
    }

    public function open(WorkShift $workShift, OpenRequest $openRequest)
    {
        return new WorkShiftResource($workShift->open());
    }

    public function close(WorkShift $workShift, CloseRequest $closeRequest)
    {
        return new WorkShiftResource($workShift->close());
    }

    public function addUser()
    {
    }

    public function orders()
    {
    }
}
