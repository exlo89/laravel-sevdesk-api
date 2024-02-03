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
        // generate a new number and header if invoiceNumber is not set
        if (empty($parameters['invoiceNumber'])) {
            $nextSequence = $this->getNextSequence();
            $parameters['invoiceNumber'] = $nextSequence;
            $parameters['header'] = 'Rechnung NR. ' . $nextSequence;
        }
        // create parameter array
        $invoiceParameters = DocumentHelper::getInvoiceParameters($contactId, $items, $parameters);
        $response = $this->_post(Routes::CREATE_INVOICE, $invoiceParameters);

        // create model with relationships
        /** @var SevInvoice $sevInvoice */
        $sevInvoice = SevInvoice::make($response['invoice']);
        $sevInvoice->setRelation('invoicePositions', collect($response['invoicePos']));
        return $sevInvoice;
    }


    // =======================================================================

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
