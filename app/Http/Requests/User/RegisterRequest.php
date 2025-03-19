<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseFormRequest;
use App\Models\User;
use App\Rules\Password;
use App\Rules\WeakPassword;
use Illuminate\Validation\Rule;

class RegisterRequest extends BaseFormRequest {

    public function rules() {

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255', 'email', Rule::unique(User::TABLE_NAME, 'email')->whereNull('deleted_at')],
            'password' => ['required', 'string', new Password(), new WeakPassword(), 'confirmed'],
            'password_confirmation' => ['required', 'string', new Password(), new WeakPassword()],
        ];
    }
}
