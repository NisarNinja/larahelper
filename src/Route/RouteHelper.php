<?php

namespace Easoblue\LaraHelper\Route;

class RouteHelper{

	public function getUrl($path){
		if($path && $path !== '/'){
			if(substr($path,0,1) !== '/'){
				$path = '/'.$path;
			}
		}else{
			$path = '';
		}
		return $this->getProtocol().$this->getDomainWithoutSubdomain().$path;
	}


	public function getSubdomainUrl($path = null,$subdomain = null){
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


	public function getProtocol(){

		if (request()->secure())
		{
		  return 'https://';
		}else{
			return 'http://';
		}

	}

	public function getMainHost($host = null){

		if(!$host){
			$host = $_SERVER['HTTP_HOST'];
		}else{
		   // remove http or https
		   $host = preg_replace( "#^[^:/.]*[:/]+#i", "", $host );
		}
		preg_match("/[^\.\/]+\.[^\.\/]+$/", $host, $domain);

		return $domain[0];
	}

	public function getHost(){
		return request()->getHost();
	}

}