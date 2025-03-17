<?php
/**
 * author：liuwen
 */

namespace App\Http\Requests\User;

use App\Http\Requests\BaseFormRequest;
use App\Rules\Password;
use App\Rules\WeakPassword;

class ChangePasswordRequest extends BaseFormRequest {

    public function rules() {
        return [
            'old_password' => ['required', 'string'],
            'password' => ['required', 'string', new Password(), new WeakPassword(), 'confirmed'],
            'password_confirmation' => ['required', 'string', new Password(), new WeakPassword()],
        ];
    }
}
