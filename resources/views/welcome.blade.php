<!-- resources/views/welcome.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Welcome to My Laravel Project</h1>
    <p><a href="{{ route('users.create') }}">Register a User</a></p>
@endsection
