@extends('layouts.FrontendLayouts')
@section('frontend_content')

<!-- Start Checkout Area  -->
<div class="axil-checkout-area axil-section-gap">
    <div class="container">
        <form action="checkout.html#">
            <div class="row">
                <div class="col-lg-6">
                    <div class="axil-checkout-notice">
                        <div class="axil-toggle-box">
                            <div class="toggle-bar"><i class="fas fa-user"></i> Returning customer? <a
                                    href="javascript:void(0)" class="toggle-btn">Click here to login <i
                                        class="fas fa-angle-down"></i></a>
                            </div>
                            <div class="axil-checkout-login toggle-open">
                                <p>If you didn't Logged in, Please Log in first.</p>
                                <div class="signin-box">
                                    <form action="{{route('customer.sign-in')}}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" class="form-control" name="email">
                                        </div>
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input type="password" class="form-control" name="password">
                                        </div>
                                        <div class="form-group mb--0">
                                            <button type="submit" class="axil-btn btn-bg-primary submit-btn">Sign
                                                In</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="axil-toggle-box">
                            <div class="toggle-bar"><i class="fas fa-pencil"></i> Have a coupon? <a
                                    href="javascript:void(0)" class="toggle-btn">Click here to enter your code <i
                                        class="fas fa-angle-down"></i></a>
                            </div>

                            <div class="axil-checkout-coupon toggle-open">
                                <p>If you have a coupon code, please apply it below.</p>
                                <div class="input-group">
                                    <input placeholder="Enter coupon code" type="text">
                                    <div class="apply-btn">
                                        <button type="submit" class="axil-btn btn-bg-primary">Apply</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="axil-checkout-billing">
                        <h4 class="title mb--40">Billing details</h4>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Customer Name <span>*</span></label>
                                    <input type="text" id="name" placeholder="Adam"
                                        value="{{ auth('customer')->user()->name }}">
                                </div>
                            </div>

                        </div>

                        <div class="form-group">
                            <label>Country/ Region <span>*</span></label>
                            <select id="country">
                                <option value="bangladesh">Bangladesh</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Street Address <span>*</span></label>
                            <input type="text" value="{{ auth('customer')->user()->addr }}" id="address1" class="mb--15"
                                placeholder="House number and street name">
                            <input type="text" value="{{ auth('customer')->user()->addr2 }}" id="address2"
                                placeholder="Apartment, suite, unit, etc. (optonal)">
                        </div>
                        <div class="form-group">
                            <label>Town/ City <span>*</span></label>
                            <input type="text" id="city">
                        </div>

                        <div class="form-group">
                            <label>Phone <span>*</span></label>
                            <input type="tel" id="phone" value="{{ auth('customer')->user()->phone }}">
                        </div>
                        <div class="form-group">
                            <label>Email Address <span>*</span></label>
                            <input type="email" id="email" value="{{ auth('customer')->user()->email }}">
                        </div>


                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="axil-order-summery order-checkout-summery">
                        <h5 class="title mb--20">Your Order</h5>
                        <div class="summery-table-wrap">
                            <table class="table summery-table">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $deliveryFee = 100;
                                    $totalPrice = $deliveryFee + 0;
                                    @endphp
                                    @foreach($carts as $cart)
                                    @php
                                    $price = $cart->product->sale_price ?? $cart->product->price;
                                    $totalPrice += $price;
                                    @endphp
                                    <tr class="order-product">
                                        <td>{{ $cart->product->title }} <span class="quantity">x{{ $cart->qty }}</span>
                                        </td>
                                        <td>{{ number_format($price) }}</td>
                                    </tr>
                                    @endforeach


                                    <tr class="order-total">
                                        <td>Total</td>
                                        <td class="order-total-amount">{{ number_format($totalPrice) }} BDT</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="order-payment-method">
                            <div class="single-payment">
                                <div class="input-group">
                                    <input type="radio" id="radio4" name="payment">
                                    <label for="radio4">Direct bank transfer</label>
                                </div>
                                <p>Make your payment directly into our bank account. Please use your Order ID as the
                                    payment reference. Your order will not be shipped until the funds have cleared
                                    in our account.</p>
                            </div>
                            <div class="single-payment">
                                <div class="input-group">
                                    <input type="radio" id="radio5" name="payment">
                                    <label for="radio5">Cash on delivery</label>
                                </div>
                                <p>Pay with cash upon delivery.</p>
                            </div>
                            <div class="single-payment">
                                <div class="input-group justify-content-between align-items-center">
                                    <input type="radio" id="radio6" name="payment" checked>
                                    <label for="radio6">Paypal</label>
                                    <img src="{{asset('frontend/assets/images/others/payment.png')}}"
                                        alt="Paypal payment">
                                </div>
                                <p>Pay via PayPal; you can pay with your credit card if you don’t have a PayPal
                                    account.</p>
                            </div>
                        </div>
                        <button class="btn btn-primary btn-lg btn-block" id="sslczPayBtn"
                            token="if you have any token validation"
                            postdata="your javascript arrays or objects which requires in backend"
                            order="If you already have the transaction generated for current order"
                            endpoint="{{ url('/pay-via-ajax') }}"> Pay
                            Now
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- End Checkout Area  -->
@push('frontend_js')
<script>
    $('#sslczPayBtn').click(function(){
        var obj = {};
        obj.cus_name = $('#name').val();
        obj.cus_phone = $('#phone').val();
        obj.cus_email = $('#email').val();
        obj.cus_country = $('#country').val();
        obj.cus_city = $('#city').val();
        obj.cus_addr1 = $('#address1').val();
        obj.cus_addr2 = $('#address2').val();
        obj.amount = `{{ $totalPrice }}`;
        
        $('#sslczPayBtn').prop('postdata', obj);
    })
</script>
<script>
    (function (window, document) {
        var loader = function () {
            var script = document.createElement("script"), tag = document.getElementsByTagName("script")[0];
            script.src = "https://sandbox.sslcommerz.com/embed.min.js?" + Math.random().toString(36).substring(7);
            tag.parentNode.insertBefore(script, tag);
        };

        window.addEventListener ? window.addEventListener("load", loader, false) : window.attachEvent("onload", loader);
    })(window, document);
</script>
@endpush
@endsection