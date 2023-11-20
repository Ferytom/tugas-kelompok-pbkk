@extends('master')
@section('content')
    <h1>Hello, this is Monthly Report List</h1>

    <a href="{{ route('report.index') }}" class="btn-info mr-2" style="padding-top:10px">Report List</a>
    <a href="{{ route('report.daily') }}" class="btn-info mr-2" style="padding-top:10px">Daily Report List</a>
@endsection
