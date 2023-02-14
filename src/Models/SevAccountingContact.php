<?php
/*
 * SevAccountingContact.php
 * @author Martin Appelmann <hello@martin-appelmann.de>
 * @copyright 2023 Martin Appelmann
 */

namespace Exlo89\LaravelSevdeskApi\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SevAccountingContact extends Model
{
    protected $fillable = [
        'id',
        'objectName',
        'additionalInformation',
        'create',
        'update',
        'contact',
        'contactName',
        'sevClient',
        'debitorNumber',
        'creditorNumber'
    ];

    /**
     * @return BelongsTo
     */
    public function contact(): BelongsTo
    {
        return $this->belongsTo(SevContact::class);
    }
}
