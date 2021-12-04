<?php

/*
 * Contact.php
 * @author Martin Appelmann <hello@martin-appelmann.de>
 * @copyright 2021 Martin Appelmann
 */

namespace Exlo89\LaravelSevdeskApi\Api;

use Exlo89\LaravelSevdeskApi\Api\Utils\ApiClient;
use Exlo89\LaravelSevdeskApi\Api\Utils\Routes;

class Contact extends ApiClient
{
    public function all()
    {
        return $this->_get(Routes::CONTACT);
    }

    public function get($contactId)
    {
        return $this->_get(Routes::CONTACT . '/' . $contactId);
    }
}
