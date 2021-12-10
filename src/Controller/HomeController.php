<?php declare(strict_types=1);

namespace Mzb\Framework\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class HomeController
{
    public function index(): Response
    {
        return new Response('Hello world!');
    }
    

    public function about(): Response
    {
        return new Response('About page');
    }
}
