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
          <table class="table">
            <thead>
              <tr>
                <th scope="col">name</th>
                <th scope="col">email</th>
                <th scope="col">date</th>
                <th scope="col">numer of people</th>
                <th scope="col">request</th>
                <th scope="col">status</th>
                <th scope="col">change status</th>
                <th scope="col">delete</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($bookings as $booking)
                <tr>
                    <td>{{$booking->name}}</td>
                    <td>{{$booking->email}}</td>
                    <td>{{$booking->date}}</td>
                    <td>{{$booking->num_people}}</td>
                    <td>{{$booking->spe_request}}</td> 
                    <td>{{$booking->status}}</td>
                    <td><a  href="{{route('bookings.edit', $booking->id)}}" class="btn btn-warning mb-4 text-center">Change Status</a></td>
                    <td><a  href="{{route('bookings.delete', $booking->id)}}" class="btn btn-danger mb-4 text-center">Delete</a></td>
                @endforeach
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

@endsection
