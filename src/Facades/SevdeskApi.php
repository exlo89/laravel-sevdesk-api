<?php
/*
 * SevdeskApi.php
 * @author Martin Appelmann <hello@martin-appelmann.de>
 * @copyright 2021 Martin Appelmann
 */

namespace Exlo89\LaravelSevdeskApi\Facades;

use Illuminate\Support\Facades\Facade;

class SevdeskApi extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'sevdesk-api';
    }
}
