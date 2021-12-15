<?php
/*
 * SevdeskApi.php
 * @author Martin Appelmann <hello@martin-appelmann.de>
 * @copyright 2021 Martin Appelmann
 */

namespace Exlo89\LaravelSevdeskApi;


class SevdeskApi
{
    public static function make()
    {
        return new static();
    }


    public function __call($method, array $parameters)
    {
        return $this->getApiInstance($method);
    }

    protected function getApiInstance($method)
    {
        $class = "\\Exlo89\\LaravelSevdeskApi\\Api\\" . ucwords($method);

        if (class_exists($class)) {
            return new $class();
        }

        throw new \BadMethodCallException("Undefined method [{$method}] called.");
    }
}
