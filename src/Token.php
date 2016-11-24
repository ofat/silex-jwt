<?php
/**
 * @author: Vitaliy Ofat <ofatv22@gmail.com>
 */

namespace Ofat\SilexJWT;

use Ofat\SilexJWT\Validators\TokenValidator;

class Token
{
    /**
     * @var string
     */
    protected $value;

    /**
     * @var Payload
     */
    protected $payload;

    public function __construct($value)
    {
        (new TokenValidator)->check($value);

        $this->value = $value;
    }

    public function __toString()
    {
        return (string) $this->value;
    }

    /**
     * @return Payload
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
}