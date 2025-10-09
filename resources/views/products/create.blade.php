@extends('layout')

@section('content')
<h3>Tambah Produk</h3>

<form action="{{ route('products.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label>Nama Produk</label>
        <input type="text" name="name" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Harga</label>
        <input type="number" name="price" class="form-control" step="0.01" required>
    </div>

    <div class="mb-3">
        <label>Diskon (%)</label>
        <input type="number" name="discount" class="form-control" value="0" min="0" max="100" step="0.01">
    </div>

    <div class="mb-3">
        <label>Stok</label>
        <input type="number" name="stock" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-success">Simpan</button>
    <a href="{{ route('products.index') }}" class="btn btn-secondary">Kembali</a>
</form>
@endsection
