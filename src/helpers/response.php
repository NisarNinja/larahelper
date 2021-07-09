<?php

use Easoblue\LaraHelper\Response\Response;

if(!function_exists('e_response')){

	function e_response($data = '',$msg = '',$status = 200)
	{
	    return Response::json($data,$msg,$status);
	}
}