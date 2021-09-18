<?php

namespace App\Http\Resources;


class OrdersDetailResource extends OrderResource
{
    public function toArray($request)
    {
        $collection = parent::toArray($request);
        unset($collection['price']);
        $collection['positions'] = PositionResource::collection($this->positions);
        $collection['price_all'] = $this->getPrice();
        return $collection;
    }
}

