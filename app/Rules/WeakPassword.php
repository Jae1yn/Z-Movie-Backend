<?php


namespace App\Rules;


use App\Support\WeakPwd;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class WeakPassword implements ValidationRule {

    public function validate(string $attribute, mixed $value, Closure $fail): void {
        if (WeakPwd::validation($value)) {
            $fail(trans('validation.custom.password.weak'));
        }
    }
}
