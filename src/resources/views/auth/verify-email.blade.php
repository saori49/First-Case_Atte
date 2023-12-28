@extends('layouts.app')

@section('content')
    <div>
        <div>
            @if (session('status') == 'verification-link-sent')
                <div>
                    A new verification link has been sent to the email address you provided during registration.
                </div>
            @endif

            <div>
                Before proceeding, please check your email for a verification link.
                If you did not receive the email,
                <form class="d-inline" method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit">click here to request another</button>.
                </form>
            </div>
        </div>

        <div>
            <form class="d-inline" method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">Log Out</button>
            </form>
        </div>
    </div>
@endsection