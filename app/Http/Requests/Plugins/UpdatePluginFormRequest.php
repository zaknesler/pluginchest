<?php

namespace App\Http\Requests\Plugins;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePluginFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $plugin = $this->route('plugin');

        return $plugin && $this->user()->can('update', $plugin);
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
