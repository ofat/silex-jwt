<?php
/**
 * @author: Vitaliy Ofat <ofatv22@gmail.com>
 */

namespace Ofat\SilexJWT\Validators;

/**
 * Interface ValidatorInterface
 * @package Ofat\SilexJWT\Validators
 */
interface ValidatorInterface
{
    /**
     * Perform some checks on the value.
     *
     * @param  mixed  $value
     * @return void
     */
    public function check($value);

    /**
     * Helper function to return a boolean.
     *
     * @param  array  $value
     * @return bool
     */
    public function isValid($value);
}
