<!-- filepath: resources/views/admin/super_admins/index.blade.php -->
@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Manage Admins</h1>

    <a href="{{ route('admins.create') }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded mb-4 inline-block">Add Admin</a>

    <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
        <thead>
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($admins as $admin)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $admin->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $admin->email }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('admins.edit', $admin) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                        <form action="{{ route('admins.destroy', $admin) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection