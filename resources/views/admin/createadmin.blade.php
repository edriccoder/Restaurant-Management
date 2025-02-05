@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <div class="container">
                    @if(Session::has('success'))
                        <p class="alert alert-success">{{ Session::get('success') }}</p>
                    @endif
                    @if(Session::has('error'))
                        <p class="alert alert-danger">{{ Session::get('error') }}</p>
                    @endif
                </div>
                <h5 class="card-title mb-5 d-inline">Create Admins</h5>
                <form method="POST" action="{{route('admin.store')}}" enctype="multipart/form-data">
                    @csrf
                    <!-- Email input -->
                    <div class="form-outline mb-4 mt-4">
                        <input type="email" name="email" id="form2Example1"
                            class="form-control @error('name') is-invalid @enderror" placeholder="email" />
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-outline mb-4">
                        <input type="text" name="name" id="form2Example1"
                            class="form-control @error('email') is-invalid @enderror" placeholder="name" />
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-outline mb-4">
                        <input type="password" name="password" id="form2Example1"
                            class="form-control @error('password') is-invalid @enderror" placeholder="password" />
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <!-- Submit button -->
                    <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center">create</button>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection
