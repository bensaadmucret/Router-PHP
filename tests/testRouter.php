<?php
declare(strict_types=1);
namespace Mzb\Framework\Tests\Router;

use DeepCopy\Filter\SetNullFilter;
use PHPUnit\Framework\TestCase;
use Mzb\Framework\Router\Router;
use Mzb\Framework\Controller\AboutController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class StackTest extends TestCase
{
    public function testRouterInstance()
    {
        $router = new Router();
        $this->assertInstanceOf(Router::class, $router);
    }
    public function testRouterBasic()
    {
        $router = new Router();
        $response = new Response();
        router::setNameSpace('Mzb\\Framework\\Controller\\');
        $router->add('GET', '/about', 'AboutController@about', 'about');
       
        $request = Request::create('/about');
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('/about', $router->getRoute('AboutController@about'));
        $this->assertEquals($router->getRoute('AboutController@about'), $request->getPathInfo());
    }

    public function testRouterWithParams()
    {
        $router = new Router();
        $response = new Response();
        router::setNameSpace('Mzb\\Framework\\Controller\\');
        $router->add('GET', '/about/1', 'AboutController@about', 'about');
        $request = Request::create('/about/1');
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('/about/1', $router->getRoute('AboutController@about'));
        $this->assertEquals($router->getRoute('AboutController@about'), $request->getPathInfo());
    }

    //test route not found
    public function testRouterNotFound()
    {
        $router = new Router();
        $response = new Response();
        router::setNameSpace('Mzb\\Framework\\Controller\\');
        $router->add('GET', '/about/1', 'AboutController@about', 'about');
        $request = Request::create('/about/2');
        $response->setContent('No matching routes');
        $response->setStatusCode(Response::HTTP_NOT_FOUND);

        
        
        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
        $this->assertNotEquals('/about/2', $router->getRoute('AboutController@about'));
        $this->assertNotEquals($router->getRoute('AboutController@about'), $request->getPathInfo());
        $this->assertEquals('No matching routes', $response->getContent());
    }


    
}
