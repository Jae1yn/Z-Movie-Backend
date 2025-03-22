<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseFormRequest;

class LoginRequest extends BaseFormRequest {

  public function rules() {
    return [
      'account' => ['required', 'string'],
      'password' => ['required', 'string'],
    ];
  }
}
