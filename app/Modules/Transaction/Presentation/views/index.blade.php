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
    <h1>Transaction List</h1>
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
    <a href={{ route('transaction.create') }} class='button'>Create New Transaction</a>
    <h3>Ongoing Transaction</h3>
    <table class="data-table">
        <thead>
            <tr>
                <th>Time</th>
                <th>Table Number</th>
                <th>Total Price</th>
                <th>Location</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="data-table-body">
            @foreach ($transactions as $transaction)
                <tr data-location="{{$transaction->location_id}}">
                    <td>{{ $transaction->waktu }}</td>
                    <td>{{ $transaction->noMeja }}</td>
                    <td>{{ $transaction->hargaTotal }}</td>
                    <td>{{ $transaction->address }}</td>
                    <td>
                        <div class="flex flex-row">
                            <a href="{{ route('transaction.edit', $transaction->id) }}" class="btn-info mr-2">Edit</a>
                            <a href="{{ route('transaction.detail', $transaction->id) }}" class="btn-indigo mr-2">Detail</a>
                            <form action="{{ route('transaction.destroy', $transaction->id) }}" method="POST">
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
