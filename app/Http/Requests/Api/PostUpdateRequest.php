<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Nhanduc\Core\Func\Exceptions\JsonValidation;

class PostUpdateRequest extends FormRequest
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
        return [
            'name' => 'required|unique:categories,name,' . $this->id,
            'slug' => 'required|unique:categories,slug,' . $this->id,
            'category_id' => 'required'
        ];
    }

    /**
	 * Conver Array that apply to the request.
	 *
	 * @return array
	*/
	protected function failedValidation(Validator $validator) {
		throw new JsonValidation($validator);
    }
}
