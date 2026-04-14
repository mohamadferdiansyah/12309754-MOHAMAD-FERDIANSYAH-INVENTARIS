<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        return $this->hasMany(BorrowedItem::class);
    }
}
