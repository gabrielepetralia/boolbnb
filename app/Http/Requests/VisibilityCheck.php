<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VisibilityCheck extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
          "num_rooms" => 'required',
          "num_beds" => 'required',
          "num_bathrooms" => 'required',
          "square_meters" => 'required',
          "address" => 'required',
          "description" => 'required|min:5',
          "price" => 'required'
        ];
    }

    public function messages()
    {
        return [
          "num_rooms.required" => 'Per rendere pubblico un annuncio è necessario inserire le stanze',
          "num_beds.required" => 'Per rendere pubblico un annuncio è necessario inserire i letti disponibili',
          "num_bathrooms.required" => 'Per rendere pubblico un annuncio è necessario inserire il numero di bagni presenti',
          "square_meters.required" => "Per rendere pubblico un annuncio è necessario inserire i metri quadri dell'appartamento",
          "address.required" => 'Per rendere pubblico un annuncio è necessario inserire la via o la città',
          "description.required" => 'La descrizione deve contenere minimo :min caratteri.',
          "description.required" => 'Per rendere pubblico un annuncio è necessario inserire una breve descrizione',
          "price.required" => 'Per rendere pubblico un annuncio è necessario inserire il prezzo'
        ];
    }
}
