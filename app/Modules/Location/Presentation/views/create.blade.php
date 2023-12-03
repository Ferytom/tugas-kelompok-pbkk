@extends('master')
@section('content')
    <h2>Create Location</h2>
    <div class="form-container">
        <form method="POST" action="{{ route('location.store') }}">
            @csrf
            <label for="namaLokasi">Location Name: </label>
            <input type="text" name="namaLokasi" id="namaLokasi" value="{{ old('namaLokasi') }}">
            @error('namaLokasi')
                <span class="text-xs text-red-600">{{ $message }}</span>
            @enderror

            <label for="alamat">Address: </label>
            <input type="text" name="alamat" id="alamat" value="{{ old('alamat') }}">
            @error('alamat')
                <span class="text-xs text-red-600">{{ $message }}</span>
            @enderror

            <label for="googleMap">Google Map: </label>
            <input type="text" name="googleMap" id="googleMap" value="{{ old('googleMap') }}">
            @error('googleMap')
                <span class="text-xs text-red-600">{{ $message }}</span>
            @enderror

            <button type="submit">Create Location</button>
        </form>
    </div>
@endsection
