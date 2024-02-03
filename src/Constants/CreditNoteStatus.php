<?php
/*
 * CreditNoteStatus.php
 * @author Martin Appelmann <hello@martin-appelmann.de>
 * @copyright 2024 Martin Appelmann
 */

namespace Exlo89\LaravelSevdeskApi\Constants;

/**
 * Sevdesk Credit Note Status
 *
 * @see https://api.sevdesk.de/#tag/CreditNote/Status-of-credit-notes
 */
class CreditNoteStatus
{
    const DRAFT = 100;
    const DELIVERED = 200;
    const PARTIAL_PAYMENT = 750;
    const PAYED = 1000;
}
