@extends('layout')

@section('content')
<h3>Edit User</h3>

<form action="{{ route('users.update', $user->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Nama User</label>
        <input type="text" name="name" value="{{ $user->name }}" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" value="{{ $user->email }}" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Role User</label>
        <select name="role_id" class="form-control" required>
            <option value="">-- Pilih Role --</option>
            @foreach ($roles as $role)
                <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                    {{ $role->name }}
                </option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-success">Update</button>
    <a href="{{ route('users.index') }}" class="btn btn-secondary">Kembali</a>
</form>
@endsection
