@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col">
      <div class="card">
        <div class="card-body">
            @if(Session::has('success'))
                        <p class="alert alert-success">{{ Session::get('success') }}</p>
                    @endif
                    @if(Session::has('error'))
                        <p class="alert alert-danger">{{ Session::get('error') }}</p>
                    @endif
          <h5 class="card-title mb-4 d-inline">Boookings</h5>
          <a  href="{{route('foods.create')}}" class="btn btn-primary mb-4 text-center float-right">Create Foods</a>
          <table class="table">
            <thead>
              <tr>
                <th scope="col">name</th>
                <th scope="col">price</th>
                <th scope="col">category</th>
                <th scope="col">description</th>
                <th scope="col">image</th>
                <th scope="col">delete</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($foods as $food)
                <tr>
                    <td>{{$food->name}}</td>
                    <td>{{$food->price}}</td>
                    <td>{{$food->category}}</td>
                    <td>{{$food->description}}</td>
                    <td>
                        <img src="{{ asset('assets/img/' . $food->image) }}" alt="Booking Image" width="100">
                    </td>
                    <td><a href="{{ route('foods.delete', $food->id) }}" class="btn btn-danger mb-4 text-center">Delete</a>
                    </td>
                @endforeach
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

@endsection
