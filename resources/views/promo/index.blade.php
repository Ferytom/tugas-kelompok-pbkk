@extends('master')
@section('content')
    @if (session('success'))
            <div class="alert alert-success mt-5 flex justify-between">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert"
                    onclick="this.parentElement.remove();">{{ 'x' }}</button>
            </div>
    @endif
    <h1>Promo List</h1>
        <h3>Active Promo</h3>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Nama</th>
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
                        <td>{{ $promo->nama }}</td>
                        <td>{{ $promo->detail }}</td>
                        <td>{{ $promo->persenDiskon }}%</td>
                        <td>{{ $promo->maxDiskon }}</td>
                        <td>{{ $promo->expired }}</td>
                        @if ((Auth::check()) && (Auth::user()->role == 'pemilik') && ($promo->id != 1))
                            <td>
                                <div class="flex flex-row">
                                    <a href="{{ route('promo.edit', $promo->id) }}" class="btn-info mr-2">Edit</a>
                                    <form action="{{ route('promo.destroy', $promo->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
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
