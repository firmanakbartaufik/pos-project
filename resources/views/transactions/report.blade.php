@extends('layout')

@section('content')
<h3>Laporan Harian</h3>

<a href="{{ route('transactions.report.pdf') }}" class="btn btn-danger mb-3" target="_blank">
    Download PDF
</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Produk</th>
            <th>Metode Pembayaran</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($transactions as $t)
        <tr>
            <td>{{ $t->created_at->format('d-m-Y H:i') }}</td>
            <td>
                @if($t->products->count())
                    <ul class="mb-0">
                        @foreach($t->products as $p)
                            <li>{{ $p->name }} (x{{ $p->pivot->quantity }})</li>
                        @endforeach
                    </ul>
                @else
                    <em>Tidak ada produk</em>
                @endif
            </td>
            <td>{{ $t->payment_method }}</td>
            <td>Rp {{ number_format($t->total) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<h4 class="mt-3">Total Pendapatan: Rp {{ number_format($total_harian) }}</h4>
@endsection
