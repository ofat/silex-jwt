<?php
/**
 * @author: Vitaliy Ofat <ofatv22@gmail.com>
 */

namespace Ofat\SilexJWT\Exceptions;

/**
 * Class TokenInvalidException
 * @package Ofat\SilexJWT\Exceptions
 */
class TokenInvalidException extends JWTException
{
    /**
     * @var int
     */
    protected $statusCode = 400;

}
