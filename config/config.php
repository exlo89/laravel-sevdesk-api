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
     * These are also necessary configs to create invoices or orders.
     */
    'tax_rate'     => env('SEVDESK_TAX_RATE', 19),
    'tax_text'     => env('SEVDESK_TAX_TEXT', 'VAT 19%'),   // only in version 1.0
    'tax_type'     => env('SEVDESK_TAX_TYPE', 'default'),   // only in version 1.0
    'tax_rule'     => env('SEVDESK_TAX_RULE', 1),           // only in version 2.0
    'currency'     => env('SEVDESK_CURRENCY', 'EUR'),
    'invoice_type' => env('SEVDESK_INVOICE_TYPE', 'RE'),
];
