<?php

namespace App\Http\Requests\User;

use App\Common\Constants;
use App\Http\Requests\BaseFormRequest;
use App\Models\User;
use Illuminate\Validation\Rule;

class UpdateRequest extends BaseFormRequest {

    public function rules() {
        $id = app(Constants::USER_LOGIN)['id'];
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255', 'email',
                Rule::unique(User::TABLE_NAME, 'email')
                ->where(function ($query) use ($id) {
                    return $query->where('id', '<>', $id)->whereNull('deleted_at');
                })],
        ];
    }
}
