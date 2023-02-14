<?php
/*
 * SevContactAddress.php
 * @author Martin Appelmann <hello@martin-appelmann.de>
 * @copyright 2023 Martin Appelmann
 */

namespace Exlo89\LaravelSevdeskApi\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SevContactAddress extends Model
{
    protected $fillable = [
        "id",
        "objectName",
        "additionalInformation",
        "create",
        "update",
        "contact",
        "street",
        "zip",
        "city",
        "country",
        "name",
        "sevClient",
    ];

    /**
     * @return BelongsTo
     */
    public function contact(): BelongsTo
    {
        return $this->belongsTo(SevContact::class);
    }
}
