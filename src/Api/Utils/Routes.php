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
    const PART = 'Part';
    const CREDIT_NOTE = 'CreditNote';
    const CREATE_CREDIT_NOTE = self::CREDIT_NOTE . '/Factory/saveCreditNote';
    const CREATE_CREDIT_NOTE_FROM_INVOICE = self::CREDIT_NOTE . '/Factory/createFromInvoice';
    const INVOICE = 'Invoice';
    const SEV_USER = 'SevUser';
    const CREATE_INVOICE = self::INVOICE . '/Factory/saveInvoice';
    const STATIC_COUNTRY = 'StaticCountry';
    const SEQUENCE = 'SevSequence/Factory/getByType';
}
