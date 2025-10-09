@extends('layout')

@section('content')
<div class="container">
    <h3>Pengaturan POS</h3>
    <form action="{{ route('settings.update', 1) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Diskon Global (%)</label>
            <input type="number" name="discount" class="form-control" value="{{ $settings->discount ?? 0 }}">
        </div>

        <div class="mb-3">
            <label>Pajak (%)</label>
            <input type="number" name="tax" class="form-control" value="{{ $settings->tax ?? 0 }}">
        </div>

        <div class="mb-3">
            <label>Service Charge (%)</label>
            <input type="number" name="service_charge" class="form-control" value="{{ $settings->service_charge ?? 0 }}">
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
