<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseTransaction extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'total_spent',
        'total_saving',
        'transaction_at',
    ];

    /**
      * The attributes that should be cast.
      *
      * @var array
      */
    protected $casts = [
        'transaction_at' => 'datetime',
    ];
}
