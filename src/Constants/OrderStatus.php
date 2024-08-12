<?php
/*
 * OrderStatus.php
 * @author Martin Appelmann <hello@martin-appelmann.de>
 * @copyright 2024 Martin Appelmann
 */

namespace Exlo89\LaravelSevdeskApi\Constants;

/**
 * Sevdesk Order Status
 *
 * @see https://api.sevdesk.de/#tag/Order/Types-and-status-of-orders
 */
class OrderStatus
{
    /**
     * The order is still a draft. It has not been sent to the end-customer and can still be changed.
     */
    const DRAFT = 100;
    /**
     * The order has been sent to the end-customer.
     */
    const DELIVERED = 200;
    /**
     * The order has been rejected by the end-customer.
     */
    const CANCELLED = 300;
    /**
     * The order has been accepted by the end-customer.
     */
    const ACCEPTED = 500;
    /**
     * An invoice for parts of the order (but not the full order) has been created.
     */
    const PARTIAL_CALCULATED = 750;
    /**
     * The order has been calculated. One or more invoices have been created covering the whole order.
     */
    const CALCULATED = 1000;
}
