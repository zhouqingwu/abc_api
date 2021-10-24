<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

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

    /**
     * User Voucher Piovt
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_voucher', 'user_id', 'voucher_id')
            ->withPivot(['voucher_batch'])
            ->withTimestamps()
            ->as('user_voucher');
    }
}
