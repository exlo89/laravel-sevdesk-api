<?php
/*
 * Order.php
 * @author Martin Appelmann <hello@martin-appelmann.de>
 * @copyright 2024 Martin Appelmann
 */

namespace Exlo89\LaravelSevdeskApi\Api;

use Exception;
use Exlo89\LaravelSevdeskApi\Api\Utils\ApiClient;
use Exlo89\LaravelSevdeskApi\Api\Utils\DocumentHelper;
use Exlo89\LaravelSevdeskApi\Api\Utils\Routes;
use Exlo89\LaravelSevdeskApi\Constants\OrderStatus;
use Exlo89\LaravelSevdeskApi\Constants\OrderType;
use Exlo89\LaravelSevdeskApi\Models\SevOrder;
use Illuminate\Support\Collection;

/**
 * Sevdesk Order Api
 *
 * @see https://api.sevdesk.de/#tag/Order
 */
class Order extends ApiClient
{
    // =========================== all ====================================

    /**
     * Return all orders.
     *
     * @param string|null $orderType
     * @param string|null $orderStatus
     * @return Collection
     */
    public function all(?string $orderType = null, ?string $orderStatus = null): Collection
    {
        return Collection::make($this->_get(Routes::ORDER, $this->getParam($orderType, $orderStatus)));
    }

    /**
     * Return all draft orders.
     *
     * @param string|null $orderType
     * @return Collection
     */
    public function allDraft(?string $orderType = null): Collection
    {
        return Collection::make($this->_get(Routes::ORDER, $this->getParam($orderType, OrderStatus::DRAFT)));
    }

    /**
     * Return all delivered orders.
     *
     * @param string|null $orderType
     * @return Collection
     */
    public function allDelivered(?string $orderType = null): Collection
    {
        return Collection::make($this->_get(Routes::ORDER, $this->getParam($orderType, OrderStatus::DELIVERED)));
    }

    /**
     * Return all cancelled orders.
     *
     * @param string|null $orderType
     * @return Collection
     */
    public function allCancelled(?string $orderType = null): Collection
    {
        return Collection::make($this->_get(Routes::ORDER, $this->getParam($orderType, OrderStatus::CANCELLED)));
    }

    /**
     * Return all accepted orders.
     *
     * @param string|null $orderType
     * @return Collection
     */
    public function allAccepted(?string $orderType = null): Collection
    {
        return Collection::make($this->_get(Routes::ORDER, $this->getParam($orderType, OrderStatus::ACCEPTED)));
    }

    /**
     * Return all partial accepted orders.
     *
     * @param string|null $orderType
     * @return Collection
     */
    public function allPartialAccepted(?string $orderType = null): Collection
    {
        return Collection::make($this->_get(Routes::ORDER, $this->getParam($orderType, OrderStatus::PARTIAL_CALCULATED)));
    }

    /**
     * Return all calculated orders.
     *
     * @param string|null $orderType
     * @return Collection
     */
    public function allCalculated(?string $orderType = null): Collection
    {
        return Collection::make($this->_get(Routes::ORDER, $this->getParam($orderType, OrderStatus::CALCULATED)));
    }

    /**
     * Return all orders filtered by contact id.
     *
     * @param $contactId
     * @return Collection
     */
    public function allByContact($contactId): Collection
    {
        return Collection::make($this->_get(Routes::ORDER, [
            'contact' => [
                'id'         => $contactId,
                'objectName' => 'Contact'
            ],
        ]));
    }

    /**
     * Return all orders filtered by a date equal or lower.
     *
     * @param int $timestamp
     * @return Collection
     */
    public function allBefore(int $timestamp): Collection
    {
        return Collection::make($this->_get(Routes::ORDER, ['endDate' => $timestamp]));
    }

    /**
     * Return all orders filtered by a date equal or higher.
     *
     * @param int $timestamp
     * @return Collection
     */
    public function allAfter(int $timestamp): Collection
    {
        return Collection::make($this->_get(Routes::ORDER, ['startDate' => $timestamp]));
    }

    /**
     * Return all orders filtered by a date range.
     *
     * @param int $startTimestamp
     * @param int $endTimestamp
     * @return Collection
     */
    public function allBetween(int $startTimestamp, int $endTimestamp): Collection
    {
        return Collection::make($this->_get(Routes::ORDER, [
            'startDate' => $startTimestamp,
            'endDate'   => $endTimestamp,
        ]));
    }

    // =========================== create ====================================

    /**
     * Create order.
     *
     * @param $contactId
     * @param array $items
     * @param array $parameters
     * @return SevOrder
     * @throws Exception
     */
    public function create($contactId, $items, array $parameters = []): SevOrder
    {
        // create parameter array
        $parameters['orderType'] = OrderType::PROPOSAL;
        $orderParameters = DocumentHelper::getOrderParameters($contactId, $items, $parameters);
        $response = $this->_post(Routes::CREATE_ORDER, $orderParameters);

        // create model with relationships
        /** @var SevOrder $sevOrder */
        $sevOrder = SevOrder::make($response['order']);
        $sevOrder->setRelation('orderPositions', collect($response['orderPos']));
        return $sevOrder;
    }
    // ========================== update ==================================

    /**
     * Update an existing order.
     *
     * @param $orderId
     * @param array $parameters
     * @return SevOrder
     */
    public function update($orderId, array $parameters = []): SevOrder
    {
        return SevOrder::make($this->_put(Routes::ORDER . '/' . $orderId, $parameters));
    }

    // ========================== delete ==================================

    /**
     * Delete an existing order.
     *
     * @param $orderId
     * @return void
     */
    public function delete($orderId): void
    {
        $this->_delete(Routes::ORDER . '/' . $orderId);
    }

    // =======================================================================

    /**
     * Returns pdf file of the giving order id.
     *
     * @return void
     */
    public function download($orderId)
    {
        $this->getPdf(Routes::ORDER . '/' . $orderId . '/getPdf');
    }

    /**
     * Send order per email.
     *
     * @return void
     */
    public function sendByMail($orderId, $email, $subject, $text)
    {
        return $this->_post(Routes::ORDER . '/' . $orderId . '/sendViaEmail', [
            'toEmail' => $email,
            'subject' => $subject,
            'text'    => $text,
        ]);
    }

    // ================== private functions ==================

    private function getParam($type, $status)
    {
        $params = [];
        if ($type !== null) {
            $params['orderType'] = $type;
        }
        if ($status !== null) {
            $params['status'] = $status;
        }
        return $params;
    }
}
