@extends('auth.layouts.master')
@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-danger text-center">
                <div class="card-header bg-danger text-white">
                    <h4 class="card-title">Account Banned</h4>
                </div>
                <div class="card-body">
                    <p class="card-text">Your account has been banned. If you think this is a mistake, please contact the administrator at <a href="mailto:admin@gmail.com" class="text-primary">admin@gmail.com</a> for more information.</p>
                </div>
                <div class="card-footer bg-transparent border-danger">
                    <p class="mb-0">Thank you for using our service.</p>
                    <form action="{{ route('auth.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger">Logout Account</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection