@extends('master')
@section('content')
    @if (session('success'))
            <div class="alert-success mt-5 flex justify-between">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert"
                    onclick="this.parentElement.remove();">{{ 'x' }}</button>
            </div>
    @endif
    @if (session('error'))
            <div class="alert-error mt-5 flex justify-between">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert"
                    onclick="this.parentElement.remove();">{{ 'x' }}</button>
            </div>
    @endif
    <h1>Waiting List</h1>

    @if(Auth::user()->role == 'pemilik')
        <div style="padding-bottom: 15px">
            <label for="alamat">Restaurant Location:</label>
            <select name="alamat" id="alamat" >
                <option value="all">All</option>
                @foreach($locations as $location)
                    <option value="{{$location->id}}">{{$location->alamat}}</option>
                @endforeach
            </select>
        </div>
    @endif
    <table class="data-table">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Jumlah Orang</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="data-table-body">
            @foreach ($waitlists as $waitlist)
                <tr data-location="{{$waitlist->location_id}}">
                    <td>{{ $waitlist->nama }}</td>
                    <td>{{ $waitlist->alamat }}</td>
                    <td>{{ $waitlist->jumlahOrang }}</td>
                    <td>
                        <form action="{{ route('waitlist.destroy', $waitlist->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <a href={{ route('waitlist.create') }} class='button'>Create New Waiting List</a>

    <script>
        document.getElementById('alamat').addEventListener('change', function () {
            var selectedLocationId = this.value;
            var tableRows = document.querySelectorAll('#data-table-body tr');

            tableRows.forEach(function (row) {
                var rowLocationId = row.getAttribute('data-location');

                if (selectedLocationId === 'all' || selectedLocationId === rowLocationId) {
                    row.style.display = ''; // Show the row
                } else {
                    row.style.display = 'none'; // Hide the row
                }
            });
        });
    </script>

@endsection
