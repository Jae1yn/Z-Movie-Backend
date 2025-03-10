<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use App\Http\Requests\Test\ListRequest;

class TestController extends Controller {
    public function list(ListRequest $request) {
        $params = $this->filter($request);
        return codeRender(200);
    }
}
