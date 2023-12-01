@extends('master')

@section('content')
    <h1>Monthly Report</h1>
    <a href="{{ route('report.index') }}" class="btn-info mr-2" style="padding-top:10px">Full Report List</a>
    <a href="{{ route('report.daily') }}" class="btn-info mr-2" style="padding-top:10px">Daily Report List</a>
    <a href="{{ route('report.misc') }}" class="btn-info mr-2" style="padding-top:10px">Misc Report List</a>
    
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
    <canvas id="monthlyIncomeChart" width="400" height="200"></canvas>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Get the data from the server-side Laravel Blade view
        var rawLabels = {!! json_encode(array_keys($groupedTransactions->toArray())) !!};
        var rawData = {!! json_encode(array_values($monthlyTotals->toArray())) !!};

        // Create an object to store data by date
        var dataByDate = {};
        rawLabels.forEach(function (date, index) {
            dataByDate[date] = rawData[index];
        });

        // Generate an array of months with zero values for missing months
        var startDate = moment(rawLabels[0]);
        var endDate = moment(rawLabels[rawLabels.length - 1]);
        var allMonths = [];
        var currentMonth = startDate.clone().startOf('month');
        while (currentMonth.isSameOrBefore(endDate, 'month')) {
            allMonths.push(currentMonth.format('YYYY-MM'));
            currentMonth.add(1, 'month');
        }

        // Fill in zero values for missing months
        var labels = allMonths.map(function (month) {
            return moment(month).format('MMMM YYYY');
        });
        var data = allMonths.map(function (month) {
            return dataByDate[month] || 0;
        });

        // Create a line chart using Chart.js
        var ctx = document.getElementById('monthlyIncomeChart').getContext('2d');
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
                            unit: 'month'
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
