<?php
/**
 * @author: Vitaliy Ofat <ofatv22@gmail.com>
 */

namespace Ofat\SilexJWT;

use Ofat\SilexJWT\Exceptions\EmptySecretException;
use Ofat\SilexJWT\Exceptions\JWTException;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Silex\Api\BootableProviderInterface;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class JWTAuth
 * @package Ofat\SilexJWT
 */
class JWTAuth implements ServiceProviderInterface, BootableProviderInterface
{
    /**
     * @var Application\
     */
    protected $app;

    /**
     * @var Token
     */
    protected $token;

    /**
     * Token life time in seconds
     * @var int
     */
    protected $ttl = 3600;

    /**
     * @var Manager
     */
    protected $manager;

    /**
     * JWTAuth constructor.
     * @param Container $app
     * @throws EmptySecretException
     * @internal param Request $request
     */
    public function register(Container $app)
    {
    }

    public function boot(Application $app)
    {
        $this->app = $app;
        $jwtProvider = isset($app['jwt.provider']) ? $app['jwt.provider'] : new JWTAdapter();
        $secret = isset($app['jwt.secret']) ? $app['jwt.secret'] : '';

        if(!$secret)
            throw new EmptySecretException();

        $this->manager = new Manager($jwtProvider);
        $this->manager->setKey($secret);

        if (isset($app['jwt.ttl'])) {
            $this->ttl = (int)$app['jwt.ttl'];
        }

        $auth = $this;

        $app['jwt_auth'] = function() use ($auth) {
            return $auth;
        };
    }

    /**
     * @param string $header
     * @param string $method
     * @param string $query
     * @return JWTAuth
     * @throws JWTException
     */
    public function parseToken($header = 'authorization', $method = 'bearer', $query = 'token')
    {
        if(! $token = $this->parseAuthHeader($header, $method))
        {
            if (! $token = $this->app['request_stack']->getCurrentRequest()->get($query, false)) {
                throw new JWTException('The token could not be parsed from the request', 400);
            }
        }

        return $this->setToken($token);
    }

    /**
     * @param bool $token
     * @return bool
     */
    public function checkToken($token = false)
    {
        $this->requireToken($token);

        $this->manager->decode($this->token);

        return true;
    }

    /**
     * @param $subject
     * @param array $customClaims
     * @return mixed
     */
    public function generateToken($subject, array $customClaims = [])
    {
        $payload = new Payload($this->makePayload($subject, $customClaims));

        return $this->manager->encode($payload);
    }

    /**
     * @param $subject
     * @param array $customClaims
     * @return array
     */
    protected function makePayload($subject, array $customClaims = [])
    {
        return array_merge($customClaims, [
            'sub' => $subject,
            'iat' => time(),
            'exp' => time() + $this->ttl
        ]);
    }

    /**
     * @param bool $token
     * @return mixed
     */
    public function getPayload($token = false)
    {
        $this->requireToken($token);

        return $this->manager->decode($this->token);
    }

    /**
     * @param string $header
     * @param string $method
     * @return bool|string
     */
    protected function parseAuthHeader($header = 'authorization', $method = 'bearer')
    {
        $request = $this->app['request_stack']->getCurrentRequest();
        $header = $request->headers->get($header);

        if (strpos(strtolower($header), $method) !== 0) {
            return false;
        }

        return trim(str_ireplace($method, '', $header));
    }

    /**
     * @return Token|bool
     */
    public function getToken()
    {
        if (! $this->token) {
            try {
                $this->parseToken();
            } catch (JWTException $e) {
                return false;
            }
        }

        return $this->token;
    }

    /**
     * @param Token $token
     * @return $this
     */
    public function setToken($token)
    {
        $this->token = new Token($token);

        return $this;
    }

    protected function requireToken($token)
    {
        if (! $token = $token ?: $this->token) {
            throw new JWTException('A token is required', 400);
        }

        return $this->setToken($token);
    }
}
