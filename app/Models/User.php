<?php

namespace App\Models;

use Carbon\Carbon;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'date_of_birth',
        'gender',
        'contact_number',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * User as many purchase transactions
     *
     * @return HasMany
     */
    public function purchaseTransactions(): HasMany
    {
        return $this->hasMany(PurchaseTransaction::class);
    }

    /**
     * User Voucher Pivot
     */
    public function vouchers()
    {
        return $this->belongsToMany(Voucher::class, 'user_voucher', 'user_id', 'voucher_id')
            ->withPivot(['voucher_batch'])
            ->withTimestamps()
            ->as('user_voucher');
    }

    /**
     * Check Customer if is elgible to particpate
     * Complete 3 purchase transactions with in the last 30 days
     * Total transactions equal or more than $100
     *
     * @param integer $days
     * @param integer $total
     * @param integer $totalAmount
     * @return boolean
     */
    public function isEligible(?int $days=30, ?float $total=3, ?int $totalAmount=100) //:bool
    {
        $cacheSencond = 600; // time for cache
        $transction = cache()->remember(
            'purchase_transaction_count_amount_user_'.$this->id,
            $cacheSencond,
            function () use ($days) {
                return DB::table('purchase_transactions')
                    ->selectRaw('user_id, count(*) as `total`, sum(total_spent) as `total_amount`')
                    ->whereUserId($this->id)
                    ->where('transaction_at', '>=', Carbon::today()->subDays($days))
                    ->groupBy('user_id')
                    ->first();
            }
        );

        return $transction?->total >= $total && $transction?->total_amount >= $totalAmount;
    }
}
