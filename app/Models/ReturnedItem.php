<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnedItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'staff_id',
        'borrowed_item_id',
        'return_date',
        'notes',
        'good_condition',
        'broken',
        'missing'
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function borrowedItem()
    {
        return $this->belongsTo(ItemStock::class);
    }
}
