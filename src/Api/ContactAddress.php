<?php
/*
 * ContactAddress.php
 * @author Martin Appelmann <hello@martin-appelmann.de>
 * @copyright 2021 Martin Appelmann
 */

namespace Exlo89\LaravelSevdeskApi\Api;

use Illuminate\Support\Collection;
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
     * @return mixed
     */
    public function all(int $limit = 1000)
    {
        return Collection::make($this->_get(Routes::CONTACT_ADDRESS, ['limit' => $limit]));
    }

    /**
     * Find an addresses for the contact address id.
     *
     * @param int $contactAddressId
     * @return mixed
     */
    public function findFromAddressId(int $contactAddressId)
    {
        return Collection::make($this->_get(Routes::CONTACT_ADDRESS . '/' . $contactAddressId));
    }

    /**
     * Create contact address.
     *
     * @param int $contactId
     * @param array $parameters
     * @return mixed
     */
    public function create(int $contactId, array $parameters = [])
    {
        $parameters['contact'] = [
            "id" => $contactId,
            "objectName" => "Contact",
        ];
        return $this->_post(Routes::CONTACT_ADDRESS, $parameters);
    }
}
