<?php

namespace App\Http\Requests\Plugins\Files;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFileFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $pluginFile = $this->route('pluginFile');

        return $pluginFile && $this->user()->can('update', $pluginFile);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // 'file' => 'required|file|mimetypes:application/java-archive',
            'name' => 'required|min:4|max:32',
            'summary' => 'required|min:8',
            'stage' => 'required|in:' . implode(',', config('pluginchest.file_stages')),
            'game_version' => 'required|in:' . implode(',', config('pluginchest.game_versions')),
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'file.mimetypes' => 'A .jar file is required.',
        ];
    }
}
