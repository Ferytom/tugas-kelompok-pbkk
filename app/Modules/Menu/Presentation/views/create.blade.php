@extends('master')
@section('content')
    <h1>Menu Creation</h1>
    <div class="container">
        <div class="menu-form-container">
            <div class="form-container">
                <form action="{{ route('menu.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div>
                        <label for="name">Menu Name:</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" oninput="previewName()">
                        @error('name')
                            <span class="text-xs text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="description">Menu Description:</label>
                        <textarea name="description" id="description" oninput="previewDescription()">{{ old('description') }}</textarea>
                        @error('description')
                            <span class="text-xs text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="price">Menu Price:</label>
                        <input type="number" name="price" id="price" value="{{ old('price') }}" oninput="previewPrice()">
                        @error('price')
                            <span class="text-xs text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="image">Menu Photo:</label>
                        <input type="file" name="image" id="image" onchange="previewImage()">
                        @error('image')
                            <span class="text-xs text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <input type="submit" value="Create">
                    </div>
                </form>
            </div>
        </div>
        <div class="preview-menu-card-container">
            <div class="preview-menu-card">
                <img id="imagePreview" src="#" alt="Preview" style="display: none; max-width: 200px; margin-top: 10px;">
                <div id="namePreview" class='name'></div>
                <div id="descriptionPreview" class='description'></div>
                <div id="pricePreview" class='price'></div>
                <a href="#" class="btn-info mr-2">Edit</a>
                <form action="#" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        function previewName() {
            var input = document.getElementById('name');
            var preview = document.getElementById('namePreview');
            preview.textContent = input.value;
        }
        function previewDescription() {
            var input = document.getElementById('description');
            var preview = document.getElementById('descriptionPreview');
            preview.textContent = input.value;
        }
        function previewPrice() {
            var input = document.getElementById('price');
            var preview = document.getElementById('pricePreview');
            preview.textContent = "Rp " + input.value;
        }
        function previewImage() {
            var input = document.getElementById('image');
            var preview = document.getElementById('imagePreview');
            var file = input.files[0];
            var reader = new FileReader();

            reader.onloadend = function () {
                preview.src = reader.result;
                preview.style.display = 'block';
            };

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = '';
                preview.style.display = 'none';
            }
        }
    </script>
@endsection
