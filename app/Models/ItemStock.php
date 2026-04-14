<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class ItemStock extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'item_name',
        'total_stock',
        'total_repaired',
        'total_borrowed'
    ];

    public function category()
    {
        return $this->belongsTo(ItemCategory::class);
    }

    public function lendings()
    {
        return $this->hasMany(BorrowedItem::class, 'item_id');
    }

    public function returnedItems()
    {
        return $this->hasManyThrough(
            ReturnedItem::class,
            BorrowedItem::class,
            'item_id',
            'borrowed_item_id',
            'id',
            'id'
        );
    }

    public function borrowedQty(): Attribute
    {
        return Attribute::make(
            get: fn() => (int) $this->lendings()
                ->whereDoesntHave('returned')
                ->sum('total_item')
        );
    }

    public function available(): Attribute
    {
        return Attribute::make(
            get: fn() =>
            max(
                0,
                (int)$this->total_stock
                    - (int)$this->total_repaired
                    - (int)$this->borrowed_qty
            )
        );
    }

    public function totalBorrowed(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->lendings()->count()
        );
    }
}
