<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Peminjaman Barang</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            color: #333;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .info-table {
            width: 100%;
            margin-bottom: 20px;
        }

        .info-table td {
            padding: 5px;
            vertical-align: top;
        }

        .item-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .item-table th,
        .item-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .item-table th {
            background-color: #f2f2f2;
        }

        .signature-container {
            width: 100%;
            margin-top: 50px;
        }

        .signature-box {
            width: 45%;
            display: inline-block;
            text-align: center;
        }

        .signature-img {
            width: 150px;
            border-bottom: 1px solid #000;
            margin-bottom: 5px;
        }

        .footer {
            margin-top: 30px;
            font-size: 10px;
            text-align: center;
            color: #777;
        }
    </style>
</head>

<body>

    <div class="header">
        <h2 style="margin-bottom: 5px;">SMK WIKRAMA BOGOR</h2>
        <p style="margin: 0;">Jln. Wangun Tengah, Kel. Sindangsari, Kec. Bogor Timur, Kota Bogor</p>
        <h3 style="text-decoration: underline; margin-top: 15px;">BUKTI PEMINJAMAN BARANG</h3>
    </div>

    <table class="info-table">
        <tr>
            <td width="15%"><strong>Peminjam</strong></td>
            <td width="35%">: {{ $borrower }}</td>
            <td width="15%"><strong>Tanggal</strong></td>
            <td width="35%">: {{ \Carbon\Carbon::parse($date)->format('d F Y') }}</td>
        </tr>
        <tr>
            <td><strong>Staff PJ</strong></td>
            <td>: {{ $staff }}</td>
            <td><strong>Keterangan</strong></td>
            <td>: {{ $notes }}</td>
        </tr>
    </table>

    <table class="item-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Nama Barang</th>
                <th width="20%">Jumlah Dipinjam</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $index => $lending)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $lending->item->item_name ?? 'Barang tidak ditemukan' }}</td>
                    <td>{{ $lending->total_item }} Unit</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Cari bagian Tanda Tangan dan ganti menjadi sesimpel ini: -->

    <div class="signature-container">
        <div class="signature-box">
            <p>Tanda Tangan Staff</p>
            @if ($staff_sig)
                <!-- Variabel $staff_sig sudah berisi: data:image/png;base64,xxxxxxx -->
                <img src="{{ $staff_sig }}" class="signature-img">
            @else
                <div style="height: 80px; border-bottom: 1px solid #000;">(Tidak ada tanda tangan)</div>
            @endif
            <p>( {{ $staff }} )</p>
        </div>

        <div class="signature-box">
            <p>Tanda Tangan Peminjam</p>
            @if ($borrow_sig)
                <img src="{{ $borrow_sig }}" class="signature-img">
            @else
                <div style="height: 80px; border-bottom: 1px solid #000;">(Tidak ada tanda tangan)</div>
            @endif
            <p>( {{ $borrower }} )</p>
        </div>
    </div>

    <div class="footer">
        <p>Struk ini adalah bukti sah peminjaman inventaris SMK Wikrama Bogor.<br>
            Harap menjaga barang dengan baik dan mengembalikan tepat waktu.</p>
    </div>

</body>

</html>
