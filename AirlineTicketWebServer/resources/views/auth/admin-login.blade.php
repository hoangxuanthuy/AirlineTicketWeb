
@extends('layouts.app')

@section('content')
<div class="container">
    <form method="POST" action="{{ route('admin.login') }}">
        @csrf
        <div class="form-group">
            <label for="email">Admin Email</label>
            <input type="email" class="form-control" name="email" required autofocus>
        </div>
        <div class="form-group">
            <label for="password">Admin Password</label>
            <input type="password" class="form-control" name="password" required>
        </div>
        <div class="form-group">
            <input type="checkbox" name="remember"> Remember Me
        </div>
        <button type="submit" class="btn btn-primary">Login as Admin</button>
    </form>
</div>
@endsection