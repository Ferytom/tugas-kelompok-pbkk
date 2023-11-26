@extends('master')
@section('content')
    @if (session('success'))
            <div class="alert alert-success mt-5 flex justify-between">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert"
                    onclick="this.parentElement.remove();">{{ 'x' }}</button>
            </div>
    @endif
    <h1>Transaction List</h1>
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
                    <tr>
                        <td>{{ $transaction->waktu }}</td>
                        <td>{{ $transaction->noMeja }}</td>
                        <td>{{ $transaction->hargaTotal }}</td>
                        <td>{{ $transaction->address }}</td>
                        <td>
                            <div class="flex flex-row">
                                <a href="{{ route('transaction.edit', $transaction->id) }}" class="btn-info mr-2">Edit</a>
                                <a href="{{ route('transaction.detail', $transaction->id) }}" class="btn-indigo mr-2">Detail</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
@endsection
