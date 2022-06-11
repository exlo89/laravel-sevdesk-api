<?php
/*
 * Invoice.php
 * @author Martin Appelmann <hello@martin-appelmann.de>
 * @copyright 2022 Martin Appelmann
 */

namespace Exlo89\LaravelSevdeskApi\Api;

use Exlo89\LaravelSevdeskApi\Api\Utils\ApiClient;
use Exlo89\LaravelSevdeskApi\Api\Utils\Routes;

/**
 * Sevdesk Invoice Api
 *
 * @see https://api.sevdesk.de/#tag/Invoice
 */
class Invoice extends ApiClient
{
    /**
     * Invoice status
     */
    const DEACTIVATED_RECURRING = 50;
    const DRAFT = 100;
    const OPEN = 200;
    const PAYED = 1000;

    // =========================== all ====================================

    /**
     * Return all invoices.
     *
     * @return mixed
     */
    public function all()
    {
        return $this->_get(Routes::INVOICE);
    }

    /**
     * Return all draft invoices.
     *
     * @return mixed
     */
    public function allDraft()
    {
        return $this->_get(Routes::INVOICE, ['status' => self::DRAFT]);
    }

    /**
     * Return all open invoices.
     *
     * @return mixed
     */
    public function allOpen()
    {
        return $this->_get(Routes::INVOICE, ['status' => self::OPEN]);
    }

    /**
     * Return all payed invoices.
     *
     * @return mixed
     */
    public function allPayed()
    {
        return $this->_get(Routes::INVOICE, ['status' => self::PAYED]);
    }

    /**
     * Return all invoices filtered by contact id.
     *
     * @return mixed
     */
    public function allByContact($contactId)
    {
        return $this->_get(Routes::INVOICE, [
            'contact' => [
                'id' => $contactId,
                'objectName' => 'Contact'
            ],
        ]);
    }

    /**
     * Return all invoices filtered by a date equal or lower.
     *
     * @return mixed
     */
    public function allBefore(int $timestamp)
    {
        return $this->_get(Routes::INVOICE, ['endDate' => $timestamp]);
    }

    /**
     * Return all invoices filtered by a date equal or higher.
     *
     * @return mixed
     */
    public function allAfter(int $timestamp)
    {
        return $this->_get(Routes::INVOICE, ['startDate' => $timestamp]);
    }

    // =========================== create ====================================

    /**
     * Create invoice.
     *
     * @return mixed
     */
    public function create($contactId, array $parameters = [])
    {
        $requiredParameters = [
            'invoice' => [
                'objectName' => 'Invoice',
                'contact' => [
                    'id' => $contactId,
                    'objectName' => 'Contact'
                ],
                'invoiceDate' => date('Y-m-d H:i:s'),
                'discount' => 0,
                'addressCountry' => [
                    'id' => 1,
                    'objectName' => 'StaticCountry'
                ],
                'status' => self::DRAFT,
                'contactPerson' => [
                    'id' => config('sevdesk-api.sev_user_id'),
                    'objectName' => 'SevUser'
                ],
                'taxRate' => config('sevdesk-api.tax_rate'),
                'taxText' => config('sevdesk-api.tax_text'),
                'taxType' => config('sevdesk-api.tax_type'),
                'invoiceType' => config('sevdesk-api.invoice_type'),
                'currency' => config('sevdesk-api.currency'),
                'mapAll' => 'true'
            ],
            'invoicePosSave' => [
                'objectName' => 'InvoicePos',
                'quantity' => 1,
                'unity' => [
                    'id' => 1,
                    'objectName' => 'Unity',
                ]
            ]
        ];
        $allParameters = array_replace_recursive($requiredParameters, $parameters);
        return $this->_post(Routes::CREATE_INVOICE, $allParameters);
    }

    // =======================================================================

    /**
     * Returns pdf file of the giving invoice id.
     *
     * @return void
     */
    public function download($invoiceId)
    {
        $response = $this->_get(Routes::INVOICE . '/' . $invoiceId . '/getPdf');
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

    /**
     * Send invoice per email.
     *
     * @return void
     */
    public function sendPerMail($invoiceId, $email, $subject, $text)
    {
        return $this->_post(Routes::INVOICE . '/' . $invoiceId . '/sendViaEmail', [
            'toEmail' => $email,
            'subject' => $subject,
            'text' => $text,
        ]);
    }
}
