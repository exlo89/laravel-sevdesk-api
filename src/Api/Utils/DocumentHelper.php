<?php
/*
 * Routes.php
 * @author Martin Appelmann <hello@martin-appelmann.de>
 * @copyright 2024 Martin Appelmann
 */

namespace Exlo89\LaravelSevdeskApi\Api\Utils;

use Exception;
use Exlo89\LaravelSevdeskApi\Constants\Country;
use Exlo89\LaravelSevdeskApi\Constants\CreditNoteStatus;
use Exlo89\LaravelSevdeskApi\Constants\InvoiceStatus;

class DocumentHelper
{
    /**
     * Return default config values.
     *
     * @return array
     * @throws Exception
     */
    static private function getDefaultConfigs(): array
    {
        $values = [];
        $values['taxRate'] = config('sevdesk-api.tax_rate');
        $values['taxText'] = config('sevdesk-api.tax_text');
        $values['taxType'] = config('sevdesk-api.tax_type');
        $values['invoiceType'] = config('sevdesk-api.invoice_type');
        $values['currency'] = config('sevdesk-api.currency');
        $values['sevUserId'] = config('sevdesk-api.sev_user_id');
        return $values;
    }

    /**
     * Validate and return config values.
     *
     * @param array $configs
     * @return array
     * @throws Exception
     */
    static private function validateConfigs(array $configs): array
    {
        if (empty($configs['taxRate'])) {
            throw new Exception('Configuration parameter not found: tax_rate');
        }
        if (empty($configs['taxText'])) {
            throw new Exception('Configuration parameter not found: tax_text');
        }
        if (empty($configs['taxType'])) {
            throw new Exception('Configuration parameter not found: tax_type');
        }
        if (empty($configs['invoiceType'])) {
            throw new Exception('Configuration parameter not found: invoice_type');
        }
        if (empty($configs['currency'])) {
            throw new Exception('Configuration parameter not found: currency');
        }
        if (empty($configs['sevUserId'])) {
            throw new Exception('Configuration parameter not found: sev_user_id');
        }
        return $configs;
    }

    /**
     * Format document items.
     *
     * @param array $items
     * @param array $configs
     * @param string $objectName
     * @return array
     * @throws Exception
     */
    static private function getDocumentItems(array $items, array $configs, string $objectName): array
    {
        $documentItems = [];
        if (empty($items)) {
            throw new Exception('No items found');
        }
        foreach ($items as $item) {
            if (array_key_exists('name', $item) && array_key_exists('price', $item)) {
                $documentItems[] = [
                    'objectName'     => ucfirst($objectName) . 'Pos',
                    'mapAll'         => 'true',
                    'part'           => empty($item['partId']) ? null : [
                        'id'         => $item['partId'],
                        'objectName' => 'Part'
                    ],
                    'quantity'       => $item['quantity'] ?? 1,
                    'price'          => $item['price'],
                    'priceTax'       => $item['priceTax'] ?? null,
                    'priceGross'     => $item['priceGross'] ?? null,
                    'name'           => $item['name'],
                    'unity'          => [
                        'id'         => $item['unityId'] ?? 1,
                        'objectName' => 'Unity',
                    ],
                    'positionNumber' => $item['positionNumber'] ?? null,
                    'text'           => $item['text'] ?? '',
                    'discount'       => $item['discount'] ?? null,
                    'optional'       => $item['optional'] ?? null,
                    'taxRate'        => $item['taxRate'] ?? $configs['taxRate'],
                ];
            }
        }
        return $documentItems;
    }

