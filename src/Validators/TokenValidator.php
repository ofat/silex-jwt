<?php
/**
 * @author: Vitaliy Ofat <ofatv22@gmail.com>
 */

namespace Ofat\SilexJWT\Validators;

use Ofat\SilexJWT\Exceptions\TokenInvalidException;

/**
 * Class TokenValidator
 * @package Ofat\SilexJWT\Validators
 */
class TokenValidator extends AbstractValidator
{
    /**
     * Check the structure of the token.
     *
     * @param string  $value
     * @return void
     */
    public function check($value)
    {
        $this->validateStructure($value);
    }

    /**
     * @param  string  $token
     * @throws TokenInvalidException
     * @return bool
     */
    protected function validateStructure($token)
    {
        if (count(explode('.', $token)) !== 3) {
            throw new TokenInvalidException('Wrong number of segments');
        }

        return true;
    }
}
