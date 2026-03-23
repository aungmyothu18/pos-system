<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JewelryReceiveItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'jewelry_receive_id',
        'type',
        'kyat',
        'pae',
        'yway',
        'point',
        'color',
        'price',
        'remark',
    ];

    protected $casts = [
        'kyat' => 'decimal:2',
        'pae' => 'decimal:2',
        'yway' => 'decimal:2',
        'point' => 'decimal:2',
        'price' => 'decimal:2',
    ];

    public function jewelryReceive(): BelongsTo
    {
        return $this->belongsTo(JewelryReceive::class);
    }
}

