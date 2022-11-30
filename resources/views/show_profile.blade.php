{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detail User</title>
</head>
<body>
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    @endif
    <p>Name : {{ $user->name }}</p>
    <p>Email : {{ $user->email }}</p>
    <p>Role : {{ $user->is_admin ? 'Admin' : 'Member' }}</p>
    <form action="{{ route('edit_profile') }}" method="post">
        @csrf
        <label for="name">Name :</label>
        <input type="text" name="name" id="name" value="{{ $user->name }}">
        <br>
        <label for="password">Password</label>
        <input type="password" name="password" id="password">
        <br>
        <label for="password_confirmation">Password Confirmation</label>
        <input type="password" name="password_confirmation" id="password_confirmation">
        <br>
        <button type="submit">Edit Profile</button>
    </form>
</body>
</html> --}}
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        {{ __('Profile') }}
                    </div>
                    <div class="card-body">
                        @if ($errors->any)
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        @endif
                        <form action="{{ route('edit_profile') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="">Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Name" value="{{ $user->name }}">
                            </div>
                            <div class="form-group">
                                <label for="">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Email" value="{{ $user->email }}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="">Role</label>
                                <input type="role" class="form-control" disabled value="{{ $user->is_admin ? 'Admin' : 'Member' }}">
                            </div>
                            <div class="form-group">
                                <label for="">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Password">
                            </div>
                            <div class="form-group">
                                <label for="">Password Confirmation</label>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Password Confirmation">
                            </div>
                            <button type="submit" class="btn btn-primary mt-3">Change Profile Details</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection