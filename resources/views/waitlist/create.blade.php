@extends('master')
@section('content')
    <h2>Create Waiting List</h2>
    <div class="form-container">
        <form method="POST" action="{{ route('waitlist.store') }}">
            @csrf
            <label for="nama">Name:</label>
            <input type="text" name="nama" id="nama" value="{{ old('nama') }}">
            @error('detail')
                <span class="text-xs text-red-600">{{ $message }}</span>
            @enderror

            <label for="jumlahOrang"># People:</label>
            <input type="number" id="jumlahOrang" name="jumlahOrang" min="0" value="{{ old('jumlahOrang') }}">
            @error('jumlahOrang')
                <span class="text-xs text-red-600">{{ $message }}</span>
            @enderror

            <button type="submit">Create Waitlist</button>
        </form>
    </div>
@endsection
