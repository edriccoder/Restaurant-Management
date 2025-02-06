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
          <h5 class="card-title mb-4 d-inline">Admins</h5>
          <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">name</th>
                <th scope="col">email</th>
                <th scope="col">address</th>
                <th scope="col">price</th>
                <th scope="col">status</th>
                <th scope="col">change status</th>
                <th scope="col">delete</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                <tr>
                    <th scope="row">{{$order->id}}</th>
                    <td>{{$order->name}}</td>
                    <td>{{$order->email}}</td>
                    <td>{{$order->address}}</td>
                    <td>{{$order->price}}</td>
                    <td>{{$order->status}}</td> 
                    <td><a  href="{{route('orders.edit', $order->id)}}" class="btn btn-warning mb-4 text-center">Change Status</a></td>
                    <td><a  href="{{route('orders.delete', $order->id)}}" class="btn btn-danger mb-4 text-center">Delete</a></td>
                @endforeach
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

@endsection
