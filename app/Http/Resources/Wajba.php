<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Wajba extends JsonResource
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
            'host' => $this->host,
            'host_photo' => $this->host->user->photo,
            'status' => $this->status->type,
            'place' => $this->place_category,
            'food' => $this->food_category,
            'title' => $this->title,
            'price' => $this->price,
            'description' => $this->description,
            'door_type' => $this->door_type,
            'healthConditionsAndWarnings' => $this->healthConditionsAndWarnings,
            'city' => $this->city,
            'city_name' => $this->city_name,
            'baseNumberOfSeats' => $this->baseNumberOfSeats,
            'totalRate' => $this->totalRate,
            'dates' => $this->dates,
            'time' => $this->time,
            'homepage_photo' => $this->photos()->where('type', 0)->get(),
            'banner_photo' => $this->photos()->where('type', 1)->get(),
            'gallery_photos' => $this->photos()->where('type', 2)->get(),
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'created_at' => (string)$this->created_at,
            'updated_at' => (string)$this->updated_at,
        ];
    }
}
