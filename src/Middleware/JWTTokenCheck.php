<?php
/**
 * @author: Vitaliy Ofat <ofatv22@gmail.com>
 */

namespace Ofat\SilexJWT\Middleware;

use Silex\Application;

/**
 * Class JWTTokenCheck
 * @package Ofat\SilexJWT\Middleware
 */
class JWTTokenCheck
{
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param Application $app
     * @return null
     */
    public function __invoke(\Symfony\Component\HttpFoundation\Request $request, Application $app)
    {
        $app['jwt_auth']->parseToken();
        $app['jwt_auth']->checkToken();

        return null;
    }
}