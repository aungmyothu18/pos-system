<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JewelryReceive extends Model
{
    use HasFactory;

    protected $fillable = [
        'receive_date',
        'customer_name',
        'customer_phone',
        'overall_note',
        'total_items',
        'total_value',
        'status',
    ];

    protected $casts = [
        'receive_date' => 'date',
        'total_items' => 'integer',
        'total_value' => 'decimal:2',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(JewelryReceiveItem::class);
    }
}

