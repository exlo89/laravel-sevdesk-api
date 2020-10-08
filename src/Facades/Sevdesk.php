<?php


namespace Exlo\LaravelSevdeskApi\Facades;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Facade;
use Exlo\LaravelSevdeskApi\HttpClient;

class Sevdesk extends HttpClient
{
    public function getContacts(){
        return $this->_get('contact');
    }
}
