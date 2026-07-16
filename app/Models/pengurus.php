<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pengurus extends Model
{
    public $timestamps = false;
    protected $table = 'pengurus';

    protected $fillable = [
        'jabatan_id',
        'name',
        'description',
        'salary',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
    ];

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }
}
