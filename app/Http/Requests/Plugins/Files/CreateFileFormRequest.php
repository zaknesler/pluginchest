<?php

namespace App\Http\Requests\Plugins\Files;

use Illuminate\Foundation\Http\FormRequest;

class CreateFileFormRequest extends FormRequest
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
            'file' => 'required|file|mimetypes:application/java-archive',
            'name' => 'required|min:4|max:32',
            'summary' => 'required|min:8',
            'stage' => 'required|in:alpha,beta,release',
            'game_version' => 'required|in:' . implode(',', config('pluginchest.game_versions')),
        ];
    }
}
