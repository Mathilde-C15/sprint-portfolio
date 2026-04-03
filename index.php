<?php


spl_autoload_register(function($classname){
    
    var_dump($classname);
    // remplacer le \ du namespace par un /
    // et enlever le PascalCase du namespace 
    $path = lcfirst(str_replace('\\','/',$classname));
    var_dump($path);
    // rajouter l'extention .php au chemin vers mon fichier 
    $filename = $path.'.php';
    var_dump($filename);
    // On inclut le fichier si il existe 
    if(file_exists($filename)){
        include $filename;
    }
});


$page = $_GET['page'] ?? '/';

use Service\Router;

$router = new Router($page);
$router->getController();
