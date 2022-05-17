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
}
