<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Harian</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        th { background: #eee; }
    </style>
</head>
<body>
    <h2>Laporan Harian Transaksi</h2>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Produk</th>
                <th>Metode</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $t)
            <tr>
                <td>{{ $t->created_at->format('d-m-Y H:i') }}</td>
                <td>
                    @foreach($t->products as $p)
                        • {{ $p->name }} (x{{ $p->pivot->quantity }})<br>
                    @endforeach
                </td>
                <td>{{ $t->payment_method }}</td>
                <td>Rp {{ number_format($t->total) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Total Pendapatan: Rp {{ number_format($total_harian) }}</h3>
</body>
</html>
