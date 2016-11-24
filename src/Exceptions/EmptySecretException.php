<?php
/**
 * @author: Vitaliy Ofat <ofatv22@gmail.com>
 */

namespace Ofat\SilexJWT\Exceptions;

/**
 * Class EmptySecretException
 * @package Ofat\SilexJWT\Exceptions
 */
class EmptySecretException extends \Exception
{
    /**
     * @var int
     */
    protected $statusCode = 500;

    /**
     * @param string  $message
     * @param int $statusCode
     */
    public function __construct($message = 'You should fill secret key for JWT', $statusCode = null)
    {
        parent::__construct($message);

        if (! is_null($statusCode)) {
            $this->setStatusCode($statusCode);
        }
    }

    /**
     * @param int $statusCode
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
    }

    /**
     * @return int the status code
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }
}