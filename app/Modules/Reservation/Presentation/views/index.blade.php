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
                    <tr>
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
                                @if($reservation->editable)
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
                    <th>Location</th>
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
