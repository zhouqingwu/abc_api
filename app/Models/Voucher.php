<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'batch',
        'stock',
        'amount',
        'code',
        'started_at',
        'expired_at',
        'info',
    ];

   /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'started_at' => 'datetime',
        'expired_at' => 'datetime',
    ];
}
