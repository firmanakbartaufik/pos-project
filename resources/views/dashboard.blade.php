@extends('layout')
@section('content')
<h1>Dashboard POS</h1>
<p>Selamat datang <b>{{ Auth::user()->name }}</b> di aplikasi kasir sederhana.</p>
@endsection
