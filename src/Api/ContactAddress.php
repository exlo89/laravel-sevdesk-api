<?php
/*
 * ContactAddress.php
 * @author Martin Appelmann <hello@martin-appelmann.de>
 * @copyright 2021 Martin Appelmann
 */

namespace Exlo89\LaravelSevdeskApi\Api;

use Exlo89\LaravelSevdeskApi\Api\Utils\ApiClient;
use Exlo89\LaravelSevdeskApi\Api\Utils\Routes;

class ContactAddress extends ApiClient
{
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
