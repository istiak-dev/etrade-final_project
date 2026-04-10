@extends('layouts.FrontendLayouts')
@section('title', 'Cartpage')
@section('frontend_content')

    <main class="main-wrapper">

        <!-- Start Cart Area  -->
        <div class="axil-product-cart-area axil-section-gap">
            <div class="container">
                <div class="axil-product-cart-wrap">
                    <div class="product-table-heading">
                        <h4 class="title">Your Cart</h4>
                        <a href="{{route('cart.delete-all')}}" class="cart-clear">Clear Shoping Cart</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table axil-product-table axil-cart-table mb--40">
                            <thead>
                                <tr>
                                    <th scope="col" class="product-remove"></th>
                                    <th scope="col" class="product-thumbnail">Product</th>
                                    <th scope="col" class="product-title"></th>
                                    <th scope="col" class="product-price">Price</th>
                                    <th scope="col" class="product-quantity">Quantity</th>
                                    <th scope="col" class="product-subtotal">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $subTotal = 0;
                                @endphp
                                <form id="cart-update" action="{{route('cart.update')}}" method="POST">
                                    @csrf
                                @forelse ($carts as $cart)
                                    <tr>
                                        <td class="product-remove"><a href="{{ route('cart.delete', $cart->id) }}"
                                                class="remove-wishlist"><i class="fal fa-times"></i></a></td>
                                        <td class="product-thumbnail"><a href="single-product.html"><img
                                                    src="{{ getImage($cart->product->image) }}" alt="Digital Product"></a>
                                        </td>
                                        <td class="product-title"><a
                                                href="single-product.html">{{ $cart->product->title }}</a></td>
                                        <td class="product-price" data-title="Price"><span
                                                class="currency-symbol">BDT</span>
                                            {{ number_format($cart->product->sale_price ?? cart->product->price, 2) }} </td>
                                        <td class="product-quantity" data-title="Qty">
                                            <input type="hidden" name="product_ids[]" value="{{ $cart->product->id }}">
                                            <div class="pro-qty">
                                                <input type="number" class="quantity-input" name="qty[]"
                                                    value="{{ $cart->qty }}">
                                            </div>
                                        </td>
                                        <td class="product-subtotal" data-title="Subtotal"><span
                                                class="currency-symbol">BDT</span>
                                            {{ number_format($cart->qty * ($cart->product->sale_price ?? cart->product->price), 2) }}
                                        </td>
                                    </tr>
                                    @php
                                        $subTotal += $cart->qty * ($cart->product->sale_price ?? cart->product->price);
                                    @endphp
                                    {{-- @dd($cart->product) --}}
                                @empty
                                    <tr>
                                        <td colspan="19" class="border-0">
                                            <div class="empty-state text-center pt-1">
                                                <div class="mb-1">
                                                    <i class="icon-base bx bx-package bx-lg text-secondary"></i>
                                                </div>

                                                <h5 class="text-muted fw-semibold mb-1">Cart is Empty!</h5>
                                                <p class="text-muted">It looks like you haven't added any products yet.
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                                </form>
                            </tbody>
                        </table>
                    </div>
                    <div class="cart-update-btn-area">
                        <div class="input-group product-cupon">
                            <input placeholder="Enter coupon code" type="text">
                            <div class="product-cupon-btn">
                                <button type="submit" class="axil-btn btn-outline">Apply</button>
                            </div>
                        </div>
                        <div class="update-btn {{ $carts->isEmpty() ? 'd-none' : '' }}">
                            <a class="axil-btn btn-outline" href="{{ route('cart.update') }}"
                                onclick="event.preventDefault(); document.querySelector('#cart-update').submit();">
                                Update Cart
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-5 col-lg-7 offset-xl-7 offset-lg-5">
                            <div class="axil-order-summery mt--80">
                                <h5 class="title mb--20">Order Summary</h5>
                                <div class="summery-table-wrap">
                                    <table class="table summery-table mb--30">
                                        <tbody>
                                            <tr class="order-subtotal">
                                                <td>Subtotal</td>
                                                <td>{{ number_format($subTotal, 2) }} BDT</td>
                                            </tr>
                                            <tr class="order-shipping">
                                                <td>Shipping</td>
                                                <td>
                                                    <div class="input-group">
                                                        <input type="radio" id="radio1" name="shipping" checked>
                                                        <label for="radio1">Free Shippping</label>
                                                    </div>
                                                    <div class="input-group">
                                                        <input type="radio" id="radio2" name="shipping">
                                                        <label for="radio2">Local: $35.00</label>
                                                    </div>
                                                    <div class="input-group">
                                                        <input type="radio" id="radio3" name="shipping">
                                                        <label for="radio3">Flat rate: $12.00</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="order-tax">
                                                <td>State Tax</td>
                                                <td>$8.00</td>
                                            </tr>
                                            <tr class="order-total">
                                                <td>Total</td>
                                                <td class="order-total-amount">$125.00</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <a href="{{route('checkout')}}" class="axil-btn btn-bg-primary checkout-btn">Process to Checkout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Cart Area  -->

    </main>

@endsection
