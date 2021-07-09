<?php

namespace Easoblue\LaraHelper\Response;

class Response{

	public static function json($data = '',$msg = '',$status = 200){

    	return response([
    		'status' => $status,
    		'data' => $data,
    		'msg' => ($msg ? $msg :self::message($status)),
    	]);

    }
 
    public static function message($status){

        switch ($status) {
          case 200:
            return "OK";
            break;
          case 400:
            return "Bad Request";
            break;
          case 401:
            return "Unauthorized";
            break;
          case 500:
            return "Internal Server Error";
            break;
          default:
            return "OK"; 
        }

    }

}