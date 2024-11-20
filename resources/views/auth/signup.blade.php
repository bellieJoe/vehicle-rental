@extends('auth.layouts.master')
@section('content')
    <div class="d-flex justify-content-center my-5">
        <x-brand />
    </div>
    <div class="card o-hidden border-0 shadow-lg my-5 tw-max-w-md mx-auto">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="">
                <div class="p-5">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                    </div>
                    <form class="user" action="{{ route('auth.register-client') }}" method="POST">
                        @csrf
                        <div class="form-group ">
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control form-control-user" placeholder="Full Name">
                            @error('name')
                            asd
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control form-control-user" name="email" value="{{ old('email') }}" placeholder="Email Address">
                            @error('email', 'org_register')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="password" class="form-control form-control-user" name="password" placeholder="Password">
                                @error('password', 'org_register')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-6">
                                <input type="password" class="form-control form-control-user" name="password_confirmation" placeholder="Repeat Password">
                                @error('password_confirmation', 'org_register')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mb-3 btn-user btn-block">
                            Register Account
                        </button>
                        
                    </form>
                    <hr>
                    <div class="text-center">
                        <a class="small" href="forgot-password.html">Forgot Password?</a>
                    </div>
                    <div class="text-center">
                        <a class="small" href="{{ route('auth.signin') }}">Already have an account? Sign In!</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection