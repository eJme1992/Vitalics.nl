<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Auth;
class UserRequest extends FormRequest
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
        switch ($this->method()) {
            case 'POST':
            {
                return [
                    'name' => 'string|required',
                    'email' => 'required|email',
                    // 'birthdate' => 'required',
                    'phone' => 'required|numeric',
                    // 'estado' => 'required',
                    'cargo' => 'required',
                    'nationality' => 'required',
                    'address' => 'required|string',
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    
                    //below way will only work in Laravel ^5.5 
                    'email' => Rule::unique('users')->ignore(Auth::user()->id)
    
                ];
            }
            default: break;
        }
    }
}
