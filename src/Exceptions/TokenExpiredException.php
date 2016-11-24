<?php
/**
 * @author: Vitaliy Ofat <ofatv22@gmail.com>
 */

namespace Ofat\SilexJWT\Exceptions;

/**
 * Class TokenExpiredException
 * @package Ofat\SilexJWT\Exceptions
 */
class TokenExpiredException extends JWTException
{
    /**
     * @var int
     */
    protected $statusCode = 401;

}
