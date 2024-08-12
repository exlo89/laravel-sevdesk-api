<?php
/*
 * OrderType.php
 * @author Martin Appelmann <hello@martin-appelmann.de>
 * @copyright 2024 Martin Appelmann
 */

namespace Exlo89\LaravelSevdeskApi\Constants;

/**
 * Sevdesk Order Status
 *
 * @see https://api.sevdesk.de/#tag/Order/Types-and-status-of-orders
 */
class OrderType
{
    /**
     * A normal order which documents a simple estimation / proposal for an end-customer.
     */
    const PROPOSAL = 'AN';
    /**
     * A confirmation for an estimate / proposal.
     */
    const ORDER_CONFIRMATION = 'AB';
    /**
     * A confirmation that goods from an estimate / proposal have been sent.
     */
    const DELIVERY_NODE = 'LI';
}
