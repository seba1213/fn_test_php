<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

#[Fillable(['user_id', 'code', 'original_url'])]
class ShortLink extends Model
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function statistics(): HasMany
    {
        return $this->hasMany(ShortLinkStatistic::class);
    }

    public static function generateCode(int $id): string
    {
        return self::base36Encode($id + 10000);
    }

    private static function base36Encode(int $number): string
    {
        if ($number < 0) {
            throw new \InvalidArgumentException('Number must be non-negative.');
        }

        return base_convert((string) $number, 10, 36);
    }

    public static function createForUser(int $userId, string $originalUrl): self
    {
        return DB::transaction(function () use ($userId, $originalUrl): self {
            $shortLink = self::create([
                'user_id' => $userId,
                'original_url' => $originalUrl,
                'code' => Str::random(16),
            ]);

            $shortLink->update([
                'code' => self::generateCode($shortLink->id),
            ]);

            return $shortLink->refresh();
        });
    }
}
