@extends('auth.layouts.master')
@section('content')

<div class="card o-hidden border-0 shadow-lg my-5 tw-max-w-md mx-auto">

    <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="">
            <div class="p-5">
                @if (session('message'))
                    <div class="alert alert-success mb-4" role="alert">
                        {{ session('message') }}
                    </div>
                @endif
                <div class="text-center">
                    <a href="{{ route('home') }}" class="block h3 text-gray-900 mb-4 font-bold">iRENTA HUB</a>
                </div>
                <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Verify Account</h1>
                    <p class="mb-4">To enjoy the full experience of the app, you need to verify your account. Please check your email inbox and follow the instructions to verify your account. If you didn't receive the email, click on the button below to resend the verification email.</p>
                </div>
                <form class="user" action="{{ route('verification.send') }}"  method="POST">
                    @csrf
                    
                    <button type="submit" class="btn btn-primary btn-user btn-block">
                        Resend Verification
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection