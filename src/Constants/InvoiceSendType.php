<?php
/*
 * InvoiceSendType.php
 * @author Titus Kirch <contact@kirch.dev>
 * @copyright 2025 Titus Kirch
 */

namespace Exlo89\LaravelSevdeskApi\Constants;

/**
 * Sevdesk Invoice Send Type
 *
 * @see https://api.sevdesk.de/#tag/Invoice/Attributes-of-an-invoice
 */
class InvoiceSendType
{
    const VPR = 'VPR'; #printed
    const VPDF = 'VPDF'; #downloaded
    const VM = 'VM'; #mailed
    const VP = 'VP'; #postal
}