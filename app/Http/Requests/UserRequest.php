<?php

namespace App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'  => 'required | max:20',
            'email' => 'required|email| unique:users,email,'.Auth::id(),
            'contact'=>'required | numeric | min:8',
            'district' => 'required',
            'nhood' => 'required',
        ];
    }
}
