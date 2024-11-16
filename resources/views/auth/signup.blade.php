@extends('auth.layouts.master')
@section('content')
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="card mx-auto" style="width: 500px">
            <div class="card-body">
                <form action="" class="container-lg p-4" method="POST">
                    @csrf
                    <a href="{{ route('home') }}" class="text-center font-bold h3 mx-auto block">iRENTA HUB</a>

                    <h2 class="mb-2 h4 font-bold">Sign Up</h2>

                    <div class="mb-2">
                        <label for="" class="text-danger">*</label>
                        <label for="">Name</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="eg. John Doe" required>
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label for="" class="text-danger">*</label>
                        <label for="">Email</label>
                        <input type="text" class="form-control" name="email" value="{{ old('email') }}" placeholder="eg. john@example.com" required>
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label for="" class="text-danger">*</label>
                        <label for="">Address</label>
                        <input type="text" class="form-control" name="address" value="{{ old('address') }}" placeholder="eg. 123 Street Street" required>
                        @error('address')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label for="" class="text-danger">*</label>
                        <label for="">Password</label>
                        <input type="password" class="form-control" name="password" placeholder="Enter your password" required>
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label for="" class="text-danger">*</label>
                        <label for="">Password Confirmation</label>
                        <input type="password" class="form-control" name="password_confirmation" placeholder="Repeat your password" required>
                        @error('password_confirmation')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="" class="text-danger">*</label>
                        <label for="">Contact Number</label>
                        <input type="text" class="form-control" name="contact_number" value="{{ old('contact_number') }}" placeholder="eg. 09171234567" required>
                        @error('contact_number')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="ml-auto mr-0 d-flex justify-content-end">
                        <a href="{{ route('auth.signin') }}" class="btn btn-outline-primary ml-2">Sign In</a>
                        <button class="btn btn-primary ml-2" type="submit">Sign Up</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection