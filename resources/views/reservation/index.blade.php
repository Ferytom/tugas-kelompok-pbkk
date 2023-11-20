@extends('master')
@section('content')
    @if (session('success'))
            <div class="alert alert-success mt-5 flex justify-between">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert"
                    onclick="this.parentElement.remove();">{{ 'x' }}</button>
            </div>
    @endif
    <h1>Reservation List</h1>
        <h3>Ongoing Reservation</h3>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Time</th>
                    <th>User</th>
                    <th>Total Price</th>
                    <th>Address</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="data-table-body">
                @foreach ($ongoing_reservations as $reservation)
                    <tr>
                        <td>{{ $reservation->waktu }}</td>
                        <td>{{ $reservation->member }}</td>
                        <td>{{ $reservation->hargaTotal }}</td>
                        <td>{{ $reservation->address }}</td>
                        <td>
                            <div class="flex flex-row">
                                <a href="{{ route('reservation.edit', $reservation->id) }}" class="btn-info mr-2">Edit</a>
                                <a href="{{ route('reservation.detail', $reservation->id) }}" class="btn-indigo mr-2">Detail</a>
                                <form action="{{ route('reservation.destroy', $reservation->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
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
                    <th>Address</th>
                </tr>
            </thead>
            <tbody id="data-table-body">
                @foreach ($completed_reservations as $reservation)
                    <tr>
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
                    <th>Address</th>
                </tr>
            </thead>
            <tbody id="data-table-body">
                @foreach ($expired_reservations as $reservation)
                    <tr>
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
@endsection
