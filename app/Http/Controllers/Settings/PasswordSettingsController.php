<?php

namespace App\Http\Controllers\Settings;

use Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\UpdatePasswordFormRequest;

class PasswordSettingsController extends Controller
{
    /**
     * Update the user's profile settings.
     *
     * @param  App\Http\Requests\Settings\UpdatePasswordFormRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdatePasswordFormRequest $request)
    {
        $user = $request->user();

        if (!Hash::check($request->input('old_password'), $user->password)) {
            flash()->error('Your old password is incorrect.');

            return redirect()->route('settings.index');
        }

        $request->user()->update([
            'password' => bcrypt($request->input('password')),
        ]);

        flash('Your password has been updated.');

        return redirect()->route('settings.index');
    }
}
