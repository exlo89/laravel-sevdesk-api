<?php
/*
 * Routes.php
 * @author Martin Appelmann <hello@martin-appelmann.de>
 * @copyright 2021 Martin Appelmann
 */

namespace Exlo89\LaravelSevdeskApi\Api\Utils;

class Routes
{
    const ACCOUNTING_CONTACT = 'AccountingContact';
    const CONTACT = 'Contact';
    const CONTACT_ADDRESS = 'ContactAddress';
    const COMMUNICATION_WAY = 'CommunicationWay';
    const CREDIT_NOTE = 'CreditNote';
    const INVOICE = 'Invoice';
    const CREATE_INVOICE = 'Invoice/Factory/saveInvoice';
    const STATIC_COUNTRY= 'StaticCountry';
}
