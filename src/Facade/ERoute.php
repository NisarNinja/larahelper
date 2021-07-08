<?php

namespace Easoblue\LaraHelper\Facade;

use Illuminate\Support\Facades\Facade;

class ERoute extends Facade {
   protected static function getFacadeAccessor() { 
   	return 'ERoute'; 
   }
}