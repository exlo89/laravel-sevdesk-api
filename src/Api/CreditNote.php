<?php
/*
 * CreditNote.php
 * @author Martin Appelmann <hello@martin-appelmann.de>
 * @copyright 2022 Martin Appelmann
 */

namespace Exlo89\LaravelSevdeskApi\Api;

use Carbon\Carbon;
use Exlo89\LaravelSevdeskApi\Api\Utils\ApiClient;
use Exlo89\LaravelSevdeskApi\Api\Utils\Routes;

/**
 * Sevdesk Credit Note Api
 *
 * @see https://api.sevdesk.de/#tag/CreditNote
 */
class CreditNote extends ApiClient
{
    /**
     * Create credit note.
     *
     * @param array $parameters
     * @return mixed
     */
    public function create(array $parameters = [])
    {
        return $this->_post(Routes::CREDIT_NOTE . '/Factory/saveCreditNote', $parameters);
    }

    /**
     * Download PDF credit note.
     *
     * @param array $parameters
     * @return mixed
     */
    public function download(int $id, array $parameters = [])
    {

        $response = $this->_get(Routes::CREDIT_NOTE . '/'.$id.'/getPdf');

        $file = $response['filename'];
        file_put_contents($file, base64_decode($response['content']));

        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($file) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            readfile($file);
            exit();
        }
    }
}
