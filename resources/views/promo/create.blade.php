@extends('master')
@section('content')
    <h2>Create Promo</h2>
    <div class="form-container">
        <form method="POST" action="{{ route('promo.store') }}">
            @csrf
            <label for="detail">Promo Detail:</label>
            <textarea name="description" id="description" style="width: 100%">{{ old('detail') }}</textarea>
            @error('detail')
                <span class="text-xs text-red-600">{{ $message }}</span>
            @enderror

            <label for="percentage">Discount Percentage:</label>
            <input type="number" id="percentage" name="percentage" min="0" max="100" value="{{ old('percentage') }}">
            @error('percentage')
                <span class="text-xs text-red-600">{{ $message }}</span>
            @enderror

            <label for="maxDiscount">Maximum Discount:</label>
            <input type="number" id="maxDiscount" name="maxDiscount" min="0" value="{{ old('maxDiscount') }}">
            @error('maxDiscount')
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
