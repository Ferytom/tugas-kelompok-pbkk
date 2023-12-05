@extends('master')
@section('content')
    <h2>Create Waiting List</h2>
    <div class="form-container">
        <form method="POST" action="{{ route('waitlist.store') }}">
            @csrf
            <label for="nama">Name:</label>
            <input type="text" name="nama" id="nama" value="{{ old('nama') }}">
            @error('nama')
                <span class="text-xs text-red-600">{{ $message }}</span>
            @enderror
            
            @if(Auth::user()->role == 'pemilik')
                <label for="alamat">Restaurant Location:</label>
                <select name="alamat" id="alamat">
                    @foreach($locations as $location)
                        <option value="{{$location->id}}">{{$location->alamat}}</option>
                    @endforeach
                </select>
                @error('address')
                    <span class="text-xs text-red-600">{{ $message }}</span>
                @enderror
                <div style="padding-bottom: 10px"></div>
            @endif

            <label for="jumlahOrang"># People:</label>
            <input type="number" id="jumlahOrang" name="jumlahOrang" min="0" value="{{ old('jumlahOrang') }}">
            @error('jumlahOrang')
                <span class="text-xs text-red-600">{{ $message }}</span>
            @enderror

            <button type="submit">Create Waitlist</button>
        </form>
    </div>
@endsection
