<?php declare(strict_types=1);

namespace Mzb\Framework\Router;

use Mzb\Framework\Router\Router;
use Symfony\Component\HttpFoundation\Request;

class Route
{
    public $callable;
    public array $matches = [];
    private array $params = [];
    public string $method;
    public string $name;

    public function __construct(string $method, string $path, $callable, string $name = null)
    {
        $this->method = $method;
        $this->path = trim($path, '/');
        $this->callable = $callable;
        $this->name = $name;
    }

     

    public function match($url)
    {
        //$url = Request::createFromGlobals()->getPathInfo();
        //$url = $_SERVER['REQUEST_URI'] ?? '/';
        $url = trim($url, '/');
        $path = preg_replace('#:([\w]+)#', '([^/]+)', $this->path);
        $regex = "#^$path$#i";
        if (!preg_match($regex, $url, $matches)) {
            return false;
        }
        array_shift($matches);
        var_dump($matches);
        $this->matches = $matches;
        
        return true;
    }

    public function call()
    {
        if (is_string($this->callable)) {
            $params = explode('@', $this->callable);
            $controller = router::getNameSpace() . $this->getController();
            $action = $params[1];
            $controller = new $controller;
           
            return call_user_func_array([$controller, $action], $this->matches);
        } else {
            return call_user_func_array($this->callable, $this->matches);
        }
    }

    public function getController()
    {
        if (is_string($this->callable)) {
            $params = explode('@', $this->callable);
            return $params[0];
        }
    }
}
