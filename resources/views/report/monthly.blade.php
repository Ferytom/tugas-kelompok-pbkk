@extends('master')

@section('content')
    <h1>Monthly Report</h1>
    <a href="{{ route('report.index') }}" class="btn-info mr-2" style="padding-top:10px">Full Report List</a>
    <a href="{{ route('report.daily') }}" class="btn-info mr-2" style="padding-top:10px">Daily Report List</a>

    <table class="data-table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Total Income</th>
            </tr>
        </thead>
        <tbody id="data-table-body">
            @forelse($groupedTransactions as $month => $transactions)
                    <tr>
                        <td>{{ Carbon\Carbon::parse($month)->format('F Y') }}</td>
                        <td>Rp {{ number_format($monthlyTotals[$month], 0) }}</td>
                    </tr>
            @empty
                    <tr>
                        <td colspan="2">No transactions available.</td>
                    </tr>
            @endforelse
        </tbody>
    </table>

@endsection
