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
            </tr>
        </thead>
        <tbody id="data-table-body">
            @foreach ($members as $member)
                <tr>
                    <td>{{ $member->nama }}</td>
                    <td>{{ $member->noTelepon }}</td>
                    <td>{{ $member->alamat }}</td>
                    <td>{{ $member->email }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
