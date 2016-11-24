<?php
/**
 * @author: Vitaliy Ofat <ofatv22@gmail.com>
 */

namespace Ofat\SilexJWT;

/**
 * Interface JWTInterface
 * @package Ofat\SilexJWT
 */
interface JWTInterface
{
    /**
     * @param $payload
     * @param $key
     * @param string $alg
     * @return mixed
     */
    public function encode($payload, $key, $alg = 'HS256');

    /**
     * @param $jwt
     * @param $key
     * @return mixed
     */
    public function decode($jwt, $key);

}