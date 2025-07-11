@extends('layouts.app')

@section('content')

<div class="container-xxl py-5 bg-dark hero-header mb-5">
    <div class="container text-center my-5 pt-5 pb-4">
        <h1 class="display-3 text-white mb-3 animated slideInDown">Checkout</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center text-uppercase">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Checkout</a></li>
            </ol>
        </nav>
    </div>
</div>

<div class="container">
                
    <div class="col-md-12 bg-dark">
        <div class="p-5 wow fadeInUp" data-wow-delay="0.2s">
            <h5 class="section-title ff-secondary text-start text-primary fw-normal">Reservation</h5>
            <h1 class="text-white mb-4">Checkout</h1>
            <form method="POST" action="{{route('foods.checkout.store')}}" class="col-md-12">
                @csrf
                <div class="row g-3">
                    <div class="col-md-12">
                        <div class="form-floating">
                            <input type="text" name="name" class="form-control" id="name" placeholder="Your Name">
                            <label for="name">Your Name</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="email" name="email" class="form-control" id="email" placeholder="Your Email">
                            <label for="email">Your Email</label>
                        </div>
                    </div>
                   
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" name="town" class="form-control" id="email" placeholder="Town">
                            <label for="email">Town</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" name="country" class="form-control" id="email" placeholder="Country">
                            <label for="text">Country</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" name="zipcode" class="form-control" id="email" placeholder="Zipcode">
                            <label for="text">Zipcode</label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-floating">
                            <input type="text" name="phonenumber" class="form-control" id="email" placeholder="Phone number">
                            <label for="text">Phone number</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-floating">
                            <textarea class="form-control" name="address" placeholder="Address" id="message" style="height: 100px"></textarea>
                            <label for="message">Address</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-floating">
                            <input type="text" name="price" value="{{ Session::get('price') }}" class="form-control" id="price" placeholder="Price">
                            <label for="price">Price</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-primary w-100 py-3" name="submit" type="submit">Order and Pay Now</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    </div>
</div>

@endsection