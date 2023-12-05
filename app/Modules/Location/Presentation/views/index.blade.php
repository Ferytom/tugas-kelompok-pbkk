@extends('master')
@section('content')
    @if (session('success'))
            <div class="alert alert-success mt-5 flex justify-between">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert"
                    onclick="this.parentElement.remove();">{{ 'x' }}</button>
            </div>
    @endif
    <h1>Location List</h1>
    <table class="data-table">
        <thead>
            <tr>
                <th>Nama Lokasi</th>
                <th>Alamat</th>
                <th>Gooogle Map</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="data-table-body">
            @foreach ($locations as $location)
                <tr>
                    <td>{{ $location->namaLokasi }}</td>
                    <td>{{ $location->alamat }}</td>
                    <td>{{ $location->googleMap }}</td> 
                    <td>
                        <a href="{{ route('location.edit', $location->id) }}" class="btn-info mr-2">Edit</a>
                        <form action="{{ route('location.destroy', $location->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <a href={{ route('location.create') }} class='button'>Create New Location</a>
@endsection
