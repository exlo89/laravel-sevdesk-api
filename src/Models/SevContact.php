<?php
/*
 * SevContact.php
 * @author Martin Appelmann <hello@martin-appelmann.de>
 * @copyright 2023 Martin Appelmann
 */

namespace Exlo89\LaravelSevdeskApi\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SevContact extends Model
{
    protected $fillable = [
        'id',
        'objectName',
        'name',
        'surename',
        'familyname',
        'name2',
        'category',
        'defaultCashbackTime',
        'defaultCashbackPercent',
        'taxNumber',
        'excemptVat',
        'taxType',
        'taxSet',
        'defaultTimeToPay',
        'bankNumber',
        'birthday',
        'vatNumber',
        'defaultDiscountAmount',
        'defaultDiscountPercentage',
        'gender',
        'academicTitle',
        'description',
        'titel',
        'parent',
        'customerNumber',
        'bankAccount'
    ];

    protected $casts = [
        'defaultCashbackTime' => 'integer',
        'defaultCashbackPercent' => 'double',
        'excemptVat' => 'boolean',
        'taxSet' => 'integer',
        'defaultTimeToPay' => 'integer',
        'bankNumber' => 'integer',
        'birthday' => 'timestamp',
        'defaultDiscountAmount' => 'double',
        'defaultDiscountPercentage' => 'boolean'
    ];

    /**
     * @return HasOne
     */
    public function accountingContact(): HasOne
    {
        return $this->hasOne(SevAccountingContact::class);
    }
}
