@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title mb-5 d-inline">Create Food Items</h5>
          <form method="POST" action="{{ route('foods.store') }}" enctype="multipart/form-data">
                @csrf
            
                <div class="form-outline mb-4 mt-4">
                    <input type="text" name="name" class="form-control" placeholder="Name" required />
                </div>
            
                <div class="form-outline mb-4 mt-4">
                    <input type="text" name="price" class="form-control" placeholder="Price" required />
                </div>
            
                <div class="form-outline mb-4 mt-4">
                    <input type="file" name="image" class="form-control" required />
                </div>
            
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" name="description" rows="3" required></textarea>
                </div>
            
                <div class="form-outline mb-4 mt-4">
                    <select name="category" class="form-select form-control" required>
                        <option value="" disabled selected>Choose Meal</option>
                        <option value="breakfast">Breakfast</option>
                        <option value="lunch">Lunch</option>
                        <option value="dinner">Dinner</option>
                    </select>
                </div>
            
                <button type="submit" class="btn btn-primary mb-4 text-center">Create</button>
            </form>
        </div>
      </div>
    </div>
  </div>


@endsection