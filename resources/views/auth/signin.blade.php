@extends('auth.layouts.master')
@section('content')
    <div class="d-flex justify-content-center my-5">
        <x-brand />
    </div>
    <div class="card o-hidden border-0 shadow-lg my-5 tw-max-w-md mx-auto">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="">
                {{-- <div class="col-lg-6 d-none d-lg-block bg-login-image"></div> --}}
                <div class="p-5">
                    <div class="text-center">
                        <h1 class="h4 tw-text-gray-800 mb-4">Welcome Back!</h1>
                    </div>
                    <x-alerts />
                    <form class="user" action="{{ route('auth.try') }}"  method="POST">
                        @csrf
                        <div class="form-group">
                            <input name="email" value="{{ old('email') }}" type="email" class="form-control form-control-user"
                                id="exampleInputEmail" aria-describedby="emailHelp"
                                placeholder="Enter Email Address...">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span><br>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input name="password" type="password" class="form-control form-control-user"
                                id="password" placeholder="Password">
                            @error('password')
                                <span class="text-danger">{{ $message }}</span><br>
                            @enderror
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-user btn-block mb-3">
                            Login
                        </button>
                    </form>
                    <hr>
                    <div class="text-center">
                        <a class="small" href="{{ route('password.request') }}">Forgot Password?</a>
                    </div>
                    <div class="text-center">
                        <a class="small" href="{{ route('auth.signup') }}">Create an Account!</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection