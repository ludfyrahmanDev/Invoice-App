@extends('layouts.auth')

@section('content')
<div class="row no-gutter">
    <!-- The image half -->
    <div class="col-md-6 col-lg-6 col-xl-7 d-none d-md-flex bg-primary-transparent" style="
    background: url('{{asset('assets/img/bg.jpg')}}') no-repeat center center;
    background-size: cover;
    background-repeat: none;">

    </div>
    <!-- The content half -->
    <div class="col-md-6 col-lg-6 col-xl-5 bg-white">
        <div class="login d-flex align-items-center py-2">
            <!-- Demo content-->
            <div class="container p-0">
                <div class="row">
                    <div class="col-md-10 col-lg-10 col-xl-9 mx-auto">
                        <div class="card-sigin">
                            <div class="mb-5 d-flex">
                                <a href="index.html"><img src="{{asset('assets/img/brand/favicon.png')}}" class="sign-favicon-a ht-40" alt="logo">
                                <img src="{{asset('assets/img/brand/favicon-white.png')}}" class="sign-favicon-b ht-40" alt="logo">
                                </a>
                                <h1 class="main-logo1 ms-1 me-0 my-auto tx-28">Invoice<span>A</span>PP</h1>
                            </div>
                            <div class="card-sigin">
                                <div class="main-signup-header">
                                    <h2>Selamat Data di Invoice App CV Sampurno Abadi</h2>
                                    <h5 class="fw-semibold mb-4">Please sign in to continue.</h5>
                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input class="form-control" name="email" @error('email') is-invalid @enderror placeholder="Enter your email" type="text" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-block">
                                            {{ __('Login') }}
                                        </button>

                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- End -->
        </div>
    </div><!-- End -->
</div>
@endsection
