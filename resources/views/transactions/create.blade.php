@extends('layout')

@section('content')
<h3>Buat Transaksi Baru</h3>

<form action="{{ route('transactions.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label>Metode Pembayaran</label>
        <select name="payment_method" class="form-control" required>
            <option value="tunai">Tunai</option>
            <option value="non-tunai">Non Tunai</option>
        </select>
    </div>

    <h5>Tambah Item</h5>
    <table class="table table-bordered" id="itemsTable">
        <thead>
            <tr>
                <th>Produk</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Subtotal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

    <button type="button" class="btn btn-primary mb-3" id="addRow">+ Tambah Item</button>

    <div class="mb-3">
        <h5>Total: Rp <span id="grandTotal">0</span></h5>
    </div>

    <button type="submit" class="btn btn-success">Simpan Transaksi</button>
    <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Kembali</a>
</form>

<script>
    const products = @json($products);
    let rowCount = 0;

    document.getElementById('addRow').addEventListener('click', function() {
        const table = document.querySelector('#itemsTable tbody');
        const row = document.createElement('tr');
        const options = products.map(p => `<option value="${p.id}" data-price="${p.price}">${p.name}</option>`).join('');

        row.innerHTML = `
            <td><select name="items[${rowCount}][product_id]" class="form-select product-select">${options}</select></td>
            <td><input type="number" name="items[${rowCount}][quantity]" class="form-control qty" value="1" min="1"></td>
            <td><input type="text" class="form-control price" readonly></td>
            <td><input type="text" class="form-control subtotal" readonly></td>
            <td><button type="button" class="btn btn-danger btn-sm removeRow">Hapus</button></td>
        `;
        table.appendChild(row);
        updatePrices();
        rowCount++;
    });

    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('product-select') || e.target.classList.contains('qty')) {
            updatePrices();
        }
    });

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('removeRow')) {
            e.target.closest('tr').remove();
            updateTotal();
        }
    });

    function updatePrices() {
        document.querySelectorAll('#itemsTable tbody tr').forEach(row => {
            const select = row.querySelector('.product-select');
            const qty = row.querySelector('.qty').value;
            const price = select.selectedOptions[0].getAttribute('data-price');
            const subtotal = price * qty;
            row.querySelector('.price').value = price;
            row.querySelector('.subtotal').value = subtotal;
        });
        updateTotal();
    }

    function updateTotal() {
        let total = 0;
        document.querySelectorAll('.subtotal').forEach(s => total += parseFloat(s.value || 0));
        document.getElementById('grandTotal').innerText = total.toLocaleString();
    }
</script>
@endsection
