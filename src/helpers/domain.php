<?php

use Easoblue\LaraHelper\Facade\LaraHelper;
 
 
if(!function_exists('url_subdomain')){

	function url_subdomain($path = null,$subdomain = null)
	{
	    return LaraHelper::urlSubdomain($path,$subdomain);
	}
}

if(!function_exists('url_domain')){

	function url_domain($path)
	{
	    return LaraHelper::urlDomain($path);
	}
}

if(!function_exists('getUrlPathOnly')){

	function getUrlPathOnly($url)
	{
	    return LaraHelper::getUrlPathOnly($url);
	}
}

if(!function_exists('url_domain_route')){

	function url_domain_route($path)
	{
	    return url_domain(getUrlPathOnly(route($path)));
	}
}

if(!function_exists('url_subdomain_route')){

	function url_subdomain_route($path,$subdomain = null)
	{
	    return url_subdomain(getUrlPathOnly(route($path)),$subdomain);
	}
}