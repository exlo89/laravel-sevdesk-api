<?php
/*
 * SevOrder.php
 * @author Martin Appelmann <hello@martin-appelmann.de>
 * @copyright 2024 Martin Appelmann
 */

namespace Exlo89\LaravelSevdeskApi\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SevOrder extends Model
{
    protected $fillable = [
        'id',
        'objectName',
        'additionalInformation',
        'propertyIsEInvoice',
        'orderNumber',
        'create',
        'update',
        'orderDate',
        'header',
        'headText',
        'footText',
        'timeToPay',
        'discountTime',
        'discount',
        'addressName',
        'addressStreet',
        'addressZip',
        'addressCity',
        'payDate',
        'deliveryDate',
        'status',
        'smallSettlement',
        'taxRate',
        'taxText',
        'dunningLevel',
        'addressParentName',
        'taxType',
        'sendDate',
        'originLastorder',
        'orderType',
        'accountIntervall',
        'accountLastorder',
        'accountNextorder',
        'reminderTotal',
        'reminderDebit',
        'reminderDeadline',
        'reminderCharge',
        'addressParentName2',
        'addressName2',
        'addressGender',
        'accountStartDate',
        'accountEndDate',
        'address',
        'currency',
        'sumNet',
        'sumTax',
        'sumGross',
        'sumDiscounts',
        'sumNetForeignCurrency',
        'sumTaxForeignCurrency',
        'sumGrossForeignCurrency',
        'sumDiscountsForeignCurrency',
        'sumNetAccounting',
        'sumTaxAccounting',
        'sumGrossAccounting',
        'paidAmount',
        'customerInternalNote',
        'showNet',
        'enshrined',
        'sendType',
        'deliveryDateUntil',
        'sendPaymentReceivedNotificationDate',
        'sumDiscountNet',
        'sumDiscountGross',
        'sumDiscountNetForeignCurrency',
        'sumDiscountGrossForeignCurrency'
    ];

    /**
     * @return BelongsTo
     */
    public function contact(): BelongsTo
    {
        return $this->belongsTo(SevContact::class);
    }
}
