<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'partner_id', 'code', 'type', 'value', 'max_discount',
        'min_purchase', 'usage_limit', 'used_count', 'valid_until',
    ];

    protected $casts = [
        'valid_until' => 'date',
    ];

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function isValid(int $price): bool
    {
        if ($this->valid_until && now()->gt($this->valid_until->endOfDay())) {
            return false;
        }

        if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
            return false;
        }

        if ($this->min_purchase && $price < $this->min_purchase) {
            return false;
        }

        return true;
    }

    public function calculateDiscount(int $price): int
    {
        if ($this->type === 'percentage') {
            $discount = (int) round($price * ($this->value / 100));
            if ($this->max_discount) {
                $discount = min($discount, $this->max_discount);
            }
        } else {
            $discount = $this->value;
        }

        return min($discount, $price); // jaga-jaga, diskon tidak boleh lebih besar dari harga aslinya
    }
}