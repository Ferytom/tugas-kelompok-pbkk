@extends('master')
@section('content')
    <h2>Create Employee</h2>
    <div class="form-container">
        <form method="POST" action="{{ route('employee.update', $employee->id) }}">
            @csrf
            @method('PUT')
            <label for="nama">Nama: </label>
            <input type="text" name="nama" id="nama" style="width: 100%" value="{{ $employee->nama }}">
            @error('nama')
                <span class="text-xs text-red-600">{{ $message }}</span>
            @enderror

            <label for="noTelepon">Nomor Telepon: </label>
            <input type="text" name="noTelepon" id="noTelepon" value="{{ $employee->noTelepon }}">
            @error('noTelepon')
                <span class="text-xs text-red-600">{{ $message }}</span>
            @enderror

            <label for="alamat">Alamat: </label>
            <input type="text" name="alamat" id="alamat" value="{{ $employee->alamat }}">
            @error('alamat')
                <span class="text-xs text-red-600">{{ $message }}</span>
            @enderror

            <label for="email">Email: </label>
            <input type="text" name="email" id="email" value="{{ $employee->email }}">
            @error('email')
                <span class="text-xs text-red-600">{{ $message }}</span>
            @enderror

            <div class="role-container" style="padding-bottom: 10px">
                <label for="role">Role: </label>
                <select id="role" name="role">
                @if($employee->role == 'karyawan')
                    <option value="karyawan" selected>Karyawan</option>    
                    <option value="manager">Manager</option>
                @endif
                @if($employee->role == 'manager')
                    <option value="karyawan">Karyawan</option>    
                    <option value="manager" selected>Manager</option>
                @endif
                </select>
                @error('role')
                    <span class="text-xs text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div class="location-container" style="padding-bottom: 10px">
                <label for="location_id">Location: </label>
                <select id="location_id" name="location_id">
                    @foreach($locations as $location)
                        @if($location->id == $employee->location_id)
                            <option value="{{$location->id}}" selected>{{$location->alamat}}</option>
                        @endif
                        @if($location->id != $employee->location_id)
                            <option value="{{$location->id}}">{{$location->alamat}}</option>
                        @endif
                    @endforeach
                </select>
                @error('location_id')
                    <span class="text-xs text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit">Edit Employee</button>
        </form>
    </div>
@endsection
