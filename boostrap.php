<?php declare(strict_types=1);

namespace Mzb;

use Mzb\Router\Router;



require_once __DIR__.'/vendor/autoload.php';



$router = new Router();

router::setNameSpace('Mzb\\Controller\\');

$router->add('GET', '/', 'HomeController@index', 'home');

$router->add('GET', '/about', 'HomeController@about', 'about-us');

$router->add('GET', '/about/:id/:slug', 'AboutController@about', 'about-us');

$router->add('GET', '/contact', function () { echo 'Contact'; }, 'contact');




echo '<h3>' . $router->generateUri('home') .'</h3>';
echo '<h3>' . $router->generateUri('about-us').'</h3>';
echo '<h3>' . $router->generateUri('contact').'</h3>';




$router->dispatch();
