<?php


namespace App\Http\Traits;


use App\Http\Requests\BaseFormRequest;
use App\Support\Collection;

trait FilterTrait
{

    public function filter(BaseFormRequest $request)
    {
        $params = $request->all();
        $params = array_filter($params, function ($value) {
            return !is_null($value);
        });
        return Collection::filter(array_keys($request->rules()), $params);
    }
}
