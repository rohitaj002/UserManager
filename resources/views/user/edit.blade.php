<!-- resources/views/users/edit.blade.php -->

@extends('layouts.app')

@section('content')
    <h1>Edit User</h1>

    <form method="POST" action="{{ route('users.update', ['user' => $user->id]) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div>
            <label for="first_name">First Name</label>
            <input type="text" name="first_name" id="first_name" value="{{ $user->first_name }}" required>
        </div>

        <div>
            <label for="last_name">Last Name</label>
            <input type="text" name="last_name" id="last_name" value="{{ $user->last_name }}" required>
        </div>

        <div>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="{{ $user->email }}" required>
        </div>

        <div>
            <label for="phone">Phone</label>
            <input type="text" name="phone" id="phone" value="{{ $user->phone }}" required>
        </div>

        <div>
            <label for="image">User Avatar</label>
            <input type="file" name="image" id="image">
        </div>

        <div>
            <img src="{{ asset('images/' . $user->image) }}" alt="{{ $user->full_name }}" width="100">
        </div>

        <button type="submit">Update</button>
    </form>
@endsection
