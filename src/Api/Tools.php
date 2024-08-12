<?php
/*
 * Tools.php
 * @author Martin Appelmann <hello@martin-appelmann.de>
 * @copyright 2024 Martin Appelmann
 */

namespace Exlo89\LaravelSevdeskApi\Api;

use Exlo89\LaravelSevdeskApi\Api\Utils\ApiClient;
use Exlo89\LaravelSevdeskApi\Api\Utils\Routes;
use Illuminate\Support\Collection;

/**
 * Sevdesk User Api
 */
class Tools extends ApiClient
{
    /**
     * Return all users.
     *
     * @return Collection
     */
    public function version()
    {
        return $this->_get(Routes::VERSION);
    }
}
