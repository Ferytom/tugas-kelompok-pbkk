@extends('master')
@section('content')
    <h1>Edit Promo</h1>

    <div class="form-container">
        <form action="{{ route('promo.update', $promo->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <label for="nama">Promo Name:</label>
            <textarea name="nama" id="nama" style="width: 80%">{{ $promo->nama }}</textarea>
            @error('name')
                <span class="text-xs text-red-600">{{ $message }}</span>
            @enderror

            <label for="detail">Promo Detail:</label>
            <textarea name="detail" id="detail" style="width: 100%">{{ $promo->detail }}</textarea>
            @error('detail')
                <span class="text-xs text-red-600">{{ $message }}</span>
            @enderror

            <label for="persenDiskon">Discount Percentage:</label>
            <input type="number" id="persenDiskon" name="persenDiskon" min="0" max="100" value={{ $promo->persenDiskon }}>
            @error('persenDiskon')
                <span class="text-xs text-red-600">{{ $message }}</span>
            @enderror

            <label for="maxDiskon">Maximum Discount:</label>
            <input type="number" id="maxDiskon" name="maxDiskon" min="0" value={{ $promo->maxDiskon }}>
            @error('maxDiskon')
                <span class="text-xs text-red-600">{{ $message }}</span>
            @enderror

            <label for="expired">Expiration Date:</label>
            <input type="date" id="expired" name="expired" value={{ $promo->expired }}>
            @error('expired')
                <span class="text-xs text-red-600">{{ $message }}</span>
            @enderror

            <input type="submit" value="Update">
        </form>
    </div>
@endsection
