@extends('master')
@section('content')
    <h2>Edit Location</h2>
    <div class="form-container">
        <form method="POST" action="{{ route('location.update', $location->id) }}">
            @csrf
            @method('PUT')
            <label for="namaLokasi">Location Name: </label>
            <input type="text" name="namaLokasi" id="namaLokasi" value="{{ $location->namaLokasi }}">
            @error('namaLokasi')
                <span class="text-xs text-red-600">{{ $message }}</span>
            @enderror

            <label for="alamat">Address: </label>
            <input type="text" name="alamat" id="alamat" value="{{ $location->alamat }}">
            @error('alamat')
                <span class="text-xs text-red-600">{{ $message }}</span>
            @enderror

            <label for="googleMap">Google Map: </label>
            <textarea name="googleMap" id="googleMap" style="width:100%">{{ $location->googleMap }}</textarea>
            @error('googleMap')
                <span class="text-xs text-red-600">{{ $message }}</span>
            @enderror

            <button type="submit">Edit Location</button>
        </form>
    </div>
@endsection
