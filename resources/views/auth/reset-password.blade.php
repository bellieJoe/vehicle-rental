@extends('auth.layouts.master')
@section('content')
    <div class="d-flex justify-content-center my-5">
        <x-brand />
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
            <div class="card shadow-lg border-0 rounded-lg ">
                <div class="card-header"><h3 class="text-center font-weight-light my-4">Password Recovery</h3></div>
                <div class="card-body">
                    <x-alerts />
                    <form action="{{ route('password.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}" />

                        <div class="form-group">
                            <label class="small mb-1" for="email">Email</label>
                            <input class="form-control py-4 @error('email') is-invalid @enderror" id="email" type="email" placeholder="Enter email address" name="email" value="{{ old('email') }}" required />
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="small mb-1" for="password">Password</label>
                            <input class="form-control py-4 @error('password') is-invalid @enderror" id="password" type="password" placeholder="Enter new password" name="password" required />
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="small mb-1" for="password_confirmation">Confirm Password</label>
                            <input class="form-control py-4" id="password_confirmation" type="password" placeholder="Confirm new password" name="password_confirmation" required />
                        </div>
                        <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                            <button type="submit" class="btn btn-primary">Reset Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection