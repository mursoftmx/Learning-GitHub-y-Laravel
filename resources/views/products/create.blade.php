@extends('layouts.app')

@section('content')
    <h1>Create a product</h1>

    <form method="post" action="{{ route('products.store') }}">
        @csrf
        <div class="form-row">
            <label for="title">Title</label>
            <input type="text" class="form-control" name="title" value="{{ old('title') }}" required>
        </div>
        <div class="form-row">
            <label for="description">Description</label>
            <input type="text" class="form-control" name="description" value="{{ old('description') }}" required>
        </div>
        <div class="form-row">
            <label for="price">Price</label>
            <input type="number" class="form-control" min="1.00" step="0.01" name="price" value="{{ old('price') }}" required>
        </div>
        <div class="form-row">
            <label for="stock">Stock</label>
            <input type="number" class="form-control" min="0" name="stock" value="{{ old('stock') }}" required>
        </div>
        <div class="form-row">
            <label for="status">Status</label>
            <select class="custom-select" name="status" required>
                <option value="" selected>Select ...</option>
                <option {{ old('status') == 'available' ? 'selected' : '' }} value="available">Available</option>
                <option {{ old('status') == 'unavailable' ? 'selected' : '' }} value="unavailable">Unavailable</option>
            </select>
        </div>
        <div class="form-row mt-3">
            <button type="submit" class="btn btn-primary btn-lg">Create Product</button>
        </div>

    </form>
@endsection