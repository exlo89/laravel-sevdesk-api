<?php
/*
 * Invoice.php
 * @author Martin Appelmann <hello@martin-appelmann.de>
 * @copyright 2022 Martin Appelmann
 */

namespace Exlo89\LaravelSevdeskApi\Api;

use Exception;
use Exlo89\LaravelSevdeskApi\Api\Utils\DocumentHelper;
use Exlo89\LaravelSevdeskApi\Constants\InvoiceStatus;
use Exlo89\LaravelSevdeskApi\Models\SevInvoice;
use Exlo89\LaravelSevdeskApi\Models\SevSequence;
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
    // =========================== all ====================================

    /**
     * Return all invoices.
     *
     * @param int $offset Offset for pagination (Optional, default: 0)
     * @param int $limit Maximum number of entries to return (Optional, default: 100)
     * @return Collection
     */
    public function all(int $offset = 0, int $limit = 100): Collection
    {
        return Collection::make($this->_get(Routes::INVOICE, [
            'offset' => $offset,
            'limit'  => $limit,
        ]));
    }

    /**
     * Return all draft invoices.
     *
     * @param int $offset Offset for pagination (Optional, default: 0)
     * @param int $limit Maximum number of entries to return (Optional, default: 100)
     * @return Collection
     */
    public function allDraft(int $offset = 0, int $limit = 100): Collection
    {
        return Collection::make($this->_get(Routes::INVOICE, [
            'status' => InvoiceStatus::DRAFT,
            'offset' => $offset,
            'limit'  => $limit,
        ]));
    }

    /**
     * Return all open invoices.
     *
     * @param int $offset Offset for pagination (Optional, default: 0)
     * @param int $limit Maximum number of entries to return (Optional, default: 100)
     * @return Collection
     */
    public function allOpen(int $offset = 0, int $limit = 100): Collection
    {
        return Collection::make($this->_get(Routes::INVOICE, [
            'status' => InvoiceStatus::OPEN,
            'offset' => $offset,
            'limit'  => $limit,
        ]));
    }

    /**
     * Return all due invoices.
     *
     * @param int $offset Offset for pagination (Optional, default: 0)
     * @param int $limit Maximum number of entries to return (Optional, default: 100)
     * @return Collection
     */
    public function allDue(int $offset = 0, int $limit = 100): Collection
    {
        return Collection::make($this->_get(Routes::INVOICE, [
            'status' => InvoiceStatus::OPEN,
            'delinquent' => true,
            'offset' => $offset,
            'limit'  => $limit,
        ]));
    }

    /**
     * Return all payed invoices.
     *
     * @param int $offset Offset for pagination (Optional, default: 0)
     * @param int $limit Maximum number of entries to return (Optional, default: 100)
     * @return Collection
     */
    public function allPayed(int $offset = 0, int $limit = 100): Collection
    {
        return Collection::make($this->_get(Routes::INVOICE, [
            'status' => InvoiceStatus::PAYED,
            'offset' => $offset,
            'limit'  => $limit,
        ]));
    }

    /**
     * Return all invoices filtered by contact id.
     *
     * @param mixed $contactId The ID of the contact
     * @param int $offset Offset for pagination (Optional, default: 0)
     * @param int $limit Maximum number of entries to return (Optional, default: 100)
     * @return Collection
     */
    public function allByContact($contactId, int $offset = 0, int $limit = 100): Collection
    {
        return Collection::make($this->_get(Routes::INVOICE, [
            'contact' => [
                'id'         => $contactId,
                'objectName' => 'Contact'
            ],
            'offset' => $offset,
            'limit'  => $limit,
        ]));
    }

    /**
     * Return all invoices filtered by a date equal or lower.
     *
     * @param int $timestamp The timestamp for filtering
     * @param int $offset Offset for pagination (Optional, default: 0)
     * @param int $limit Maximum number of entries to return (Optional, default: 100)
     * @return Collection
     */
    public function allBefore(int $timestamp, int $offset = 0, int $limit = 100): Collection
    {
        return Collection::make($this->_get(Routes::INVOICE, [
            'endDate' => $timestamp,
            'offset' => $offset,
            'limit'  => $limit,
        ]));
    }

    /**
     * Return all invoices filtered by a date equal or higher.
     *
     * @param int $timestamp The timestamp for filtering
     * @param int $offset Offset for pagination (Optional, default: 0)
     * @param int $limit Maximum number of entries to return (Optional, default: 100)
     * @return Collection
     */
    public function allAfter(int $timestamp, int $offset = 0, int $limit = 100): Collection
    {
        return Collection::make($this->_get(Routes::INVOICE, [
            'startDate' => $timestamp,
            'offset' => $offset,
            'limit'  => $limit,
        ]));
    }

    /**
     * Return all invoices filtered by a date range.
     *
     * @param int $startTimestamp The start timestamp for filtering
     * @param int $endTimestamp The end timestamp for filtering
     * @param int $offset Offset for pagination (Optional, default: 0)
     * @param int $limit Maximum number of entries to return (Optional, default: 100)
     * @return Collection
     */
    public function allBetween(int $startTimestamp, int $endTimestamp, int $offset = 0, int $limit = 100): Collection
    {
        return Collection::make($this->_get(Routes::INVOICE, [
            'startDate' => $startTimestamp,
            'endDate'   => $endTimestamp,
            'offset' => $offset,
            'limit'  => $limit,
        ]));
    }

    /**
     * Return all invoices filtered by a payment method id and optionally by status.
     *
     * @param int $paymentMethodId The payment method ID for filtering
     * @param array $additionalFilters Optional additional filters
     * @param int $offset Offset for pagination (Optional, default: 0)
     * @param int $limit Maximum number of entries to return (Optional, default: 100)
     * @return Collection The filtered collection of invoices
     */
    public function allByPaymentMethod(int $paymentMethodId, array $additionalFilters = [], int $offset = 0, int $limit = 100): Collection
    {
        // Start with mandatory filter
        $filters = [
            'paymentMethod[id]'         => $paymentMethodId,
            'paymentMethod[objectName]' => 'PaymentMethod',
        ];

        // Merge additional filters into the base filters if provided
        $filters = array_merge($filters, $additionalFilters);

        // Build the query string
        $queryString = http_build_query($filters);

        // Call the _get method with the constructed query string
        return Collection::make($this->_get(Routes::INVOICE . '?' . $queryString));
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
        // create parameter array
        $invoiceParameters = DocumentHelper::getInvoiceParameters($contactId, $items, $parameters);
        $response = $this->_post(Routes::CREATE_INVOICE, $invoiceParameters);

        // create model with relationships
        /** @var SevInvoice $sevInvoice */
        $sevInvoice = SevInvoice::make($response['invoice']);
        $sevInvoice->setRelation('invoicePositions', collect($response['invoicePos']));
        return $sevInvoice;
    }

    // =========================== create reminder ====================================

    /**
     * Create invoice reminder.
     *
     * @param $invoiceId
     * @return SevInvoice
     */
    public function createReminder($invoiceId): SevInvoice
    {
        $response = $this->_post(Routes::CREATE_REMINDER, [
            'invoice' => [
                'id'         => $invoiceId,
                "objectName" => "Invoice"
            ]
        ]);
        return SevInvoice::make($response);
    }

    // =======================================================================

    /**
     * Generate and return the next invoice sequence object.
     *
     * @return SevSequence
     */
    public function getSequence(): SevSequence
    {
        return $this->getNextSequence();
    }

    /**
     * Returns pdf file of the giving invoice id.
     *
     * @return void
     */
    public function download($invoiceId)
    {
        $this->getPdf(Routes::INVOICE . '/' . $invoiceId . '/getPdf');
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

    /**
     * Marks an invoice as sent by a chosen send type.
     *
     * @return void
     */
    public function sendBy($invoiceId, $sendType)
    {
        return $this->_put(Routes::INVOICE.'/'.$invoiceId.'/sendBy', [
            'sendType' => $sendType,
        ]);
    }
}
