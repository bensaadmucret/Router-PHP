<?php declare(strict_types=1);

namespace Mzb\Router;

use Mzb\Router\Route;
use Mzb\RouterException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Router
{
    private string $url;
    private array $routes = [];
    public static $namespace;
    public $callable;
    private string $method;
    public string $generateUri;

    public function __construct()
    {
        $request = Request::createFromGlobals();
        $this->url = $request->getPathInfo();
        $this->method = $request->getMethod();
        
        
    }


    /**
     * add route with callable function or class
     * @param string $url
     * @param $callable
     * @param string $method
     * @param string $name
     */
    public function add(string $method, string $path, $callable, string $name)
    {
        $route = new Route($method, $path, $callable, $name);
        $this->routes[] =  array_merge($this->routes, [$route]);
    }


    /**
     * boucle sur les routes pour trouver une correspondance avec l'url courante
     * si une correspondance est trouvée, on retourne le nom de la route
     *
     * @return string
     */
    public function getName(): string
    {
     
         foreach ($this->routes as $route) {         
            foreach ($route as $r) {
               return $r->name;
            }
        }
        return '';
    }
   
    /**
     * retourne la méthode courante
     * @return string
     * @return method [GET, POST, PUT, DELETE]
     */
   
    public function getMethod(): string
    {
        foreach ($this->routes as $route) {
            foreach ($route as $r) {
                return $r->method;
            }
        }   
        
        
        
    }
    

    /**
     * retourne le namespace
     * @return string
     */
    public static function getNameSpace(): string
    {
        return self::$namespace;
    }

    /**
     * retourne la route en fonction de l'url courante
     * @return url of request
     */
    public function getRoute()
    {
        foreach ($this->routes as $route) {
            foreach ($route as $r) {                
                    return '/' . $r->path;                
            }
        }
        return null;
    }

    /**
     * retourne la route en fonction du nom
     * @param string $name
     * @return NameRoute
     */
    public function getRouteByName($name)
    {
        foreach ($this->routes as $route) {
            foreach ($route as $r) {
                if ($r->name == $name) {
                    return '/' . $r->path;
                }
            }
        }
        return null;
    }

    /**
     * retourne la route en fonction du callable
     * @param string $callable
     * @return Route
     */
    public function getRouteByCallable(string $callable): Route
    {
        foreach ($this->routes as $route) {
            foreach ($route as $r) {
                if ($r->callable == $callable) {
                    return $r;
                }
            }
        }
        return null;
    }

    

    
    
    /**
     * Génère l'url à partir d'un nom de route
     * @param string $name
     * @param array $params
     * @return string
     */
    public function generateUri($name): string
    {
        $html = '';
       
            foreach ($this->routes as $route) {
                foreach ($route as $r) { 
                                    
                    if ($r->name == $name) {
                        $is_url = $r->path === '/' ? $r->path : '/' . $r->path;
                        $html = '<a href="' . $is_url . '">' . $r->name . '</a>';
                    }
                }
                
            }     
          
       
        return $html;
    }
    
    
    /**
     * @return string
     */
    public function getPath()
    {
        return $this->url;
    }
        
   
    /**
     *
     * @param string $url
     * @return void
     * @throws RouterException
     * @throws \Exception
     */
    public function run()
    {
        foreach ($this->routes as $route) {
            
            foreach ($route as $r) {
               
                if (!isset($r->method)) {
                    throw new RouterException('REQUEST_METHOD does not exist');
                }
              
                if ($r->match($r->path) && $r->method == $this->method) {
                    return $r->call();
                }
            }
        }
        throw new RouterException('No matching routes');
    }

    

  


    /**
     * redirect to a route
     * @return void
     */
    public  static function redirect(string $location, int $code)
    {
        $response = new Response();
        $response->headers->set('Location', $location);
        $response->setStatusCode($code);
        $response->send();
    }

    /** set namespace
     * @param string $namespace
     */
    public static function setNameSpace($namespace)
    {
        return self::$namespace = $namespace;
    }

    

    /**
     * @param string $url
     * @return void
     */
    public function dispatch()
    {
        try {
            $response = $this->run();
        } catch (RouterException $e) {
            $response = new Response($e->getMessage(), 404);
        }
        if ($response instanceof Response) {
            $response->send();
        }
    }
}
