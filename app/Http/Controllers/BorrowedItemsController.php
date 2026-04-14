<?php

namespace App\Http\Controllers;

use App\Models\BorrowedItem;
use Illuminate\Http\Request;

class BorrowedItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = BorrowedItem::query()
            ->with(['item', 'user', 'returned'])
            ->orderBy('date', 'desc');

        if ($request->filled('item_id')) {
            $query->where('item_id', $request->item_id)->where('status', 'borrowed');
        }

        $lendings = $query->get();

        $isDetail = $request->filled('item_id');

        return view('lendings.index', compact('lendings', 'isDetail'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
