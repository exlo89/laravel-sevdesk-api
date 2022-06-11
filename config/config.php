<?php
return [
    /*
     * Your sevdesk api token.
     */
    'api_token' => env('SEVDESK_API_TOKEN', ''),

    /*
     * Sev User (contact person) is necessary to create invoices.
     */
    'sev_user_id' => env('SEVDESK_SEV_USER', ''),
    'tax_rate' => env('SEVDESK_TAX_RATE', 19),
    'tax_text' => env('SEVDESK_TAX_TEXT', 'Umsatzsteuer 19%'),
    'tax_type' => env('SEVDESK_TAX_TYPE', 'default'),
    'currency' => env('SEVDESK_CURRENCY', 'EUR'),
    'invoice_type' => env('SEVDESK_INVOICE_TYPE', 'RE'),
];
