<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class jabatan extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
    ];

    public function pengurus()
    {
        return $this->hasMany(Pengurus::class);
    }
}
