<?php

declare(strict_types=1);

namespace Guestbook\App;

use Psr\Http\Message\{ResponseInterface, ServerRequestInterface};
use Psr\Http\Server\RequestHandlerInterface;
use Guestbook\App\Controllers\IndexController;
use Guestbook\App\Http\Response;

class AppKernel implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $init = new IndexController();
        $content = $init->show($request);
        $response = new Response ($content['content'], $content['params']);
        return $response;
    }
}