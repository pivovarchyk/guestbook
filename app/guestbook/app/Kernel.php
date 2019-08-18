<?php
declare(strict_types=1);

namespace Piv\Guestbook\App;

use Symfony\Component\HttpFoundation\{Request, Response};
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Routing\{Route, RouteCollection, RequestContext};
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Piv\Guestbook\App\Config\{Config, Router};
use Piv\Guestbook\App\Controllers\IndexController;

class Kernel implements HttpKernelInterface
{

    public function handle(Request $request, $type = HttpKernelInterface::MASTER_REQUEST, $catch = true): Response
    {
        //Config::checkIsDirToUploadedFiles();
        $router = new Router(Config::FILE_OF_ROUTES);

        try {
            $attributes = $router->getUrlParameters($request->getPathInfo());
            $controller = $attributes['controller'];
            $response = $controller($request);
        } catch(ResourceNotFoundException $e) {
            //$response = IndexController::show($request);
            $response = new Response('Not found!', Response::HTTP_NOT_FOUND);
        }

        return $response;
    }

}
