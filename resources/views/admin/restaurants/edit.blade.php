
{{-- filepath: d:\Kuliah\Semester 6\ppl-refood\SI4605-KEL411\resources\views\admin\restaurants\edit.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Edit Restaurant</h1>
    <form action="{{ route('restaurants.update', $restaurant) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium">Name</label>
            <input type="text" name="name" id="name" class="w-full border rounded px-4 py-2" value="{{ $restaurant->name }}" required>
        </div>
        <div class="mb-4">
            <label for="description" class="block text-sm font-medium">Description</label>
            <textarea name="description" id="description" class="w-full border rounded px-4 py-2">{{ $restaurant->description }}</textarea>
        </div>
        <div class="mb-4">
            <label for="discount" class="block text-sm font-medium">Discount (%)</label>
            <input type="number" name="discount" id="discount" class="w-full border rounded px-4 py-2" value="{{ $restaurant->discount }}" min="0" max="100">
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
    </form>
</div>
@endsection