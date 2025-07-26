<?php
/*
 * ApiClient.php
 * @author Martin Appelmann <hello@martin-appelmann.de>
 * @copyright 2021 Martin Appelmann
 */

namespace Exlo89\LaravelSevdeskApi\Api\Utils;

use Exlo89\LaravelSevdeskApi\Models\SevSequence;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
            $headers = [
                'Authorization' => $this->getToken(),
                'Accept'        => 'application/json'
            ];

            $response = $this->getClient()->{$httpMethod}('api/v1/' . $url, [
                'headers' => $headers,
                'json'    => $parameters
            ]);
            $responseBody = json_decode((string)$response->getBody(), true);
            return $responseBody['objects'];
        } catch (BadResponseException $exception) {
            $response = json_decode((string)$exception->getResponse()->getBody(), true);
            if (array_key_exists('error', $response)) {
                if ($response['error']['code'] == 151) {
                    throw new ModelNotFoundException($response['error']['message']);
                }
                if ($response['error']['message'] != null) throw new \Exception($response['error']['message']);
            }
            if (array_key_exists('status', $response)) {
                if ($response['status'] == 401) throw new UnauthorizedException($response['message']);
            }
            throw new \Exception('Something went wrong.');
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

    // =========================== helper ===========================================

    const INVOICE = 'Invoice';
    const CREDIT_NOTE = 'CreditNote';

    /**
     * Return the next sequence for the given object type.
     *
     * @param string $objectType
     * @return SevSequence
     */
    protected function getNextSequence(string $objectType = self::INVOICE): SevSequence
    {
        $sequence = $this->_get(Routes::SEQUENCE, ['objectType' => $objectType]);
        return SevSequence::make($sequence);
    }


    /**
     * Get the pdf file from the given path.
     *
     * @param string $path
     */
    protected function getPdf(string $path)
    {
        $response = $this->_get($path);
        $content = base64_decode($response['content']);
        $filename = $response['filename'];

        header('Content-Description: File Transfer');
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . strlen($content));

        echo $content;
        exit();
    }
}
