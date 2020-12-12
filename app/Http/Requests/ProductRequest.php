<?php

namespace App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        if($this->url === 'house'){
            $rule['property_1'] = 'required';
            $rule['property_2'] = 'required';
            $rule['property_3'] = 'required';
            $rule['filter_1_id'] = 'required';
            $rule['filter_2_id'] = 'required';
            $rule['filter_3_id'] = 'required';
            $rule['type_id'] = 'required';
            $rule['status_id'] = 'required';
            $rule['filter_id'] = 'required';
        }

        if($this->url === 'shop'){
            $rule['property_2'] = 'required';
            $rule['property_3'] = 'required';
            $rule['filter_1_id'] = 'required';
            $rule['filter_2_id'] = 'required';
            $rule['filter_3_id'] = 'required';
            $rule['type_id'] = 'required';
            $rule['status_id'] = 'required';
            $rule['filter_id'] = 'required';
        }

        if($this->url === 'land'){
            $rule['property_3'] = 'required';
            $rule['filter_1_id'] = 'required';
            $rule['filter_3_id'] = 'required';
            $rule['type_id'] = 'required';
        }

        if($this->url === 'mobile'){
            $rule['brand_id'] = 'required';
            $rule['filter_1_id'] = 'required';
            $rule['filter_2_id'] = 'required';
            $rule['status_id'] = 'required';
            //$rule['type_id'] = 'required';
        }

        if($this->url === 'bike' || $this->url === 'car'){
            $rule['status_id'] = 'required';
            $rule['property_1'] = 'required';
            $rule['property_2'] = 'required';
            $rule['type_id'] = 'required';
            $rule['brand_id'] = 'required';
        }

        if($this->url === 'job'){
            $rule['maxprice'] = 'required | numeric';
            $rule['type_id'] = 'required';
            $rule['filter_id'] = 'required';
        }

        $rule['title'] = 'required| max:100 | min:10';
        $rule['description'] = 'required | max:4000 | min:20';
        $rule['price'] = 'required | numeric';
        $rule['nhood_id'] = 'required';
        $rule['city_id'] = 'required';
        $rule['address'] = 'required';
        $rule['image.*'] = 'mimes:jpeg,png,jpg,gif,svg|max:20648';
        
        return $rule;
    }
}
