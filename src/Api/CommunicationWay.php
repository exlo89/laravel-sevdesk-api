<?php
/*
 * CommunicationWay.php
 * @author Martin Appelmann <hello@martin-appelmann.de>
 * @copyright 2021 Martin Appelmann
 */

namespace Exlo89\LaravelSevdeskApi\Api;

use Exlo89\LaravelSevdeskApi\Api\Utils\ApiClient;
use Exlo89\LaravelSevdeskApi\Api\Utils\Routes;
use Exlo89\LaravelSevdeskApi\Models\SevCommunicationWay;
use Illuminate\Support\Collection;

/**
 * Sevdesk Comunication Way Api
 *
 * @see https://api.sevdesk.de/#tag/CommunicationWay
 */
class CommunicationWay extends ApiClient
{
    /**
     * Communication way types
     */
    const EMAIL_TYPE = 'EMAIL';
    const PHONE_TYPE = 'PHONE';
    const WEB_TYPE = 'WEB';
    const MOBILE_TYPE = 'MOBILE';

    /**
     * Communication way keys
     */
    const PRIVATE_KEY = 1;
    const WORK_KEY = 2;
    const FAX_KEY = 3;
    const MOBILE_KEY = 4;
    const DEFAULT = 5;
    const CAR_BOX = 6;
    const NEWSLETTER = 7;
    const BILLING_ADDRESS_KEY = 8;

    // =========================== get ====================================

    /**
     * Return all communication way.
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return Collection::make($this->_get(Routes::COMMUNICATION_WAY));
    }

    /**
     * Return a single communication way.
     *
     * @return Collection
     */
    public function getByContact(int $contactId): Collection
    {
        return Collection::make($this->_get(Routes::COMMUNICATION_WAY, [
            'contact' => [
                'id'         => $contactId,
                'objectName' => 'Contact',
            ]
        ]));
    }

    // ========================== create ==================================

    /**
     * Create communication way.
     *
     * @param int $contactId
     * @param string $communicationType
     * @param string $value
     * @return array
     */
    private function create(int $contactId, string $communicationType, string $value): array
    {
        return $this->_post(Routes::COMMUNICATION_WAY, [
            'type'    => $communicationType,
            'contact' => [
                "id"         => $contactId,
                "objectName" => "Contact",
            ],
            'value'   => $value,
            'key'     => [
                "id"         => self::DEFAULT,
                "objectName" => "CommunicationWayKey"
            ],
        ]);
    }

    /**
     * Create email.
     *
     * @param int $contactId
     * @param string $email
     * @return SevCommunicationWay
     */
    public function createEmail(int $contactId, string $email): SevCommunicationWay
    {
        return SevCommunicationWay::make($this->create($contactId, self::EMAIL_TYPE, $email));
    }

    /**
     * Create phone number.
     *
     * @param int $contactId
     * @param string $phone
     * @return SevCommunicationWay
     */
    public function createPhone(int $contactId, string $phone): SevCommunicationWay
    {
        return SevCommunicationWay::make($this->create($contactId, self::PHONE_TYPE, $phone));
    }

    /**
     * Create website.
     *
     * @param int $contactId
     * @param string $website
     * @return SevCommunicationWay
     */
    public function createWebsite(int $contactId, string $website): SevCommunicationWay
    {
        return SevCommunicationWay::make($this->create($contactId, self::WEB_TYPE, $website));
    }

    // ========================== delete ==================================

    /**
     * Delete an existing communication way.
     *
     * @param $communicationWayId
     * @return array
     */
    public function delete($communicationWayId): array
    {
        return $this->_delete(Routes::COMMUNICATION_WAY . '/' . $communicationWayId);
    }
}
