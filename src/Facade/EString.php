<?php

namespace Easoblue\LaraHelper\Facade;

use Illuminate\Support\Facades\Facade;

class EString extends Facade {
   protected static function getFacadeAccessor() { 
   	return 'EString'; 
   }
}