@extends('master')
@section('content')
    <h1>Promo List</h1>
        <h3>Active Promo</h3>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Detail</th>
                    <th>Discount (%)</th>
                    <th>Max Discount</th>
                    <th>Expired</th>
                    @if ((Auth::check()) && (Auth::user()->role == 'pemilik'))
                        <th>Action</th>
                    @endif
                </tr>
            </thead>
            <tbody id="data-table-body">
                @foreach ($active_promos as $promo)
                    <tr>
                        <td>{{ $promo->detail }}</td>
                        <td>{{ $promo->persenDiskon }}%</td>
                        <td>{{ $promo->maxDiskon }}</td>
                        <td>{{ $promo->expired }}</td>
                        @if ((Auth::check()) && (Auth::user()->role == 'pemilik'))
                            <td>
                                <div class="flex flex-row">
                                    <a href="{{ route('promo.edit', $promo->id) }}" class="btn-info mr-2">Edit</a>
                                    <a href="{{ route('promo.destroy', $promo->id) }}" type="submit" class="btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                                </div>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h3>Expired Promo</h3>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Detail</th>
                    <th>Discount (%)</th>
                    <th>Max Discount</th>
                    <th>Expired</th>
                </tr>
            </thead>
            <tbody id="data-table-body">
                @foreach ($expired_promos as $promo)
                    <tr>
                        <td>{{ $promo->detail }}</td>
                        <td>{{ $promo->persenDiskon }}%</td>
                        <td>{{ $promo->maxDiskon }}</td>
                        <td>{{ $promo->expired }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if ((Auth::check()) && (Auth::user()->role == 'pemilik'))
            <a href={{ route('promo.create') }} class='button'>Create New Promo</a>
        @endif
@endsection
