<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $fillable = [
        'transaction_id', 'certificate_code', 'type', 'rank', 'sent_at',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}