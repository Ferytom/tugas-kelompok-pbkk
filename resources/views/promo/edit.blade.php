@extends('master')
@section('content')
    <h1>Edit Promo</h1>

    <div class="form-container">
        <form action="{{ route('promo.update', $promo->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <label for="detail">Promo Detail:</label>
            <textarea name="detail" id="detail" style="width: 100%">{{ $promo->detail }}</textarea>
            @error('detail')
                <span class="text-xs text-red-600">{{ $message }}</span>
            @enderror

            <label for="percentage">Discount Percentage:</label>
            <input type="number" id="percentage" name="percentage" min="0" max="100" value={{ $promo->persenDiskon }}>
            @error('percentage')
                <span class="text-xs text-red-600">{{ $message }}</span>
            @enderror

            <label for="maxDiscount">Maximum Discount:</label>
            <input type="number" id="maxDiscount" name="maxDiscount" min="0" value={{ $promo->maxDiskon }}>
            @error('maxDiscount')
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
