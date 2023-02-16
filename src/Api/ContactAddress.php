<?php
/*
 * ContactAddress.php
 * @author Martin Appelmann <hello@martin-appelmann.de>
 * @copyright 2021 Martin Appelmann
 */

namespace Exlo89\LaravelSevdeskApi\Api;

use Exlo89\LaravelSevdeskApi\Models\SevContactAddress;
use Illuminate\Support\Collection;
use Exlo89\LaravelSevdeskApi\Constants\Country;
use Exlo89\LaravelSevdeskApi\Api\Utils\ApiClient;
use Exlo89\LaravelSevdeskApi\Api\Utils\Routes;

/**
 * Sevdesk Contact Address Api
 *
 * @see https://api.sevdesk.de/#tag/ContactAddress
 */
class ContactAddress extends ApiClient
{

    /**
     * Return all contact addresses.
     *
     * @return Collection
     */
    public function all(int $limit = 1000): Collection
    {
        return Collection::make($this->_get(Routes::CONTACT_ADDRESS, ['limit' => $limit]));
    }

    /**
     * Find an addresses for the contact address id.
     *
     * @param int $contactAddressId
     * @return Collection
     */
    public function findFromAddressId(int $contactAddressId): Collection
    {
        return Collection::make($this->_get(Routes::CONTACT_ADDRESS . '/' . $contactAddressId));
    }

    /**
     * Create contact address.
     * Country is required. Germany is set as default.
     *
     * @param int $contactId
     * @param array $parameters
     * @return SevContactAddress
     * @see StaticCountry::all() to get id of your country as api request
     * @see Country to get id of your country as enum
     */
    public function create(int $contactId, array $parameters = []): SevContactAddress
    {
        $parameters['contact'] = [
            "id" => $contactId,
            "objectName" => "Contact",
        ];
        // on null add default value to country
        $parameters['country'] = $parameters['country'] ?? [
            "id" => Country::GERMANY,
            "objectName" => "StaticCountry",
        ];
        return SevContactAddress::make($this->_post(Routes::CONTACT_ADDRESS, $parameters));
    }
}
