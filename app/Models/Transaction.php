<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Transaction extends Model
{
    protected $fillable = [
        'customer_id',
        'invoice_number',
        'type',
        'status',
        'total_amount',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($transaction) {
            if (empty($transaction->customer_id)) {
                $transaction->customer_id = 'CUST-' . strtoupper(Str::random(8));
            }
            if (empty($transaction->invoice_number)) {
                $prefix = $transaction->type === 'Sale' ? 'SALE' : 'RECV';
                $transaction->invoice_number = $prefix . '-' . date('Ymd') . '-' . strtoupper(Str::random(6));
            }
        });
    }

    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }
}
