@extends('master')
@section('content')
    <h2>Create Employee</h2>
    <div class="form-container">
        <form method="POST" action="{{ route('employee.store') }}">
            @csrf
            <label for="nama">Nama: </label>
            <input type="text" name="nama" id="nama" style="width: 100%" value="{{ old('nama') }}">
            @error('nama')
                <span class="text-xs text-red-600">{{ $message }}</span>
            @enderror

            <label for="noTelepon">Nomor Telepon: </label>
            <input type="text" name="noTelepon" id="noTelepon" value="{{ old('noTelepon') }}">
            @error('noTelepon')
                <span class="text-xs text-red-600">{{ $message }}</span>
            @enderror

            <label for="alamat">Alamat: </label>
            <input type="text" name="alamat" id="alamat" value="{{ old('alamat') }}">
            @error('alamat')
                <span class="text-xs text-red-600">{{ $message }}</span>
            @enderror

            <label for="email">Email: </label>
            <input type="text" name="email" id="email" value="{{ old('email') }}">
            @error('email')
                <span class="text-xs text-red-600">{{ $message }}</span>
            @enderror

            <label for="password">Password: </label>
            <input type="text" name="password" id="password" value="{{ old('password') }}">
            @error('password')
                <span class="text-xs text-red-600">{{ $message }}</span>
            @enderror

            <div class="role-container" style="padding-bottom: 10px">
                <label for="role">Role: </label>
                <select id="role" name="role">
                    <option value="karyawan">Karyawan</option>    
                    <option value="manager">Manager</option>
                </select>
                @error('role')
                    <span class="text-xs text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div class="location-container" style="padding-bottom: 10px">
                <label for="location_id">Location: </label>
                <select id="location_id" name="location_id">
                    @foreach($locations as $location)
                        <option value="{{$location->id}}">{{$location->alamat}}</option>
                    @endforeach
                </select>
                @error('location_id')
                    <span class="text-xs text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit">Create Employee</button>
        </form>
    </div>
@endsection
