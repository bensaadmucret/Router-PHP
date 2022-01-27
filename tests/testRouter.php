<?php
declare(strict_types=1);
namespace Mzb\Tests;

use Mzb\Router\Router;



use Mzb\Router\RouterException;
use PHPUnit\Framework\TestCase;
use Mzb\Router\Controller\AboutController;
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
        router::setNameSpace('Mzb\\Controller\\');
        $router->add('GET', '/about', 'AboutController@about', 'about');
       
        $request = Request::create('/about');
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('/about', $router->getRoute());
        $this->assertEquals($router->getRoute(), $request->getPathInfo());
    }

    public function testRouterWithParams()
    {
        $router = new Router();
        $response = new Response();
        router::setNameSpace('Mzb\\Controller\\');
        $router->add('GET', '/about/1', 'AboutController@about', 'about');
        $request = Request::create('/about/1');
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('/about/1', $router->getRoute());
        $this->assertEquals($router->getRoute(), $request->getPathInfo());
    }

    //test route not found
    public function testRouterNotFound()
    {
        $router = new Router();
        $response = new Response();
        router::setNameSpace('Mzb\\Controller\\');
        $router->add('GET', '/about/1', 'AboutController@about', 'about');
        $request = Request::create('/about/2');
        $response->setContent('No matching routes');
        $response->setStatusCode(Response::HTTP_NOT_FOUND);
        
        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
        $this->assertNotEquals('/about/2', $router->getRoute('AboutController@about'));
        $this->assertNotEquals($router->getRoute('AboutController@about'), $request->getPathInfo());
        $this->assertEquals('No matching routes', $response->getContent());
    }

    
   

    public function testGetNameSpace()
    {
        $router = new Router();
        $response = new Response();
        router::setNameSpace('Mzb\\Controller\\');
        $router->add('GET', '/about:1', 'AboutController@about', 'about');
        $request = Request::create('/about/1');
        $this->assertEquals('Mzb\\Controller\\', $router->getNameSpace());
    }

    public function testGetName()
    {
        $router = new Router();
        $response = new Response();
        router::setNameSpace('Mzb\\Controller\\');
        $router->add('GET', '/about/1', 'AboutController@about', 'about');
        $request = Request::create('/about/1');
        $this->assertEquals('about', $router->getName());
    }

    
    public function testGetMethod()
    {
        $router = new Router();
        $response = new Response();
        router::setNameSpace('Mzb\\Controller\\');
        $router->add('GET', '/about/1', 'AboutController@about', 'about');
        $request = Request::create('/about/1');
        $this->assertEquals('GET', $router->getMethod());
    }

    public function testPut()
    {
        $router = new Router();
        $response = new Response();
        router::setNameSpace('Mzb\\Controller\\');
        $router->add('PUT', '/about/1', 'AboutController@about', 'about');
        $request = Request::create('/about/1');
        $this->assertEquals('PUT', $router->getMethod());
    }

    public function testGet()
    {
        $router = new Router();
        $response = new Response();
        router::setNameSpace('Mzb\\Controller\\');
        $router->add('GET', '/about/1', 'AboutController@about', 'about');
        $request = Request::create('/about/1');
        $this->assertEquals('GET', $router->getMethod());
    }

    public function testPost()
    {
        $router = new Router();
        router::setNameSpace('Mzb\\Controller\\');
        $router->add('POST', '/about/1', 'AboutController@about', 'about');
        $request = Request::create(
            '/about/1',
            'POST',
            ['name' => 'Fabien']
        );
        $this->assertEquals('POST', $router->getMethod());
        $this->assertEquals('Fabien', $request->request->get('name'));
    }

    public function testRedirect()
    {
        $router = new Router();
        router::setNameSpace('Mzb\\Controller\\');
        $router->add('GET', '/', 'HomeController@index', 'home');
        $request = Request::create('/about/1');
        $router->redirect('home', 301);
        $this->assertEquals('/', $router->getRouteByName('home'));
    }

    public function testDelete()
    {
        $router = new Router();
        router::setNameSpace('Mzb\\Controller\\');
        $router->add('DELETE', '/about/1', 'AboutController@about', 'about');
        $request = Request::create('/about/1');
        $this->assertEquals('DELETE', $router->getMethod());
    }

    public function testPatch()
    {
        $router = new Router();
        router::setNameSpace('Mzb\\Controller\\');
        $router->add('PATCH', '/about/1', 'AboutController@about', 'about');
        $request = Request::create('/about/1');
        $this->assertEquals('PATCH', $router->getMethod());
    }

    public function testOptions()
    {
        $router = new Router();
        router::setNameSpace('Mzb\\Controller\\');
        $router->add('OPTIONS', '/about/1', 'AboutController@about', 'about');
        $request = Request::create('/about/1');
        $this->assertEquals('OPTIONS', $router->getMethod());
    }

    public function testHead()
    {
        $router = new Router();
        router::setNameSpace('Mzb\\Controller\\');
        $router->add('HEAD', '/about/1', 'AboutController@about', 'about');
        $request = Request::create('/about/1');
        $this->assertEquals('HEAD', $router->getMethod());
    }

    public function testGetRouteByName()
    {
        $router = new Router();
        router::setNameSpace('Mzb\\Controller\\');
        $router->add('GET', '/about/1', 'AboutController@about', 'about');
        $request = Request::create('/about/1');
        $this->assertEquals('/about/1', $router->getRouteByName('about'));
    }


    public function testGetRouteByNameWithParameters()
    {
        $router = new Router();
        router::setNameSpace('Mzb\\Controller\\');
        $router->add('GET', '/about/1', 'AboutController@about', 'about');
        $request = Request::create('/about/1');
        $this->assertEquals('/about/1', $router->getRouteByName('about'));
    }

   

    
    public function testRun()
    {
        $router = new Router();
        
        router::setNameSpace('Mzb\\Controller\\');
        $router->add('GET', '/about/1', 'AboutController@about', 'about');
        $request = Request::create('/about/1');
        $response = new Response(
            '<h1>About</h1>',
            Response::HTTP_OK,
            ['content-type' => 'text/html']
        );
        $this->assertEquals($response->getContent(), '<h1>About</h1>');
    }

    public function testRunWithException()
    {
        $router = new Router();
        $response = new Response();
        router::setNameSpace('Mzb\\Controller\\');
        $router->add('GET', '/about/1', 'AboutController@about', 'about');
        $request = Request::create('/about/notfound');
        $this->expectExceptionMessage('not found');
        $router->run();
    }
}
