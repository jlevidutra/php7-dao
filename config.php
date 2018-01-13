<?php 

spl_autoload_register(function($className) {

	$classPath = "class";
	$filename = $classPath . DIRECTORY_SEPARATOR . $className.".php";
	
	if (file_exists($filename)) require_once($filename);
});

?>