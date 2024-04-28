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
        return Collection::make($this->_get(Routes::INVOICE, ['status' => InvoiceStatus::DRAFT]));
    }

    /**
     * Return all open invoices.
     *
     * @return Collection
     */
    public function allOpen(): Collection
    {
        return Collection::make($this->_get(Routes::INVOICE, ['status' => InvoiceStatus::OPEN]));
    }

    /**
     * Return all due invoices.
     *
     * @return Collection
     */
    public function allDue(): Collection
    {
        return Collection::make($this->_get(Routes::INVOICE, ['status' => InvoiceStatus::OPEN, 'delinquent' => true]));
    }

    /**
     * Return all payed invoices.
     *
     * @return Collection
     */
    public function allPayed(): Collection
    {
        return Collection::make($this->_get(Routes::INVOICE, ['status' => InvoiceStatus::PAYED]));
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

    /**
     * Return all invoices filtered by a date range.
     *
     * @param int $startTimestamp
     * @param int $endTimestamp
     * @return Collection
     */
    public function allBetween(int $startTimestamp, int $endTimestamp): Collection
    {
        return Collection::make($this->_get(Routes::INVOICE, [
            'startDate' => $startTimestamp,
            'endDate'   => $endTimestamp,
        ]));
    }

    /**
     * Return all invoices filtered by a payment method id and optionally by status.
     *
     * @param int $paymentMethodId The payment method ID to filter invoices.
     * @param array $additionalFilters Optional additional filters to apply.
     * @return Collection The filtered collection of invoices.
     */
    public function allByPaymentMethod(int $paymentMethodId, array $additionalFilters = []): Collection
    {
        // Start with mandatory filter
        $filters = [
            'paymentMethod[id]' => $paymentMethodId,
            'paymentMethod[objectName]' => 'PaymentMethod',
        ];

        // Merge additional filters into the base filters if provided
        $filters = array_merge($filters, $additionalFilters);

        return Collection::make($this->_get(Routes::INVOICE, $filters));
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
}
