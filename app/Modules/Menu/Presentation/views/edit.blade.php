@extends('master')
@section('content')
    <h1>Edit Menu</h1>
    <div class="container">
        <div class="form-container">
            <form action="{{ route('menu.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" value="{{ $menu->nama }}" oninput="previewName()" required><br><br>
                @error('name')
                    <span class="text-xs text-red-600">{{ $message }}</span>
                @enderror

                <label for="deskripsi">Description:</label>
                <textarea name="description" id="description" rows="4" cols="50" oninput="previewDescription()" required>{{ $menu->deskripsi }}</textarea><br><br>
                @error('description')
                    <span class="text-xs text-red-600">{{ $message }}</span>
                @enderror

                <label for="price">Price:</label>
                <input type="number" name="price" id="price" value="{{ $menu->harga }}" oninput="previewPrice()" required><br><br>
                @error('price')
                    <span class="text-xs text-red-600">{{ $message }}</span>
                @enderror

                <label for="image">Photo:</label>
                <input type="file" name="image" id="image" onchange="previewImage()"><br><br>
                @error('image')
                    <span class="text-xs text-red-600">{{ $message }}</span>
                @enderror

                <input type="submit" value="Update">
            </form>
        </div>
        <div class="preview-menu-card-container">
            <div class="preview-menu-card">
                <img id="imagePreview" src="{{asset($menu->pathFoto)}}" alt="Preview" style="max-width: 200px; margin-top: 10px;">
                <div id="namePreview" class='name'>{{$menu->nama}}</div>
                <div id="descriptionPreview" class='description'>{{$menu->deskripsi}}</div>
                <div id="pricePreview" class='price'>Rp {{$menu->harga}}</div>
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
