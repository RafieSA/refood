
{{-- filepath: d:\Kuliah\Semester 6\ppl-refood\SI4605-KEL411\resources\views\admin\restaurants\index.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Restaurants</h1>
    <a href="{{ route('restaurants.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Add Restaurant</a>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded mt-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="table-auto w-full mt-4">
        <thead>
            <tr>
                <th class="px-4 py-2">Name</th>
                <th class="px-4 py-2">Description</th>
                <th class="px-4 py-2">Discount</th>
                <th class="px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($restaurants as $restaurant)
            <tr>
                <td class="border px-4 py-2">{{ $restaurant->name }}</td>
                <td class="border px-4 py-2">{{ $restaurant->description }}</td>
                <td class="border px-4 py-2">{{ $restaurant->discount }}%</td>
                <td class="border px-4 py-2">
                    <a href="{{ route('restaurants.edit', $restaurant) }}" class="text-blue-500">Edit</a>
                    <form action="{{ route('restaurants.destroy', $restaurant) }}" method="POST" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection