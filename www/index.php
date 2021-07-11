<?php
namespace App;

session_start();

use App\Core\Routing; 
use App\Core\ConstantManager;

require 'vendor/autoload.php';
require "Autoloader.php";
require "vendor/autoload.php";
Autoloader::register();

new ConstantManager();


$uriExploded = explode("?", $_SERVER["REQUEST_URI"]);
//  /ajout-d-un-utilisateur
$_SESSION["uri"] = $uriExploded[0];

$route = new Routing($_SESSION["uri"]);
$c = $route->getController();
$a = $route->getAction();
$dataSlug = $route->getAction();

$cWithNamespace = $route->getControllerWithNamespace();

// if(file_exists("./install.php")){
// 	fopen("install.php", "r+b");
// }
   


//Appeler le bon controller et la bonne action en fonction de $c et $a
//et en faisant les bonnes vérifications

if( file_exists("./Controllers/".$c.".php")){

	include "./Controllers/".$c.".php";

	if(class_exists($cWithNamespace)){
		//$c = App\Security // User
		$cObject = new $cWithNamespace();
		// var_dump($cWithNamespace);

		if(method_exists($cObject, $a)){
			//$a = loginAction // defaultAction
			$cObject->$a();
			// var_dump($a);
		}else{
			$cObject->$a();
		}

	}else{
		die("La classe ".$c." n'existe pas"); 
	}

}else{
	die("Le fichier ".$c." n'existe pas");
}
