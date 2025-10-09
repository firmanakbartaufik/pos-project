@extends('layout')
@section('content')
<h3>Daftar Produk</h3>
<a href="{{ route('products.create') }}" class="btn btn-primary mb-3">Tambah Produk</a>

<table class="table table-bordered">
    <tr>
        <th>Nama</th>
        <th>Harga</th>
        <th>Stok</th>
        <th>Diskon</th>
        <th>Aksi</th>
    </tr>
    @foreach($products as $p)
    <tr>
        <td>{{ $p->name }}</td>
        <td>Rp {{ number_format($p->price) }}</td>
        <td>{{ $p->stock }}</td>
        <td>{{ $p->discount }}</td>
        <td>
            <a href="{{ route('products.edit',$p->id) }}" class="btn btn-warning btn-sm">Edit</a>
            <form action="{{ route('products.destroy',$p->id) }}" method="POST" style="display:inline">
                @csrf @method('DELETE')
                <button class="btn btn-danger btn-sm">Hapus</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
@endsection
