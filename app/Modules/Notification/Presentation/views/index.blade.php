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
            </tr>
        </thead>
        <tbody id="data-table-body">
            @foreach ($notifications as $reservation)
                <tr>
                    <td>{{ $reservation->waktu }}</td>
                    <td>{{ $reservation->member }}</td>
                    <td>{{ $reservation->hargaTotal }}</td>
                    <td>{{ $reservation->address }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
