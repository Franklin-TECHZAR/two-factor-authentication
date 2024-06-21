<!-- resources/views/2fa/verify.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Two-Factor Authentication (2FA) Verification</h2>
    <form method="POST" action="{{ route('2fa.postVerify') }}">
        @csrf
        <div class="form-group">
            <label for="verify-code">Authenticator Code</label>
            <input type="text" name="verify-code" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Verify</button>
    </form>
</div>
@endsection
