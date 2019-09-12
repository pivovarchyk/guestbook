<?php
declare(strict_types=1);

namespace Piv\Guestbook\Src;

use Symfony\Component\Asset\VersionStrategy\JsonManifestVersionStrategy;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\WebpackEncoreBundle\WebpackEncoreBundle;
use Piv\Guestbook\Config\Config;
use Piv\Guestbook\Src\Controllers\UserController;
use Piv\Guestbook\Src\Routing\Router;

class Kernel implements HttpKernelInterface
{
    /**
     * @param Request $request
     * @param int $type
     * @param bool $catch
     * @return Response
     */
    public function handle(
        Request $request,
        $type = HttpKernelInterface::MASTER_REQUEST,
        $catch = true
    ): Response {
        //Config::checkIsDirToUploadedFiles();
        $router = new Router(Config::FILE_OF_ROUTES);
        try {
            $attributes = $router->getUrlParameters($request->getPathInfo());
            $controller = empty($attributes) ? '' : $attributes['controller'];
            if (isset($attributes['sortflag']) && isset($attributes['count'])) {
                $response = $controller($request, $attributes['sortflag'], $attributes['count']);
            } else {
                $response = $controller($request);
            }
        } catch (ResourceNotFoundException $e) {
            $response = new Response('Not found!', Response::HTTP_NOT_FOUND);
        }

        return $response;
    }
}
