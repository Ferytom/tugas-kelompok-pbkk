@extends('master')
@section('content')
    <h1>Hello, this is Report List</h1>
    <a href="{{ route('report.daily') }}" class="btn-info mr-2" style="padding-top:10px">Daily Report List</a>
    <a href="{{ route('report.monthly') }}" class="btn-info mr-2" style="padding-top:10px">Monthly Report List</a>
    <a href="{{ route('report.misc') }}" class="btn-info mr-2" style="padding-top:10px">Misc Report List</a>
    
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
            @foreach ($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->waktu }}</td>
                    <td>{{ $transaction->member }}</td>
                    <td>{{ $transaction->hargaTotal }}</td>
                    <td>{{ $transaction->address }}</td>
                    <td>
                        <div class="flex flex-row">
                            <a href="{{ route('reservation.detail', $transaction->id) }}" class="btn-indigo mr-2">Detail</a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
