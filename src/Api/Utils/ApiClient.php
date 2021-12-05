<?php
/*
 * ApiClient.php
 * @author Martin Appelmann <hello@martin-appelmann.de>
 * @copyright 2021 Martin Appelmann
 */

namespace Exlo89\LaravelSevdeskApi\Api\Utils;

use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Client;

class ApiClient
{
    private $client;

    private function getClient(): Client
    {
        if (!$this->client) {
            $this->client = new Client([
                'base_uri' => $this->baseUrl(),
            ]);
        }
        return $this->client;
    }

    private function getToken(): string
    {
        return config('sevdesk-api.api_token');
    }

    private function baseUrl()
    {
        return 'https://my.sevdesk.de';
    }

    public function execute($httpMethod, $url, array $parameters = [])
    {
        try {
            $parameters['token'] = $this->getToken();
            $response = $this->getClient()->{$httpMethod}('api/v1/' . $url, ['query' => $parameters]);
            $responseBody = json_decode((string)$response->getBody(), true);
            return $responseBody['objects'];
        } catch (BadResponseException $exception) {
            $response = $exception->getResponse();
            return json_decode((string)$response->getBody(), true);
        }

    }

    // ========================= base methods ======================================

    public function _get($url = null, $parameters = [])
    {
        return $this->execute('get', $url, $parameters);
    }

    public function _post($url = null, array $parameters = [])
    {
        return $this->execute('post', $url, $parameters);
    }

    public function _put($url = null, array $parameters = [])
    {
        return $this->execute('put', $url, $parameters);
    }

    public function _patch($url = null, array $parameters = [])
    {
        return $this->execute('patch', $url, $parameters);
    }

    public function _delete($url = null, array $parameters = [])
    {
        return $this->execute('delete', $url, $parameters);
    }
}
