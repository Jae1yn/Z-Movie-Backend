<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseFormRequest;

class LoginRequest extends BaseFormRequest {

  public function rules() {
    return [
      'email' => ['required', 'email'],
      'password' => ['required', 'string'],
    ];
  }
}
