<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Booking extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user' => $this->user,
            'wajba' => $this->wajba,
            'status' => $this->status,
            'payment' => $this->payment,
            'time' => $this->time,
            'numberOfMeals' => $this->numberOfFemales, 
            'numberOfMales' => $this->numberOfMales,
            'numberOfChildren' => $this->numberOfChildren,
            'totalAmount' => $this->totalAmount,
            'is_rated' => $this->is_rated,
        ];
    }
}
