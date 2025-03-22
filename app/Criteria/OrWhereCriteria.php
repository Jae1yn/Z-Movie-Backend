<?php

namespace App\Criteria;

use Illuminate\Support\Arr;
use Prettus\Repository\Contracts\RepositoryInterface;

class OrWhereCriteria extends BaseCriteria {

    public function apply($model, RepositoryInterface $repository) {
        if (is_array($this->key)) {
            $model = $model->where(function ($query) {
                foreach ($this->key as $item) {
                    $value = Arr::get($this->params, $item, '');
                    !empty($value) && $query->orWhere($item, '=', $value);
                }
            });
        }
        if (is_string($this->key)) {
            $value = Arr::get($this->params, $this->key, '');
            !empty($value) && $model = $model->where($this->key, '=', $value);;
        }
        return $model;
    }
}
