<?php

namespace App\Http\Requests\Plugins;

use App\Plugin;
use Illuminate\Foundation\Http\FormRequest;

class CreatePluginFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('create', Plugin::class);;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:4|max:32',
            'description' => 'required|min:32',
        ];
    }
}
