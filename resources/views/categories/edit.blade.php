@extends('layouts.app')

@section('content')
    <div class="card w-3/4 lg:w-full">
        <div class="card-body">
            <div class="flex flex-row justify-between items-center">
                <h1 class="font-extrabold text-lg">Edit {{ $category->name }} Category</h1>
                <a href="{{ route('categories.index') }}" class="btn-gray text-sm">Back to Categories</a>
            </div>

            <form action="/admin/categories/{{ $category->slug }}" method="POST" class="mt-5">
                @csrf
                @method('PUT')
                <div class="flex flex-col">
                    <label for="name" class="text-sm text-gray-600">Name</label>
                    <input type="text" name="name" id="name" class="input-text mt-2 w-full rounded-lg"
                        value="{{ old('name', $category->name) }}" required autofocus>
                    @error('name')
                        <span class="text-xs text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex flex-col mt-5">
                    <label for="slug" class="text-sm text-gray-600">Slug</label>
                    <input type="text" name="slug" id="slug" class="input-text mt-2 w-full rounded-lg"
                        value="{{ old('slug', $category->slug) }}" required>
                    @error('slug')
                        <span class="text-xs text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn mt-5">Create Category</button>
            </form>
        </div>
    </div>

    <script>
        const slugInput = document.querySelector('#slug');
        const nameInput = document.querySelector('#name');

        nameInput.addEventListener('keyup', function(e) {
            slugInput.value = slugify(nameInput.value);
        });

        function slugify(text) {
            return text.toString().toLowerCase().trim()
                .replace(/\s+/g, '-') // Replace spaces with -
                .replace(/[^\w-]+/g, '') // Remove all non-word chars
                .replace(/--+/g, '-') // Replace multiple - with single -
                .substring(0, 60); // Trim slug to first 60 chars
        }
    </script>
@endsection
