<?php
/*
 * Invoice.php
 * @author Martin Appelmann <hello@martin-appelmann.de>
 * @copyright 2022 Martin Appelmann
 */

namespace Exlo89\LaravelSevdeskApi\Api;

use Exception;
use Exlo89\LaravelSevdeskApi\Constants\Country;
use Exlo89\LaravelSevdeskApi\Models\SevInvoice;
use Illuminate\Support\Collection;
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
     * @return Collection
     */
    public function all(): Collection
    {
        return Collection::make($this->_get(Routes::INVOICE));
    }

    /**
     * Return all draft invoices.
     *
     * @return Collection
     */
    public function allDraft(): Collection
    {
        return Collection::make($this->_get(Routes::INVOICE, ['status' => self::DRAFT]));
    }

    /**
     * Return all open invoices.
     *
     * @return Collection
     */
    public function allOpen(): Collection
    {
        return Collection::make($this->_get(Routes::INVOICE, ['status' => self::OPEN]));
    }

    /**
     * Return all payed invoices.
     *
     * @return Collection
     */
    public function allPayed(): Collection
    {
        return Collection::make($this->_get(Routes::INVOICE, ['status' => self::PAYED]));
    }

    /**
     * Return all invoices filtered by contact id.
     *
     * @param $contactId
     * @return Collection
     */
    public function allByContact($contactId): Collection
    {
        return Collection::make($this->_get(Routes::INVOICE, [
            'contact' => [
                'id'         => $contactId,
                'objectName' => 'Contact'
            ],
        ]));
    }

    /**
     * Return all invoices filtered by a date equal or lower.
     *
     * @param int $timestamp
     * @return Collection
     */
    public function allBefore(int $timestamp): Collection
    {
        return Collection::make($this->_get(Routes::INVOICE, ['endDate' => $timestamp]));
    }

    /**
     * Return all invoices filtered by a date equal or higher.
     *
     * @param int $timestamp
     * @return Collection
     */
    public function allAfter(int $timestamp): Collection
    {
        return Collection::make($this->_get(Routes::INVOICE, ['startDate' => $timestamp]));
    }

    // =========================== create ====================================

    /**
     * Create invoice.
     *
     * @param $contactId
     * @param array $items
     * @param array $parameters
     * @return SevInvoice
     * @throws Exception
     */
    public function create($contactId, $items, array $parameters = []): SevInvoice
    {
        $response = $this->_post(Routes::CREATE_INVOICE, $this->getParameters($contactId, $items, $parameters));
        return SevInvoice::make($response['invoice']);
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
    public function sendByMail($invoiceId, $email, $subject, $text)
    {
        return $this->_post(Routes::INVOICE . '/' . $invoiceId . '/sendViaEmail', [
            'toEmail' => $email,
            'subject' => $subject,
            'text'    => $text,
        ]);
    }

    // ========================= helper ==========================

    /**
     * Validate and return config values.
     *
     * @return array
     * @throws Exception
     */
    private function getConfigs(): array
    {
        $values = [];
        $values['taxRate'] = config('sevdesk-api.tax_rate');
        if (empty($values['taxRate'])) {
            throw new Exception('Configuration parameter not found: tax_rate');
        }

        $values['taxText'] = config('sevdesk-api.tax_text');
        if (empty($values['taxText'])) {
            throw new Exception('Configuration parameter not found: tax_text');
        }

        $values['taxType'] = config('sevdesk-api.tax_type');
        if (empty($values['taxType'])) {
            throw new Exception('Configuration parameter not found: tax_type');
        }

        $values['invoiceType'] = config('sevdesk-api.invoice_type');
        if (empty($values['invoiceType'])) {
            throw new Exception('Configuration parameter not found: invoice_type');
        }

        $values['currency'] = config('sevdesk-api.currency');
        if (empty($values['currency'])) {
            throw new Exception('Configuration parameter not found: currency');
        }

        $values['sevUserId'] = config('sevdesk-api.sev_user_id');
        if (empty($values['sevUserId'])) {
            throw new Exception('Configuration parameter not found: sev_user_id');
        }
        return $values;
    }

    /**
     * Format items
     *
     * @param $items
     * @param $configs
     * @return array
     * @throws Exception
     */
    private function getInvoiceItems($items, $configs): array
    {
        $invoiceItems = [];
        if (empty($items)) {
            throw new Exception('No invoice items found');
        }
        foreach ($items as $item) {
            if (array_key_exists('name', $item) && array_key_exists('price', $item)) {
                $invoiceItems[] = [
                    'objectName'     => 'InvoicePos',
                    'mapAll'         => 'true',
                    'quantity'       => $item['quantity'] ?? 1,
                    'price'          => $item['price'],
                    'name'           => $item['name'],
                    'positionNumber' => $item['positionNumber'] ?? null,
                    'text'           => $item['text'] ?? '',
                    'discount'       => $item['discount'] ?? null,
                    'taxRate'        => $configs['taxRate'],
                    'unity'          => [
                        'id'         => 1,
                        'objectName' => 'Unity',
                    ],
                    'priceGross'     => $item['priceGross'] ?? null,
                    'priceTax'       => $item['priceTax'] ?? null

                ];
            }
        }
        return $invoiceItems;
    }

    /**
     * @param $contactId
     * @param $items
     * @param $parameters
     * @return array
     * @throws Exception
     */
    private function getParameters($contactId, $items, $parameters): array
    {
        // validate config values
        $configs = $this->getConfigs();
        // fetch and format next invoice number
        $nextSequence = $this->getNextSequence();
        $requiredParameters = [
            'invoice'        => [
                'objectName'     => 'Invoice',
                'contact'        => [
                    'id'         => $contactId,
                    'objectName' => 'Contact'
                ],
                'header'         => 'Rechnung NR. ' . $nextSequence, //TODO (Martin): find better solution to generate header
                'invoiceNumber'  => $nextSequence,
                'invoiceDate'    => date('Y-m-d H:i:s'),
                'discount'       => 0,
                'addressCountry' => [
                    'id'         => $parameters['country'] ?? Country::GERMANY,
                    'objectName' => 'StaticCountry'
                ],
                'status'         => $parameters['status'] ?? self::DRAFT,
                'contactPerson'  => [
                    'id'         => $configs['sevUserId'],
                    'objectName' => 'SevUser'
                ],
                'taxRate'        => $configs['taxRate'],
                'taxText'        => $configs['taxText'],
                'taxType'        => $configs['taxType'],
                'invoiceType'    => $configs['invoiceType'],
                'currency'       => $configs['currency'],
                'mapAll'         => 'true'
            ],
            'takeDefaultAddress' => 'true',
            'invoicePosSave' => $this->getInvoiceItems($items, $configs)
        ];
        return array_replace_recursive($requiredParameters, $parameters);

    }
}
