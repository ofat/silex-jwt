<?php
/**
 * @author: Vitaliy Ofat <ofatv22@gmail.com>
 */

namespace Ofat\SilexJWT;

use Ofat\SilexJWT\Validators\PayloadValidator;

class Payload implements \ArrayAccess
{
    /**
     * The array of claims.
     *
     * @var array
     */
    private $claims = [];

    /**
     * Build the Payload.
     *
     * @param array  $claims
     */
    public function __construct(array $claims)
    {
        $this->claims = $claims;

        (new PayloadValidator)->check($this->claims);
    }

    /**
     * Get the payload.
     *
     * @param  string  $claim
     * @return mixed
     */
    public function get($claim = null)
    {
        if (! is_null($claim)) {
            return isset($this->claims[$claim]) ? $this->claims[$claim] : false;
        }

        return $this->claims;
    }

    /**
     * Get the payload as a string.
     *
     * @return string
     */
    public function __toString()
    {
        return json_encode($this->claims);
    }

    /**
     * Determine if an item exists at an offset.
     *
     * @param  mixed  $key
     * @return bool
     */
    public function offsetExists($key)
    {
        return array_key_exists($key, $this->claims);
    }

    /**
     * Get an item at a given offset.
     *
     * @param  mixed  $key
     * @return mixed
     */
    public function offsetGet($key)
    {
        return isset($this->claims[$key]) ? $this->claims[$key] : false;
    }

    /**
     * Don't allow changing the payload as it should be immutable.
     *
     * @param  mixed $key
     * @param  mixed $value
     * @throws \Exception
     */
    public function offsetSet($key, $value)
    {
        throw new \Exception('The payload is immutable');
    }

    /**
     * Don't allow changing the payload as it should be immutable.
     *
     * @param  string $key
     * @throws \Exception
     */
    public function offsetUnset($key)
    {
        throw new \Exception('The payload is immutable');
    }
}
