@extends('master')
@section('content')
    <h1>Edit Menu</h1>

    <div class="form-container">
        <form action="{{ route('menu.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" value="{{ $menu->nama }}" required><br><br>
            @error('name')
                <span class="text-xs text-red-600">{{ $message }}</span>
            @enderror

            <label for="deskripsi">Description:</label>
            <textarea name="description" id="description" rows="4" cols="50" required>{{ $menu->deskripsi }}</textarea><br><br>
            @error('description')
                <span class="text-xs text-red-600">{{ $message }}</span>
            @enderror

            <label for="price">Price:</label>
            <input type="number" name="price" id="price" value="{{ $menu->harga }}" required><br><br>
            @error('price')
                <span class="text-xs text-red-600">{{ $message }}</span>
            @enderror

            <label for="image">Photo:</label>
            <input type="file" name="image" id="image"><br><br>
            @error('image')
                <span class="text-xs text-red-600">{{ $message }}</span>
            @enderror

            <input type="submit" value="Update">
        </form>
    </div>
@endsection
