<?php
return [
    /**
     * Your Sevdesk api token. You can find it on your Sevdesk platform under ["Settings" > "Users"]
     */
    'api_token'    => env('SEVDESK_API_TOKEN', ''),

    /**
     * Sev User (contact person) is necessary to create invoices.
     */
    'sev_user_id'  => env('SEVDESK_SEV_USER', ''),

    /**
     * These are also necessary configs to create invoices.
     */
    'tax_rate'     => env('SEVDESK_TAX_RATE', 19),
    'tax_text'     => env('SEVDESK_TAX_TEXT', 'Umsatzsteuer 19%'),
    'tax_type'     => env('SEVDESK_TAX_TYPE', 'default'),
    'tax_rule'     => env('SEVDESK_TAX_RULE', 1),
    'currency'     => env('SEVDESK_CURRENCY', 'EUR'),
    'invoice_type' => env('SEVDESK_INVOICE_TYPE', 'RE'),
];
