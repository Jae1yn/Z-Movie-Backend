<?php

namespace App\Exceptions;

use App\Common\Code;
use Exception;

class CodeException extends Exception
{
	protected $code;
	protected $other;

	public function __construct($code, $message = '')
	{
		$this->code = $code;
        $this->message = !empty($message) ? $message  :  trans('error')[$code];
	}
	
	public function render()
	{
		return codeRender($this->code,'',$this->message);
	}

	public function message()
    {
        return $this->message;
    }
}