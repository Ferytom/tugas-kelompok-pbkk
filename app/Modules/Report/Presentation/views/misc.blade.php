@extends('master')

@section('content')
    <h1>Miscelaneous Report</h1>
    <a href="{{ route('report.index') }}" class="btn-info mr-2" style="padding-top:10px">Full Report List</a>
    <a href="{{ route('report.daily') }}" class="btn-info mr-2" style="padding-top:10px">Daily Report List</a>
    <a href="{{ route('report.monthly') }}" class="btn-info mr-2" style="padding-top:10px">Monthly Report List</a>

    <h3>Highest Transaction Value</h3>
    <table class="data-table">
        <thead>
            <tr>
                <th>Date</th>
                <th>User</th>
                <th>Location</th>
                <th>Total Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="data-table-body">
            @foreach($highestTotalTransactions as $transaction)
                <tr>
                    <td>{{ $transaction->waktu }}</td>
                    <td>{{ $transaction->member }}</td>
                    <td>{{ $transaction->alamat }}</td>
                    <td>Rp {{ number_format($transaction->hargaTotal, 0, ',', '.') }}</td>
                    <td>
                        <div class="flex flex-row">
                            <a href="{{ route('transaction.detail', $transaction->id) }}" class="btn-indigo mr-2">Detail</a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <h3>Best Member</h3>
    <table class="data-table">
        <thead>
            <tr>
                <th>User</th>
                <th>Total Expense</th>
                <th>Number of Transaction</th>
            </tr>
        </thead>
        <tbody id="data-table-body">
            @foreach($bestMembers as $member)
                <tr>
                    <td>{{ $member->nama }}</td>
                    <td>Rp {{ number_format($member->totalPengeluaran, 0, ',', '.') }}</td>
                    <td>{{ $member->jumlahTransaksi }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Best Locations</h3>
    <table class="data-table">
        <thead>
            <tr>
                <th>Location</th>
                <th>Total Income</th>
                <th>Number of Transaction</th>
            </tr>
        </thead>
        <tbody id="data-table-body">
            @foreach($bestLocations as $location)
                <tr>
                    <td>{{ $location->alamat }}</td>
                    <td>Rp {{ number_format($location->totalPendapatan, 0, ',', '.') }}</td>
                    <td>{{ $location->jumlahTransaksi }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Most Popular Food</h3>
    <table class="data-table">
        <thead>
            <tr>
                <th>Menu Name</th>
                <th>Menu Price</th>
                <th>Number of Orders</th>
            </tr>
        </thead>
        <tbody id="data-table-body">
            @foreach($bestFoods as $menu)
                <tr>
                    <td>{{ $menu->nama }}</td>
                    <td>Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
                    <td>{{ $menu->jumlahOrder }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
@endsection
