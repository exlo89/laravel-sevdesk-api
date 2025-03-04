<?php
/*
 * AccountingContact.php
 * @author Martin Appelmann <hello@martin-appelmann.de>
 * @copyright 2023 Martin Appelmann
 */

namespace Exlo89\LaravelSevdeskApi\Api;

use Exlo89\LaravelSevdeskApi\Api\Utils\ApiClient;
use Exlo89\LaravelSevdeskApi\Api\Utils\Routes;
use Exlo89\LaravelSevdeskApi\Models\SevAccountingContact;
use Exlo89\LaravelSevdeskApi\Models\SevContact;
use Illuminate\Support\Collection;


/**
 * Sevdesk AccountingContact Api
 *
 * @see https://api.sevdesk.de/#tag/AccountingContact
 */
class AccountingContact extends ApiClient
{

    // =========================== all ====================================

    /**
     * Return all accounting contacts.
     *
     * @param int $limit
     * @return Collection
     */
    public function all(int $limit = 1000): Collection
    {
        return Collection::make($this->_get(Routes::ACCOUNTING_CONTACT, ['limit' => $limit,]));
    }

    // =========================== get ====================================

    /**
     * Return a single accounting contact.
     *
     * @param $accountingContactId
     * @return SevAccountingContact
     */
    public function get($accountingContactId): SevAccountingContact
    {
        return SevAccountingContact::make($this->_get(Routes::ACCOUNTING_CONTACT . '/' . $accountingContactId)[0]);
    }


    /**
     * Return a single accounting contact by contact id.
     *
     * @param $contactId
     * @return SevContact
     */
    public function getByContact($contactId): SevContact
    {
        $parameters['contact'] = [
            "id"         => $contactId,
            "objectName" => "Contact",
        ];
        return SevContact::make($this->_get(Routes::CONTACT, $parameters)[0]);
    }

    // ========================== create ==================================

    /**
     * Create accounting contact.
     *
     * @param int $contactId
     * @return SevAccountingContact
     */
    public function create(int $contactId): SevAccountingContact
    {
        return SevAccountingContact::make(
            $this->_post(Routes::ACCOUNTING_CONTACT, [
                'contact' => [
                    "id"         => $contactId,
                    "objectName" => "Contact"
                ]
            ])
        );
    }

    // ========================== update ==================================

    /**
     * Update an existing accounting contact.
     *
     * @param $accountingContactId
     * @param array $parameters
     * @return SevAccountingContact
     */
    public function update($accountingContactId, array $parameters = []): SevAccountingContact
    {
        return SevAccountingContact::make($this->_put(Routes::ACCOUNTING_CONTACT . '/' . $accountingContactId, $parameters));
    }

    // ========================== delete ==================================

    /**
     * Delete an existing accounting contact.
     *
     * @param $accountingContactId
     * @return array
     */
    public function delete($accountingContactId): array
    {
        return $this->_delete(Routes::ACCOUNTING_CONTACT . '/' . $accountingContactId);
    }
}
