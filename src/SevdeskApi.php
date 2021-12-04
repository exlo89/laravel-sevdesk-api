<?php
/*
 * SevdeskApi.php
 * @author Martin Appelmann <hello@martin-appelmann.de>
 * @copyright 2021 Martin Appelmann
 */

namespace Exlo89\LaravelSevdeskApi;

class SevdeskApi extends HttpClient
{
    public static function make()
    {
        return new static();
    }

    public function getContacts()
    {
        return $this->_get('contact');
    }
}
