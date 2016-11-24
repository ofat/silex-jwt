<?php
/**
 * @author: Vitaliy Ofat <ofatv22@gmail.com>
 */

namespace Ofat\SilexJWT;

use Firebase\JWT\JWT;

/**
 * Class JWTAdapter
 * @package Ofat\SilexJWT
 */
class JWTAdapter implements JWTInterface
{
    /**
     * @param $payload
     * @param $key
     * @param string $alg
     * @return string
     */
    public function encode($payload, $key, $alg = 'HS256')
    {
        return JWT::encode($payload, $key, $alg);
    }

    /**
     * @param $jwt
     * @param $key
     * @return object
     */
    public function decode($jwt, $key)
    {
        return JWT::decode($jwt, $key);
    }
}