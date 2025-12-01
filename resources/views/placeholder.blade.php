@extends('layouts.app')

@section('title', 'Page Under Construction')

@section('content')
<div class="alert alert-warning" role="alert">
    <h4 class="alert-heading">Under Construction</h4>
    <p>Halaman ini sedang dalam pengembangan.</p>
    <hr>
    <p class="mb-0">Silakan kembali ke <a href="{{ url('/') }}">Dashboard</a>.</p>
</div>
@endsection
