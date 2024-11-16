@extends('auth.layouts.master')
@section('content')
    {{-- <div class="container-lg">
        <div class="d-flex justify-content-center align-items-center vh-100">
            <div class="card mx-auto" style="width: 500px">
                <div class="card-body p-5">
                    <form action="{{ route('auth.try') }}" class="mx-auto " method="POST">
                        @csrf
                        <a href="{{ route('home') }}" class="text-center font-bold h3 mx-auto block">iRENTA HUB</a>

                        <h2 class="mb-2 h4 font-bold">Sign In</h2>

                        <div class="mb-3">
                            <label for="" class="text-danger">*</label>
                            <label for="">Email</label>
                            <input placeholder="Enter email" type="email" class="form-control" name="email" required value="{{ old('email') }}">
                            @error('email')
                                    <span class="text-danger">{{ $message }}</span><br>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="" class="text-danger">*</label>
                            <label for="">Password</label>
                            <input placeholder="Enter password" type="password" class="form-control" name="password" required>
                            @error('password')
                                    <span class="text-danger">{{ $message }}</span><br>
                            @enderror
                        </div>

                        @error('invalid-credentials')
                                <span class="text-danger">{{ $message }}</span><br>
                        @enderror
                        <br>
                        
                        <div class="ml-auto mr-0 d-flex justify-content-end ">
                            <a href="{{ route('auth.signup') }}" class="btn btn-outline-primary" type="submit">Sign Up</a>
                            <button  class="btn btn-primary ml-2" type="submit">Sign In</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                <div class="col-lg-6">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                        </div>
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
                            
                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                Login
                            </button>
                        </form>
                        <hr>
                        <div class="text-center">
                            <a class="small" href="forgot-password.html">Forgot Password?</a>
                        </div>
                        <div class="text-center">
                            <a class="small" href="{{ route('auth.signup') }}">Create an Account!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection