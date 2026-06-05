<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['name', 'image', 'price', 'available_quantity', 'vendor_id', 'condition'])]
class Vegetable extends Model
{
    use HasFactory;

    protected $casts = [
        'image' => 'array',
        'available_quantity' => 'decimal:2',
    ];

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    public function firstImage(): Attribute
    {
        return Attribute::get(fn () => $this->image[0] ?? null);
    }

    public function allImages(): Attribute
    {
        return Attribute::get(fn () => $this->image ?? []);
    }
}
