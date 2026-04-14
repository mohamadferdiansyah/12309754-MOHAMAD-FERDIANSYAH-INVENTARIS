<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BorrowedItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'staff_id',
        'item_id',
        'total_item',
        'name_of_borrower',
        'date',
        'notes',
    ];

    public function item()
    {
        return $this->belongsTo(ItemStock::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function returned()
    {
        return $this->hasMany(ReturnedItem::class);
    }
}
