@extends('master')
@section('content')
    @if (session('success'))
            <div class="alert alert-success mt-5 flex justify-between">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert"
                    onclick="this.parentElement.remove();">{{ 'x' }}</button>
            </div>
    @endif
    <h1>Member List</h1>
    <table class="data-table">
        <thead>
            <tr>
                <th>Nama</th>
                <th>No Telepon</th>
                <th>Alamat</th>
                <th>Email</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="data-table-body">
            @foreach ($employees as $employee)
                <tr>
                    <td>{{ $employee->nama }}</td>
                    <td>{{ $employee->noTelepon }}</td>
                    <td>{{ $employee->alamat }}</td>
                    <td>{{ $employee->email }}</td> 
                    <td>{{ $employee->role }}</td>                   
                    <td>
                        @if($employee->role != 'pemilik')
                        <form action="{{ route('employee.destroy', $employee->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <a href={{ route('employee.create') }} class='button'>Create New Employee</a>
@endsection
