<?php
/**
 * @author: Vitaliy Ofat <ofatv22@gmail.com>
 */

namespace Ofat\SilexJWT;

/**
 * Class Manager
 * @package Ofat\SilexJWT
 */
class Manager
{
    /**
     * @var JWTInterface
     */
    protected $jwtProvider;

    /**
     * @var string
     */
    protected $key;

    /**
     * Manager constructor.
     * @param JWTInterface $jwt
     */
    public function __construct(JWTInterface $jwt)
    {
        $this->jwtProvider = $jwt;
    }

    /**
     * @param array|Payload $payload
     * @return mixed
     */
    public function encode(Payload $payload)
    {
        $token = $this->jwtProvider->encode($payload->get(), $this->key);

        return $token;
    }

    /**
     * @param Token $token
     * @return mixed
     */
    public function decode(Token $token)
    {
        $payloadArray = (array) $this->jwtProvider->decode($token, $this->key);

        $payload = new Payload($payloadArray);

        return $payload;
    }

    /**
     * @param string $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }
}