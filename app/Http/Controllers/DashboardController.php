<?php

namespace App\Http\Controllers;

use App\Models\BorrowedItem;
use App\Models\ItemCategory;
use App\Models\ItemStock;
use App\Models\ReturnedItem;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data = [];

        if ($user->role === 'admin') {
            $data['total_categories'] = ItemCategory::count();
            $data['total_items'] = ItemStock::count();
            $data['total_stock_all'] = ItemStock::sum('total_stock');
        } else {
            $data['total_borrowed'] = BorrowedItem::count();
            $data['total_returned'] = ReturnedItem::count();

            $data['active_borrowing'] = BorrowedItem::whereDoesntHave('returned')->count();
            $data['total_items_available'] = ItemStock::count();
        }

        return view('dashboard.index', $data);
    }
}
