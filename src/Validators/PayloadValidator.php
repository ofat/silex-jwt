<?php
/**
 * @author: Vitaliy Ofat <ofatv22@gmail.com>
 */

namespace Ofat\SilexJWT\Validators;

use Ofat\SilexJWT\Exceptions\TokenExpiredException;
use Ofat\SilexJWT\Exceptions\TokenInvalidException;

/**
 * Class PayloadValidator
 * @package Ofat\SilexJWT\Validators
 */
class PayloadValidator extends AbstractValidator
{
    /**
     * @var array
     */
    protected $requiredClaims = array('iat', 'exp', 'sub');

    /**
     * Run the validations on the payload array.
     *
     * @param  array  $value
     * @return void
     */
    public function check($value)
    {
        $this->validateStructure($value);

        $this->validateTimestamps($value);
    }

    /**
     * Ensure the payload contains the required claims and
     * the claims have the relevant type.
     *
     * @param array  $payload
     * @throws TokenInvalidException
     * @return bool
     */
    protected function validateStructure(array $payload)
    {
        if (count(array_diff_key($this->requiredClaims, array_keys($payload))) !== 0) {
            throw new TokenInvalidException('JWT payload does not contain the required claims');
        }

        return true;
    }

    /**
     * Validate the payload timestamps.
     *
     * @param  array  $payload
     * @throws TokenExpiredException
     * @throws TokenInvalidException
     * @return bool
     */
    protected function validateTimestamps(array $payload)
    {
        if (isset($payload['iat']) && $payload['iat'] > time()) {
            throw new TokenInvalidException('Issued At (iat) timestamp cannot be in the future', 400);
        }

        if ($payload['exp'] < time()) {
            throw new TokenExpiredException('Token has expired');
        }

        return true;
    }
}
