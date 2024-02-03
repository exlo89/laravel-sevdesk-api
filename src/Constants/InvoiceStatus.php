<?php
/*
 * InvoiceStatus.php
 * @author Martin Appelmann <hello@martin-appelmann.de>
 * @copyright 2024 Martin Appelmann
 */

namespace Exlo89\LaravelSevdeskApi\Constants;

/**
 * Sevdesk Credit Note Status
 *
 * @see https://api.sevdesk.de/#tag/Invoice/Types-and-status-of-invoices
 */
class InvoiceStatus
{
    const DEACTIVATED_RECURRING = 50;
    const DRAFT = 100;
    const OPEN = 200;
    const PAYED = 1000;
}
