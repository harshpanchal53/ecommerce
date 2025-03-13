@extends('layouts.app')

@section('content')
<h1>Edit Category</h1>
<form action="{{ route('categories.update', $category) }}" method="POST">
    @csrf @method('PUT')
    <input type="text" name="name" value="{{ $category->name }}" required class="form-control">
    <button type="submit" class="btn btn-success mt-2">Update</button>
</form>
@endsection
