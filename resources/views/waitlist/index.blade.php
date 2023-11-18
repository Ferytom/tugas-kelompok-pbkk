@extends('master')
@section('content')
    @if (session('success'))
            <div class="alert alert-success mt-5 flex justify-between">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert"
                    onclick="this.parentElement.remove();">{{ 'x' }}</button>
            </div>
    @endif
    <h1>Waiting List</h1>
    <table class="data-table">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Jumlah Orang</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="data-table-body">
            @foreach ($waitlists as $waitlist)
                <tr>
                    <td>{{ $waitlist->nama }}</td>
                    <td>{{ $waitlist->jumlahOrang }}</td>
                    <td>
                        <form action="{{ route('waitlist.destroy', $waitlist->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <a href={{ route('waitlist.create') }} class='button'>Create New Waiting List</a>
@endsection
