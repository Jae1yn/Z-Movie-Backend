<?php

namespace App\Http\Requests\Test;

use App\Http\Requests\BaseFormRequest;

class ListRequest extends BaseFormRequest {

  public function rules() {
      return [
          'position_id'      => ['nullable', 'int'],
          'status'           => ['nullable', 'int'],
          'per_page'         => ['nullable', 'int'],
          'page'             => ['nullable', 'int'],
          'operator_id'      => ['nullable', 'int'],
          'real_operator_id' => ['nullable', 'int'],
      ];
  }
}
