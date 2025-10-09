@extends('layout')

@section('content')
<h3>Daftar Transaksi</h3>

<a href="{{ route('transactions.create') }}" class="btn btn-primary mb-3">Tambah Transaksi</a>

<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <th>Tanggal</th>
        <th>Nama Produk</th>
        <th>Metode Pembayaran</th>
        <th>Total</th>
    </tr>
    @foreach($transactions as $t)
    <tr>
        <td>{{ $t->id }}</td>
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
</table>
@endsection
