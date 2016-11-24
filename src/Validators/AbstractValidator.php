<?php
/**
 * @author: Vitaliy Ofat <ofatv22@gmail.com>
 */

namespace Ofat\SilexJWT\Validators;

use Ofat\SilexJWT\Exceptions\JWTException;

/**
 * Class AbstractValidator
 * @package Ofat\SilexJWT\Validators
 */
abstract class AbstractValidator implements ValidatorInterface
{
    /**
     * Helper function to return a boolean.
     *
     * @param  array  $value
     * @return bool
     */
    public function isValid($value)
    {
        try {
            $this->check($value);
        } catch (JWTException $e) {
            return false;
        }

        return true;
    }
}
