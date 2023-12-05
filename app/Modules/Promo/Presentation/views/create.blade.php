@extends('master')
@section('content')
    <h2>Create Promo</h2>
    <div class="form-container">
        <form method="POST" action="{{ route('promo.store') }}">
            @csrf

            <label for="nama">Promo Name:</label>
            <textarea name="nama" id="nama">{{ old('nama') }}</textarea>
            @error('nama')
                <span class="text-xs text-red-600">{{ $message }}</span>
            @enderror

            <label for="detail">Promo Detail:</label>
            <textarea name="detail" id="detail" style="width: 100%">{{ old('detail') }}</textarea>
            @error('detail')
                <span class="text-xs text-red-600">{{ $message }}</span>
            @enderror

            <label for="persenDiskon">Discount Percentage:</label>
            <input type="number" id="persenDiskon" name="persenDiskon" min="0" max="100" value="{{ old('persenDiskon') }}">
            @error('persenDiskon')
                <span class="text-xs text-red-600">{{ $message }}</span>
            @enderror

            <label for="maxDiskon">Maximum Discount:</label>
            <input type="number" id="maxDiskon" name="maxDiskon" min="0" value="{{ old('maxDiskon') }}">
            @error('maxDiskon')
                <span class="text-xs text-red-600">{{ $message }}</span>
            @enderror

            <label for="expired">Expiration Date:</label>
            <input type="date" id="expired" name="expired" value="{{ old('expired') }}">
            @error('expired')
                <span class="text-xs text-red-600">{{ $message }}</span>
            @enderror

            <button type="submit">Create Promo</button>
        </form>
    </div>
@endsection
