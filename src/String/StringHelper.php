<?php

namespace Easoblue\LaraHelper\String;

class StringHelper{

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

	private function prefix($prefix){
		$this->prefix = $prefix;
		return $this;
	}

	private function postfix($postfix){
		$this->postfix = $postfix;
		return $this;
	}

	private function findUnique($value = null){
		$check = DB::table($this->table)->where($this->key_name,$value)->first();
		if(!$check){
			return true;
		}
		return false;
	}

	public function toUnderscore($text){

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

}