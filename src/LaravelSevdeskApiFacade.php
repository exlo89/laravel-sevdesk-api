<?php

namespace Exlo89\LaravelSevdeskApi;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Exlo89\LaravelSevdeskApi\Skeleton\SkeletonClass
 */
class LaravelSevdeskApiFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-sevdesk-api';
    }
}
