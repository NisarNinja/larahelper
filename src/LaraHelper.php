<?php

namespace Easoblue\LaraHelper;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class LaraHelper{

	protected $checkUnique = false;
	protected $isUnique = false;
	protected $prefix = '';
	protected $postfix = '';

	protected $table = false;
	protected $key_name = false;

	public function generateString($type = 'numeric', $length = 8 ){
		switch ( $type ) {
			case 'alnum':
				$pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
				break;
			case 'alpha':
				$pool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
				break;
			case 'hexdec':
				$pool = '0123456789abcdef';
				break;
			case 'numeric':
				$pool = '0123456789';
				break;
			case 'nozero':
				$pool = '123456789';
				break;
			case 'distinct':
				$pool = '2345679ACDEFHJKLMNPRSTUVWXYZ';
				break;
			default:
				$pool = (string) $type;
				break;
		}


		$crypto_rand_secure = function ( $min, $max ) {
			$range = $max - $min;
			if ( $range < 0 ) return $min; // not so random...
			$log    = log( $range, 2 );
			$bytes  = (int) ( $log / 8 ) + 1; // length in bytes
			$bits   = (int) $log + 1; // length in bits
			$filter = (int) ( 1 << $bits ) - 1; // set all lower bits to 1
			do {
				$rnd = hexdec( bin2hex( openssl_random_pseudo_bytes( $bytes ) ) );
				$rnd = $rnd & $filter; // discard irrelevant bits
			} while ( $rnd >= $range );
			return $min + $rnd;
		};

		$token = "";
		$max   = strlen( $pool );
		for ( $i = 0; $i < $length; $i++ ) {
			$token .= $pool[$crypto_rand_secure( 0, $max )];
		}
		if($this->prefix){
			$token = $this->prefix.$token;
		}
		if($this->postfix){
			$token = $token.$this->postfix;
		}
		if($this->checkUnique){
			$check = $this->findUnique($token);
			if($check){
				return $token;
			}else{
				return $this->generateString($type,$length);
			}
		}
		return $token;
	}

	public function checkUnique($table,$key_name){
		$this->checkUnique = true;
		$this->table = $table;
		$this->key_name = $key_name;

		return $this;
	}

	public function prefix($prefix){
		$this->prefix = $prefix;
		return $this;
	}

	public function postfix($postfix){
		$this->postfix = $postfix;
		return $this;
	}

	protected function findUnique($value = null){
		$check = DB::table($this->table)->where($this->key_name,$value)->first();
		if(!$check){
			return true;
		}
		return false;
	}

	public function formatValidatorError($validator){

        $errors = [];
        foreach ($validator->errors()->getMessages() as $key => $value) {
         Arr::set($errors,$key,$this->formatToSpacedText($value[0]));
        }

        return $errors;

	}

	public function formatToSpacedText($text){
		if($text){
           return ucfirst(str_replace('_'," ",$text));
        }
	}

	public function formatToCamelCase($text){
		$pattern = '!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!';
	  	preg_match_all($pattern, $text, $matches);
	  	$ret = $matches[0];
	  	foreach ($ret as &$match) {
	    $match = $match == strtoupper($match) ?
	      	strtolower($match) :
	    	lcfirst($match);
	  	}
	  	return implode('_', $ret);
	}

	public function urlSubdomain($path = null,$subdomain = null){
		if(!$subdomain){
			$subdomain = config('larahelper.helpers.domain.options.default_subdomain');
		}
		if($path && $path !== '/'){
			if(substr($path,0,1) !== '/'){
				$path = '/'.$path;
			}
		}else{
			$path = '';
		}
		return $this->getProtocol().$subdomain.'.'.$this->getDomainWithoutSubdomain().$path;
	}

	public function urlDomain($path){
		if($path && $path !== '/'){
			if(substr($path,0,1) !== '/'){
				$path = '/'.$path;
			}
		}else{
			$path = '';
		}
		return $this->getProtocol().$this->getDomainWithoutSubdomain().$path;
	}

	public function getProtocol(){

		if (request()->secure())
		{
		  return 'https://';
		}else{
			return 'http://';
		}

	}

	public function getDomainWithoutSubdomain($host = null){

		if(!$host){
			$host = $_SERVER['HTTP_HOST'];
		}else{
		   // remove http or https
		   $host = preg_replace( "#^[^:/.]*[:/]+#i", "", $host );
		}
		preg_match("/[^\.\/]+\.[^\.\/]+$/", $host, $domain);

		return $domain[0];

	}

	public function getUrlPathOnly($url){
		return str_replace(url('/'),'',$url);
	}

}