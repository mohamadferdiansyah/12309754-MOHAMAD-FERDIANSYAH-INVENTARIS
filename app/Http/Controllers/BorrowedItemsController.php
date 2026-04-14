<?php

namespace App\Http\Controllers;

use App\Exports\LendingsExport;
use App\Models\BorrowedItem;
use App\Models\ItemStock;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

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
            $query->where('item_id', $request->item_id);
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
        $items = ItemStock::query()
            ->with('lendings')
            ->orderBy('item_name')
            ->get();

        return view('lendings.create', compact('items'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. VALIDASI DATA
        $validated = $request->validate([
            'staff_signature'    => 'required',
            'borrower_signature' => 'required',
            'borrower_name'      => ['required', 'string', 'max:150'],
            'date'               => ['nullable', 'date'],
            'description'        => ['nullable', 'string'],
            'items'              => ['required', 'array', 'min:1'],
            'items.*.item_id'    => ['required', 'exists:item_stocks,id'],
            'items.*.qty'        => ['required', 'integer', 'min:1'],
        ]);

        // 2. CEK KETERSEDIAAN STOK
        $grouped = collect($validated['items'])
            ->groupBy('item_id')
            ->map(fn($rows) => $rows->sum('qty'));

        $items = ItemStock::query()
            ->whereIn('id', $grouped->keys())
            ->get()
            ->keyBy('id');

        foreach ($grouped as $itemId => $totalQty) {
            $item = $items[$itemId];
            if ($totalQty > $item->available) {
                return back()
                    ->withInput()
                    ->with('error', "Stok barang '{$item->item_name}' tidak mencukupi.");
            }
        }

        // 3. SIMPAN TANDA TANGAN KE STORAGE
        $staffSigPath = $this->uploadSignature($validated['staff_signature'], 'staff');
        $borrowerSigPath = $this->uploadSignature($validated['borrower_signature'], 'borrower');

        $createdLendings = [];

        // 4. DATABASE TRANSACTION
        DB::transaction(function () use ($validated, $staffSigPath, $borrowerSigPath, &$createdLendings) {
            foreach ($validated['items'] as $row) {
                $lending = BorrowedItem::create([
                    'item_id'            => $row['item_id'],
                    'staff_id'           => auth()->id(),
                    'name_of_borrower'   => $validated['borrower_name'],
                    'total_item'         => $row['qty'],
                    'notes'              => $validated['description'] ?? null,
                    'date'               => $validated['date'] ?? now(),
                    'staff_signature'    => $staffSigPath,
                    'borrower_signature' => $borrowerSigPath,
                ]);

                $createdLendings[] = BorrowedItem::with('item', 'user')->find($lending->id);
            }
        });

        $pdfData = [
            'borrower'   => $validated['borrower_name'],
            'date'       => $validated['date'] ?? now(),
            'notes'      => $validated['description'] ?? '-',
            'staff'      => auth()->user()->name,
            'items'      => $createdLendings,
            // Gunakan helper imageToBase64 langsung di sini
            'staff_sig'  => $this->imageToBase64($staffSigPath),
            'borrow_sig' => $this->imageToBase64($borrowerSigPath),
        ];

        $pdf = Pdf::loadView('lendings.pdf', $pdfData);
        $pdfName = 'Lending-' . Str::random(10) . '.pdf';
        Storage::put('public/receipts/' . $pdfName, $pdf->output());

        return redirect()
            ->route('lendings.index')
            ->with('success', 'Peminjaman berhasil dicatat.')
            ->with('pdf_url', asset('storage/receipts/' . $pdfName));
    }

    private function getFileName($path)
    {
        if (!$path) return null;

        return basename($path); // ambil: staff-xxxx.png
    }


    /**
     * Helper untuk memproses base64 signature menjadi file gambar
     */
    private function uploadSignature($base64String, $subfolder)
    {
        // Validasi apakah string base64 valid
        if (!$base64String || !str_contains($base64String, ';base64,')) {
            return null;
        }

        $image_parts = explode(";base64,", $base64String);
        $image_base64 = base64_decode($image_parts[1]);

        $filename = $subfolder . '-' . Str::random(10) . '.png';
        $path = 'signatures/' . $subfolder . '/' . $filename;

        // Simpan ke disk public (storage/app/public/signatures/...)
        Storage::disk('public')->put($path, $image_base64);

        return $path;
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
    public function destroy(BorrowedItem $item)
    {
        $isReturned = $item->returned ? true : false;

        DB::transaction(function () use ($item) {

            if ($item->returned) {
                $item->returned->delete();
            }

            $item->delete();
        });

        $message = !$isReturned
            ? 'Lending deleted. Item available has been restored.'
            : 'Lending and return history deleted successfully.';

        return redirect()
            ->route('lendings.index')
            ->with('success', $message);
    }

    public function exportExcel(Request $request)
    {
        $fromDate = $request->from_date;
        $toDate = $request->to_date;

        $fileName = 'lendings';
        if ($fromDate && $toDate) {
            $fileName .= '_' . $fromDate . '_to_' . $toDate;
        }
        $fileName .= '.xlsx';

        return Excel::download(new LendingsExport($fromDate, $toDate), $fileName);
    }

    public function downloadReceipt($id)
    {
        $lending = BorrowedItem::with(['item', 'user'])->findOrFail($id);

        $pdfData = [
            'borrower'   => $lending->name_of_borrower,
            'date'       => $lending->date,
            'notes'      => $lending->notes ?? '-',
            'staff'      => $lending->user->name,
            'items'      => [$lending],
            // Ambil path lengkap dari DB dan ubah ke Base64
            'staff_sig'  => $this->imageToBase64($lending->staff_signature),
            'borrow_sig' => $this->imageToBase64($lending->borrower_signature),
        ];

        $pdf = Pdf::loadView('lendings.pdf', $pdfData);
        return $pdf->stream('Receipt-' . $lending->name_of_borrower . '.pdf');
    }

    private function imageToBase64($path)
    {
        if (!$path || !Storage::disk('public')->exists($path)) {
            return null;
        }

        $file = Storage::disk('public')->get($path);
        $type = pathinfo($path, PATHINFO_EXTENSION);

        return 'data:image/' . $type . ';base64,' . base64_encode($file);
    }
}
