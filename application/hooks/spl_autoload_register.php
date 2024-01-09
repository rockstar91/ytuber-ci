<?php
function _spl_autoload_register() {
	spl_autoload_register(
	    function ($className) {
	      $classPath = explode('\\', $className);
	      //$classPath = array_slice($classPath, 1, 2);

	      $filePath = APPPATH . '/libraries/' . implode('/', $classPath) . '.php';
	      if (file_exists($filePath)) {
	        require_once($filePath);
	      }
	    }
	);
}