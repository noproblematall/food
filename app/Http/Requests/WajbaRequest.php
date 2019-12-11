<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WajbaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // dd(count($this->input('photos')));
        $rules = [
            'place_category_id' => 'required',
            'food_category_id' => 'required',
            'title' => 'required',
            'description' => 'required',
            'price' => 'required',
            'door_type' => 'required',
            'city' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ];
// dd($this->input('photos'));
        // $photos = count($this->input('photos'));
        // foreach(range(0, $photos) as $index) {
        //     $rules['photos.' . $index] = 'image|mimes:jpeg,bmp,png|max:2000';
        // }

        return $rules;
    }
}
