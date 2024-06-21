<!-- resources/views/2fa/setup.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Two-Factor Authentication (2FA)</h2>
    <p>Set up your two-factor authentication by scanning the QR code below. You can use Google Authenticator or any other 2FA app.</p>
    <div>
        {!! $QR_Image !!}
    </div>
    <p>Secret: {{ $secret }}</p>
    <form method="POST" action="{{ route('2fa.enable') }}">
        @csrf
        <div class="form-group">
            <label for="verify-code">Authenticator Code</label>
            <input type="text" name="verify-code" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Enable 2FA</button>
    </form>
</div>
@endsection
