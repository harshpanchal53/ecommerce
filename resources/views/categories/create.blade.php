@extends('layouts.app')

@section('content')
<h1>Add Category</h1>
<form action="{{ route('categories.store') }}" method="POST">
    @csrf
    <input type="text" name="name" placeholder="Category Name" required class="form-control">
    <button type="submit" class="btn btn-primary mt-2">Save</button>
</form>
@endsection
