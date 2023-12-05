@extends('master')
@section('content')
    <h1>Notifications</h1>
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
            @foreach ($notifications as $reservation)
                <tr>
                    <td>{{ $reservation->waktu }}</td>
                    <td>{{ $reservation->member }}</td>
                    <td>{{ $reservation->hargaTotal }}</td>
                    <td>{{ $reservation->address }}</td>
                    <td><a href="{{ route('reservation.detail', $reservation->id) }}" class="btn-indigo mr-2">Detail</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
