@extends('layouts.AuthLayout')
@section('frontend_content')


<div class="axil-signin-area">

    <!-- Start Header -->
    <div class="signin-header">
        <div class="row align-items-center">
            <div class="col-sm-4">
                <a href="index.html" class="site-logo"><img src="{{ asset('frontend/assets/images/logo/logo.png') }}" alt="logo"></a>
            </div>
            <div class="col-sm-8">
                <div class="singin-header-btn">
                    <p>Not a member?</p>
                    <a href="{{ route('customer.sign-up') }}" class="axil-btn btn-bg-secondary sign-up-btn">Sign Up Now</a>
                </div>
            </div>
        </div>
    </div>
    <!-- End Header -->

    <div class="row">
        <div class="col-xl-4 col-lg-6">
            <div class="axil-signin-banner bg_image bg_image--9">
                <h3 class="title">We Offer the Best Products</h3>
            </div>
        </div>
        <div class="col-lg-6 offset-xl-2">
            <div class="axil-signin-form-wrap">
                <div class="axil-signin-form">
                    <h3 class="title">Sign in to eTrade.</h3>
                    <p class="b2 mb--55">Enter your detail below</p>
                    <form action="{{ route('customer.sign-in') }}" method="POST" class="singin-form">
                        @csrf
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" name="password" >
                        </div>
                        <div class="form-group d-flex align-items-center justify-content-between">
                            <button type="submit" class="axil-btn btn-bg-primary submit-btn">Sign In</button>
                            <a href="forgot-password.html" class="forgot-btn">Forget password?</a>
                        </div>
                        <div class="social-login d-flex justify-content-between align-items-center">
                            <div>
                                <a class="badge-btn bg-light text-dark py-3" title="Continue with Google" href="{{ route('customer.google.signin') }}">Continue with<img width="50" src="{{ asset('frontend/assets/images/google-logo.webp') }}" alt=""></a>
                            </div>
                            <div>
                                <a class="badge-btn bg-light text-dark py-3 " title="Continue with Facebook" href="{{ route('customer.facebook.signin') }}">Continue with  <img width="30" src="{{ asset('frontend/assets/images/Facebook-logo-blue-large-size-WebP.webp') }}" alt=""></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection