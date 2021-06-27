<?php

namespace Easoblue\LaraHelper\Facade;

use Illuminate\Support\Facades\Facade;

class LaraHelper extends Facade {
   protected static function getFacadeAccessor() { 
   	return 'LaraHelper'; 
   }
}