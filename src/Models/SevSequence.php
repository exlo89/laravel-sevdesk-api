<?php
/*
 * SevSequence.php
 * @author Martin Appelmann <hello@martin-appelmann.de>
 * @copyright 2024 Martin Appelmann
 */

namespace Exlo89\LaravelSevdeskApi\Models;

use Illuminate\Database\Eloquent\Model;

class SevSequence extends Model
{
    protected $fillable = [
        'id',
        'objectName',
        'additionalInformation',
        'create',
        'update',
        'forObject',
        'format',
        'nextSequence',
        'type',
        'sevClient',
    ];

    protected $casts = [
        'create'    => 'datetime',
        'update'    => 'datetime',
        'sevClient' => 'array',
    ];
}
