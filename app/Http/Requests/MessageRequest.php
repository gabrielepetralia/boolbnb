<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MessageRequest extends FormRequest
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
            "name" => "max:100|required|min:3",
            "email" => "max:100|required|min:3",
            "msg_text" => "required|min:5"
        ];
    }
    public function messages()
    {
        return [
            "name.required" => "Per inviare un messaggio devi inserire il tuo nome",
            "name.max" => "Il nome può avere un massimo di :max caratteri",
            "name.min" => "Il nome deve avere minimo :min caratteri",
            "email.required" => "Per inviare un messaggio devi inserire la tua mail",
            "email.max" =>"La mail può avere un massimo di :max caratteri",
            "email.min" =>"La mail deve avere minimo :min caratteri",
            "msg_text.required" => "Scrivi un messaggio per il proprietario dell'appartamento",
            "msg_text.min" => "Il messaggio deve avere almeno :min caratteri"
        ];
    }
}
