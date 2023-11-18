@extends('master')
@section('content')
    <h1>Menu Creation</h1>
    <div class="form-container">
        <form action="{{ route('menu.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div>
                <label for="name">Menu Name:</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}">
                @error('name')
                    <span class="text-xs text-red-600">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="description">Menu Description:</label>
                <textarea name="description" id="description">{{ old('description') }}</textarea>
                @error('description')
                    <span class="text-xs text-red-600">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="price">Menu Price:</label>
                <input type="text" name="price" id="price" value="{{ old('price') }}">
                @error('price')
                    <span class="text-xs text-red-600">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="image">Menu Photo:</label>
                <input type="file" name="image" id="image">
                @error('image')
                    <span class="text-xs text-red-600">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <input type="submit" value="Create">
            </div>
        </form>
    </div>
@endsection
