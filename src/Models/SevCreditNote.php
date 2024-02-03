<?php
/*
 * SevCreditNote.php
 * @author Martin Appelmann <hello@martin-appelmann.de>
 * @copyright 2024 Martin Appelmann
 */

namespace Exlo89\LaravelSevdeskApi\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SevCreditNote extends Model
{
    protected $fillable = [
        "id",
        "objectName",
        "additionalInformation",
        "creditNoteNumber",
        "contact",
        "create",
        "update",
        "creditNoteDate",
        "header",
        "headText",
        "footText",
        "timeToPay",
        "discountTime",
        "discount",
        "addressName",
        "addressStreet",
        "addressZip",
        "addressCity",
        "payDate",
        "createUser",
        "sevClient",
        "deliveryDate",
        "status",
        "smallSettlement",
        "contactPerson",
        "taxRate",
        "taxText",
        "addressParentName",
        "taxType",
        "sendDate",
        "creditNoteType",
        "accountIntervall",
        "accountLastCreditNote",
        "accountNextCreditNote",
        "reminderTotal",
        "reminderDebit",
        "reminderDeadline",
        "reminderCharge",
        "addressParentName2",
        "addressName2",
        "accountingType",
        "addressGender",
        "accountEndDate",
        "address",
        "currency",
        "sumNet",
        "sumTax",
        "sumGross",
        "sumDiscounts",
        "sumNetForeignCurrency",
        "sumTaxForeignCurrency",
        "sumGrossForeignCurrency",
        "sumDiscountsForeignCurrency",
        "sumNetAccounting",
        "sumTaxAccounting",
        "sumGrossAccounting",
        "customerInternalNote",
        "taxNumber",
        "vatNumber",
        "showNet",
        "enshrined",
        "sendType",
        "bookingCategory",
        "deliveryDateUntil",
        "isTransferred",
        "sumDiscountNet",
        "sumDiscountGross",
        "sumDiscountNetForeignCurrency",
        "sumDiscountGrossForeignCurrency",
    ];

    /**
     * @return BelongsTo
     */
    public function contact(): BelongsTo
    {
        return $this->belongsTo(SevContact::class);
    }
}
