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
    <canvas id="dailyIncomeChart" width="400" height="200"></canvas>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Get the data from the server-side Laravel Blade view
        var rawLabels = {!! json_encode(array_keys($groupedTransactions->toArray())) !!};
        var rawData = {!! json_encode(array_values($dailyTotals->toArray())) !!};

        // Create an object to store data by date
        var dataByDate = {};
        rawLabels.forEach(function (date, index) {
            dataByDate[date] = rawData[index];
        });

        // Generate an array of dates with zero values for missing dates
        var startDate = moment(rawLabels[0]);
        var endDate = moment(rawLabels[rawLabels.length - 1]);
        var allDates = [];
        var currentDate = startDate;
        while (currentDate.isSameOrBefore(endDate, 'day')) {
            allDates.push(currentDate.format('YYYY-MM-DD'));
            currentDate.add(1, 'day');
        }

        // Fill in zero values for missing dates
        var labels = allDates.map(function (date) {
            return moment(date).format('MMMM D, YYYY');
        });
        var data = allDates.map(function (date) {
            return dataByDate[date] || 0;
        });

        // Create a line chart using Chart.js
        var ctx = document.getElementById('dailyIncomeChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total Income',
                    data: data,
                    fill: false,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            },
            options: {
                scales: {
                    x: [{
                        type: 'time',
                        time: {
                            unit: 'day'
                        }
                    }],
                    y: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    });
</script>
    
@endsection
