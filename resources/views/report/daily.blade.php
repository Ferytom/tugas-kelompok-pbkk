@extends('master')

@section('content')
    <h1>Daily Report</h1>
    <a href="{{ route('report.index') }}" class="btn-info mr-2" style="padding-top:10px">Full Report List</a>
    <a href="{{ route('report.monthly') }}" class="btn-info mr-2" style="padding-top:10px">Monthly Report List</a>
    <a href="{{ route('report.misc') }}" class="btn-info mr-2" style="padding-top:10px">Misc Report List</a>

    <table class="data-table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Total Income</th>
            </tr>
        </thead>
        <tbody id="data-table-body">
            @forelse($groupedTransactions as $date => $transactions)
                    <tr>
                        <td>{{ Carbon\Carbon::parse($date)->format('F j, Y') }}</td>
                        <td>Rp {{ number_format($dailyTotals[$date], 0) }}</td>
                    </tr>
            @empty
                    <tr>
                        <td colspan="2">No transactions available.</td>
                    </tr>
            @endforelse
        </tbody>
    </table>
@endsection
