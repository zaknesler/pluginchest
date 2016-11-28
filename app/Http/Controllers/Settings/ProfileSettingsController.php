<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\UpdateProfileFormRequest;

class ProfileSettingsController extends Controller
{
    /**
     * Update the user's profile settings.
     *
     * @param  App\Http\Requests\Settings\UpdateProfileFormRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateProfileFormRequest $request)
    {
        $request->user()->update($request->only([
            'name',
            'email',
        ]));

        flash('Your profile settings have been updated.');

        return redirect()->route('settings.index');
    }
}
