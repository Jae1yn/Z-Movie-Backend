<?php


namespace App\Rules;


use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Password implements ValidationRule {

    public function validate(string $attribute, mixed $value, Closure $fail): void {
        if (preg_match("/^[\w\\/\-\.$@!%#?&]{6,20}$/", $value)) {
            $fail(trans('validation.custom.password.regex'));
        }
    }
}
