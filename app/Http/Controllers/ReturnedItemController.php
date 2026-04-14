<?php

namespace App\Http\Controllers;

use App\Models\BorrowedItem;
use App\Models\ItemStock;
use App\Models\ReturnedItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ReturnedItemController extends Controller
{
    public function returned(Request $request, BorrowedItem $item)
    {
        $request->validate([
            'good_condition' => 'required|integer|min:0',
            'broken' => 'required|integer|min:0',
            'missing' => 'required|integer|min:0',
        ]);

        // Pastikan total yang diinput sama dengan total yang dipinjam
        $totalInput = $request->good_condition + $request->broken + $request->missing;
        if ($totalInput != $item->total_item) {
            return back()->with('error', 'Total barang tidak sesuai dengan jumlah peminjaman.');
        }

        DB::transaction(function () use ($request, $item) {
            // 1. Catat Pengembalian
            ReturnedItem::create([
                'borrowed_item_id' => $item->id,
                'staff_id' => auth()->id(),
                'return_date' => now(),
                'good_condition' => $request->good_condition,
                'broken' => $request->broken,
                'missing' => $request->missing,
            ]);

            // 2. Update Stok di ItemStock
            $stock = $item->item;

            // Barang rusak menambah kolom total_repaired
            $stock->total_repaired += $request->broken;

            // Barang hilang mengurangi total_stock sistem secara permanen
            $stock->total_stock -= $request->missing;

            $stock->save();
        });

        return redirect()->route('lendings.index')->with('success', 'Item returned & stock updated.');
    }
}
