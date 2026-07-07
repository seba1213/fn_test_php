<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['short_link_id', 'ip_address', 'clicked_at'])]
class ShortLinkStatistic extends Model
{
    public $timestamps = false;

    protected $casts = [
        'clicked_at' => 'datetime',
    ];

    public function shortLink(): BelongsTo
    {
        return $this->belongsTo(ShortLink::class);
    }
}

