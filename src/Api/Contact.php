<?php
/*
 * Contact.php
 * @author Martin Appelmann <hello@martin-appelmann.de>
 * @copyright 2023 Martin Appelmann
 */

namespace Exlo89\LaravelSevdeskApi\Api;

use Illuminate\Support\Collection;
use Exlo89\LaravelSevdeskApi\Models\SevContact;
use Exlo89\LaravelSevdeskApi\Api\Utils\ApiClient;
use Exlo89\LaravelSevdeskApi\Api\Utils\Routes;

/**
 * Sevdesk Contact Api
 *
 * test *description*
 *
 * @see https://api.sevdesk.de/#tag/Contact
 */
class Contact extends ApiClient
{
    /**
     * Contact categories
     */
    const SUPPLIER = 2;
    const CUSTOMER = 3;
    const PARTNER = 4;
    const PROSPECT_CUSTOMER = 28;

    const DEFAULT_LIMIT = 1000;

    // =========================== all ====================================

    /**
     * Return all organisation contacts by default. If you want organisations and persons use $depth = 1.
     *
     * @param int $depth
     * @param int $limit
     * @return Collection
     */
    public function all(int $depth = 0, int $limit = self::DEFAULT_LIMIT): Collection
    {
        return Collection::make($this->_get(Routes::CONTACT, ['depth' => $depth, 'limit' => $limit,]));
    }

    /**
     * Return contacts filtered by city.
     *
     * @param string $city
     * @param int $depth
     * @param int $limit
     * @return Collection
     */
    public function allByCity(string $city, int $depth = 0, int $limit = self::DEFAULT_LIMIT): Collection
    {
        return Collection::make($this->_get(Routes::CONTACT, ['city' => $city, 'depth' => $depth, 'limit' => $limit,]));
    }

    /**
     * Return supplier contacts.
     *
     * @param int $depth
     * @param int $limit
     * @return Collection
     */
    public function allSuppliers(int $depth = 0, int $limit = self::DEFAULT_LIMIT): Collection
    {
        return Collection::make($this->_get(Routes::CONTACT, [
            'category' => [
                "id"         => self::SUPPLIER,
                "objectName" => "Category"
            ],
            'depth'    => $depth,
            'limit'    => $limit,
        ]));
    }

    /**
     * Return customer contacts.
     *
     * @param int $depth
     * @param int $limit
     * @return Collection
     */
    public function allCustomers(int $depth = 0, int $limit = self::DEFAULT_LIMIT): Collection
    {
        return Collection::make($this->_get(Routes::CONTACT, [
            'category' => [
                "id"         => self::CUSTOMER,
                "objectName" => "Category"
            ],
            'depth'    => $depth,
            'limit'    => $limit,
        ]));
    }

    /**
     * Return partner contacts.
     *
     * @param int $depth
     * @param int $limit
     * @return Collection
     */
    public function allPartners(int $depth = 0, int $limit = self::DEFAULT_LIMIT): Collection
    {
        return Collection::make($this->_get(Routes::CONTACT, [
            'category' => [
                "id"         => self::PARTNER,
                "objectName" => "Category"
            ],
            'depth'    => $depth,
            'limit'    => $limit,
        ]));
    }

    /**
     * Return prospect customer contacts.
     *
     * @param int $depth
     * @param int $limit
     * @return Collection
     */
    public function allProspectCustomers(int $depth = 0, int $limit = self::DEFAULT_LIMIT): Collection
    {
        return Collection::make($this->_get(Routes::CONTACT, [
            'category' => [
                "id"         => self::PROSPECT_CUSTOMER,
                "objectName" => "Category"
            ],
            'depth'    => $depth,
            'limit'    => $limit,
        ]));
    }

    /**
     * Return contacts with custom category.
     *
     * @param int $contactCategory
     * @param int $depth
     * @param int $limit
     * @return Collection
     */
    public function allCustom(int $contactCategory, int $depth = 0, int $limit = self::DEFAULT_LIMIT): Collection
    {
        return Collection::make(
            SevContact::make(
                $this->_get(Routes::CONTACT, [
                    'category' => [
                        "id"         => $contactCategory,
                        "objectName" => "Category"
                    ],
                    'depth'    => $depth,
                    'limit'    => $limit,
                ])
            )
        );
    }

    // =========================== get ====================================

    /**
     * Return a single contact.
     *
     * @param $contactId
     * @return mixed
     */
    public function get($contactId): SevContact
    {
        return SevContact::make($this->_get(Routes::CONTACT . '/' . $contactId)[0]);
    }

    /**
     * Return next contact number.
     *
     * @return int
     */
    public function getNextCustomerNumber(): int
    {
        return $this->_get(Routes::CONTACT . '/Factory/getNextCustomerNumber');
    }

    // ========================== create ==================================

    /**
     * Create contact.
     *
     * @param int $contactType
     * @param array $parameters
     * @return array
     */
    public function create(int $contactType, array $parameters = []): array
    {
        $parameters['category'] = [
            "id"         => $contactType,
            "objectName" => "Category"
        ];
        return $this->_post(Routes::CONTACT, $parameters);
    }

    /**
     * Create supplier contact.
     *
     * @param string $supplierName
     * @param array $parameters
     * @return SevContact
     */
    public function createSupplier(string $supplierName, array $parameters = []): SevContact
    {
        $parameters['name'] = $supplierName;
        return SevContact::make($this->create(self::SUPPLIER, $parameters));
    }

    /**
     * Create customer contact.
     *
     * @param string $customerName
     * @param array $parameters
     * @return SevContact
     */
    public function createCustomer(string $customerName, array $parameters = []): SevContact
    {
        $parameters['name'] = $customerName;
        return SevContact::make($this->create(self::CUSTOMER, $parameters));
    }

    /**
     * Create partner contact.
     *
     * @param string $partnerName
     * @param array $parameters
     * @return SevContact
     */
    public function createPartner(string $partnerName, array $parameters = []): SevContact
    {
        $parameters['name'] = $partnerName;
        return SevContact::make($this->create(self::PARTNER, $parameters));
    }

    /**
     * Create prospect customer contact.
     *
     * @param string $prospectCustomerName
     * @param array $parameters
     * @return SevContact
     */
    public function createProspectCustomer(string $prospectCustomerName, array $parameters = []): SevContact
    {
        $parameters['name'] = $prospectCustomerName;
        return SevContact::make($this->create(self::PROSPECT_CUSTOMER, $parameters));
    }

    /**
     * Create contact with custom contact category.
     *
     * @param string $organisationName
     * @param int $contactCategory
     * @param array $parameters
     * @return SevContact
     */
    public function createCustom(string $organisationName, int $contactCategory, array $parameters = []): SevContact
    {
        $parameters['name'] = $organisationName;
        return SevContact::make($this->create($contactCategory, $parameters));
    }

    // ========================== update ==================================

    /**
     * Update an existing contact.
     *
     * @param $contactId
     * @param array $parameters
     * @return SevContact
     */
    public function update($contactId, array $parameters = []): SevContact
    {
        return SevContact::make($this->_put(Routes::CONTACT . '/' . $contactId, $parameters));
    }

    // ========================== delete ==================================

    /**
     * Delete an existing contact.
     *
     * @param $contactId
     * @return void
     */
    public function delete($contactId): void
    {
        $this->_delete(Routes::CONTACT . '/' . $contactId);
    }
}
