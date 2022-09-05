@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <div class="row no-gutters">
        <div class="col-lg-12">
            <div class="authentication-page-content p-4 d-flex align-items-center min-vh-100">
                <div class="w-100">
                    <div class="row justify-content-center">
                        <div class="col-lg-4">
                            <div>
                                <div class="text-center mb-4">
                                    <div class="text-center">
                                        {{-- <h1 class="logo-name"></h1> --}}
                                        <img src="{{ asset('img/landing/logo.svg') }}" width="200">
                                        <h3>MUST ACCOMMODATION SYSTEM</h3>
                                    </div>

                                </div>

                                <div class="p-2 mt-2">
                                    <form class="form-horizontal"  method="POST" action="{{ route('login') }}">
                                        @csrf

                                        <div class="form-group auth-form-group-custom mb-2">
                                            <i class="ri-user-2-line auti-custom-input-icon"></i>
                                            <label for="email">E-Mail Address</label>
                                            <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Enter email" value="{{ old('email') }}" name="email">

                                            @error('email')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="form-group auth-form-group-custom mb-4">
                                            <i class="ri-lock-2-line auti-custom-input-icon"></i>
                                            <label for="userpassword">{{ __('Password') }}</label>
                                            <input type="password" class="form-control" id="userpassword" placeholder="Enter password" name="password">
                                        </div>

                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="remember" class="custom-control-input" id="customControlInline">
                                            <label class="custom-control-label" for="customControlInline">Remember me</label>
                                        </div>

                                        <div class="mt-2 text-center">
                                            <button class="btn btn-block btn-primary w-md waves-effect waves-light" type="submit">{{ __('Login') }}</button>
                                        </div>

                                        <div class="mt-2 text-center">
                                            <a href="{{ route('apply') }}" class="btn btn-block btn-warning w-md waves-effect waves-light">Apply Here for Students</a>
                                        </div>



                                        @if (Route::has('password.request'))
                                            <div class="mt-4 text-center">
                                                <a href="{{ route('password.request') }}" class="text-muted"><i class="mdi mdi-lock mr-1"></i> {{ __('Forgot your password?') }}</a>
                                            </div>
                                        @endif
                                    </form>
                                </div>

                                <div class="mt-5 text-center">
                                    <p>© {{ now()->year }} MUST{{-- . Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesdesign</p> --}}
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
