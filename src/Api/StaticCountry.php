<?php
/*
 * StaticCountry.php
 * @author Martin Appelmann <hello@martin-appelmann.de>
 * @copyright 2021 Martin Appelmann/
 */

namespace Exlo89\LaravelSevdeskApi\Api;

use Exlo89\LaravelSevdeskApi\Api\Utils\ApiClient;
use Exlo89\LaravelSevdeskApi\Api\Utils\Routes;
use Illuminate\Support\Collection;

/**
 * Sevdesk Contact Api
 *
 * @see https://api.sevdesk.de/#section/How-to-filter-for-certain-contacts
 */
class StaticCountry extends ApiClient
{
    // =========================== all ====================================

    /**
     * Return all countries.
     *
     * @return mixed
     */
    public function all(int $limit = 1000)
    {
        return Collection::make($this->_get(Routes::STATIC_COUNTRY, ['limit' => $limit]));
    }

    // =========================== get ====================================

    /**
     * Return a single country.
     *
     * @param $contryId
     * @return mixed
     */
    public function get($countryId)
    {
        return $this->_get(Routes::STATIC_COUNTRY . '/' . $countryId)[0];
    }
}
