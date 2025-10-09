@extends('layout')

@section('content')
<h3>Tambah User</h3>

<form action="{{ route('users.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label>Nama User</label>
        <input type="text" name="name" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Role</label>
        <select name="role_id" class="form-control" required>
            <option value="">-- Pilih Role --</option>
            @foreach ($roles as $role)
                <option value="{{ $role->id }}">{{ $role->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <div class="alert alert-warning" role="alert">
            Password di set secara default menjadi password
        </div>
    </div>

    <button type="submit" class="btn btn-success">Simpan</button>
    <a href="{{ route('users.index') }}" class="btn btn-secondary">Kembali</a>
</form>
@endsection
