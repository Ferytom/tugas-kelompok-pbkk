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
    <h1>Reservation List</h1>
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
    <a href={{ route('reservation.create') }} class='button'>Create New Reservation</a>
    <h3>Ongoing Reservation</h3>
    <table class="data-table">
        <thead>
            <tr>
                <th>Time</th>
                <th>User</th>
                <th>Total Price</th>
                <th>Location</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="data-table-body">
            @foreach ($ongoing_reservations as $reservation)
                <tr data-location="{{$reservation->location_id}}">
                    <td>{{ $reservation->waktu }}</td>
                    <td>{{ $reservation->member }}</td>
                    <td>{{ $reservation->hargaTotal }}</td>
                    <td>{{ $reservation->address }}</td>
                    <td>
                        <div class="flex flex-row">
                            @if(($reservation->editable) || (Auth::user()->role != 'pelanggan'))
                                <a href="{{ route('reservation.edit', $reservation->id) }}" class="btn-info mr-2">Edit</a>
                            @endif
                            <a href="{{ route('reservation.detail', $reservation->id) }}" class="btn-indigo mr-2">Detail</a>
                            @if(($reservation->editable) || (Auth::user()->role != 'pelanggan'))
                                <form action="{{ route('reservation.destroy', $reservation->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Completed Reservations</h3>
    <table class="data-table">
        <thead>
            <tr>
                <th>Time</th>
                <th>User</th>
                <th>Total Price</th>
                <th>Location</th>
            </tr>
        </thead>
        <tbody id="data-table-body">
            @foreach ($completed_reservations as $reservation)
                <tr data-location="{{$reservation->location_id}}">
                    <td>{{ $reservation->waktu }}</td>
                    <td>{{ $reservation->member }}</td>
                    <td>{{ $reservation->hargaTotal }}</td>
                    <td>{{ $reservation->address }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Expired Reservations</h3>
    <table class="data-table">
        <thead>
            <tr>
                <th>Time</th>
                <th>User</th>
                <th>Total Price</th>
                <th>Location</th>
            </tr>
        </thead>
        <tbody id="data-table-body">
            @foreach ($expired_reservations as $reservation)
                <tr data-location="{{$reservation->location_id}}">
                    <td>{{ $reservation->waktu }}</td>
                    <td>{{ $reservation->member }}</td>
                    <td>{{ $reservation->hargaTotal }}</td>
                    <td>{{ $reservation->address }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if (Auth::user()->role == 'pelanggan')
        <a href={{ route('reservation.create') }} class='button'>Create New Reservation</a>
    @endif

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