    /**
     * Create credit note parameter array.
     *
     * @param string $contactId
     * @param array $items
     * @param array $parameters
     * @param array|null $configs
     * @return array
     * @throws Exception
     */
    static function getCreditNoteParameters(string $contactId, array $items, array $parameters, array $configs = null): array
    {
        // set and validate config values
        $configs = $configs ?? self::getDefaultConfigs();
        self::validateConfigs($configs);
        return [
            'creditNote'        => [
                'objectName'           => 'CreditNote',
                'mapAll'               => 'true',
                'creditNoteNumber'     => $parameters['creditNoteNumber'] ?? null,
                'contact'              => [
                    'id'         => $contactId,
                    'objectName' => 'Contact'
                ],
                'creditNoteDate'       => $parameters['creditNoteDate'] ?? date('Y-m-d H:i:s'),
                'status'               => $parameters['status'] ?? CreditNoteStatus::DRAFT,
                'header'               => $parameters['header'] ?? null,
                'headText'             => $parameters['headText'] ?? null,
                'footText'             => $parameters['footText'] ?? null,
                'addressCountry'       => [
                    'id'         => $parameters['country'] ?? Country::GERMANY,
                    'objectName' => 'StaticCountry'
                ],
                'deliveryDate'         => $parameters['deliveryDate'] ?? date('Y-m-d H:i:s'),
                'deliveryTerms'        => $parameters['deliveryTerns'] ?? null,
                'paymentTerms'         => $parameters['paymentTerns'] ?? null,
                'version'              => $parameters['version'] ?? null,
                'smallSettlement'      => $parameters['smallSettlement'] ?? null,
                'contactPerson'        => [
                    'id'         => $configs['sevUserId'],
                    'objectName' => 'SevUser'
                ],
                'taxRate'              => $parameters['taxRate'] ?? $configs['taxRate'],
                'taxSet'               => empty($parameters['taxSetId']) ? null : [
                    'id'         => $parameters['taxSetId'],
                    'objectName' => 'TaxSet'
                ],
                'taxText'              => $parameters['taxText'] ?? $configs['taxText'],
                'taxType'              => $parameters['taxType'] ?? $configs['taxType'],
                'sendDate'             => $parameters['sendDate'] ?? date('Y-m-d H:i:s'),
                'address'              => $parameters['address'] ?? null,
                'bookingCategory'      => $parameters['bookingCategory'] ?? null,
                'currency'             => $parameters['currency'] ?? $configs['currency'],
                'customerInternalNote' => $parameters['customerInternalNote'] ?? null,
                'showNet'              => $parameters['showNet'] ?? null,
                'sendType'             => $parameters['sendType'] ?? null,
            ],
            'takeDefaultAddress' => 'true',
            'creditNotePosSave' => self::getDocumentItems($items, $configs, 'creditNote'),
        ];
    }

    /**
     * Create invoice parameter array.
     *
     * @param string $contactId
     * @param array $items
     * @param array $parameters
     * @param array|null $configs
     * @return array
     * @throws Exception
     */
    static function getInvoiceParameters(string $contactId, array $items, array $parameters, array $configs = null): array
    {
        // set and validate config values
        $configs = $configs ?? self::getDefaultConfigs();
        self::validateConfigs($configs);
        return [
            'invoice'        => [
                'objectName'           => 'Invoice',
                'mapAll'               => 'true',
                'invoiceNumber'        => $parameters['invoiceNumber'] ?? null,
                'contact'              => [
                    'id'         => $contactId,
                    'objectName' => 'Contact'
                ],
                'contactPerson'        => [
                    'id'         => $configs['sevUserId'],
                    'objectName' => 'SevUser'
                ],
                'invoiceDate'          => $parameters['invoiceDate'] ?? date('Y-m-d H:i:s'),
                'header'               => $parameters['header'] ?? null,
                'headText'             => $parameters['headText'] ?? null,
                'footText'             => $parameters['footText'] ?? null,
                'timeToPay'            => $parameters['timeToPay'] ?? null,
                'discount'             => $parameters['discount'] ?? 0,
                'address'              => $parameters['address'] ?? null,
                'addressCountry'       => [
                    'id'         => $parameters['country'] ?? Country::GERMANY,
                    'objectName' => 'StaticCountry'
                ],
                'payDay'               => $parameters['payDay'] ?? null,
                'deliveryDate'         => $parameters['deliveryDate'] ?? date('Y-m-d H:i:s'),
                'deliveryDateUntil'    => $parameters['deliveryDateUntil'] ?? null,
                'status'               => $parameters['status'] ?? InvoiceStatus::DRAFT,
                'smallSettlement'      => $parameters['smallSettlement'] ?? null,
                'taxRate'              => $parameters['taxRate'] ?? $configs['taxRate'],
                'taxText'              => $parameters['taxText'] ?? $configs['taxText'],
                'taxType'              => $parameters['taxType'] ?? $configs['taxType'],
                'taxSet'               => empty($parameters['taxSetId']) ? null : [
                    'id'         => $parameters['taxSetId'],
                    'objectName' => 'TaxSet'
                ],
                'paymentMethod'        => empty($parameters['paymentMethodId']) ? null : [
                    'id'         => $parameters['paymentMethodId'],
                    'objectName' => 'PaymentMethod',
                ],
                'sendDate'             => $parameters['sendDate'] ?? date('Y-m-d H:i:s'),
                'invoiceType'          => $parameters['invoiceType'] ?? $configs['invoiceType'],
                'currency'             => $parameters['currency'] ?? $configs['currency'],
                'showNet'              => $parameters['showNet'] ?? null,
                'sendType'             => $parameters['sendType'] ?? null,
                'origin'               => empty($parameters['originId']) || empty($parameters['originModel']) ? null : [
                    'id'         => $parameters['originId'],
                    'objectName' => $parameters['originModel'],
                ],
                'customerInternalNote' => $parameters['customerInternalNote'] ?? null,
            ],
            'takeDefaultAddress' => 'true',
            'invoicePosSave' => self::getDocumentItems($items, $configs, 'invoice'),
        ];
    }
}
