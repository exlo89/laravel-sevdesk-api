<?php
/*
 * StaticCountry.php
 * @author Eric Bortz <eric.bortz124@gmail.com>
 * @copyright 2023 Eric Bortz
 */

namespace Exlo89\LaravelSevdeskApi\Api;

use Exlo89\LaravelSevdeskApi\Api\Utils\ApiClient;
use Exlo89\LaravelSevdeskApi\Api\Utils\Routes;
use Illuminate\Support\Collection;

/**
 * Sevdesk Contact Api
 *
 * @see https://api.sevdesk.de/#tag/Contact
 */
class StaticCountry extends ApiClient
{
    // =========================== all ====================================

    /**
     * Return all countries.
     *
     * @return mixed
     */
    public function all()
    {
        return Collection::make($this->_get(Routes::STATIC_COUNTRY));
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
