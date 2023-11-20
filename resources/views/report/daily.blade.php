@extends('master')
@section('content')
    <h1>Hello, this is Daily Report List</h1>

    <a href="{{ route('report.index') }}" class="btn-info mr-2" style="padding-top:10px">Report List</a>
    <a href="{{ route('report.monthly') }}" class="btn-info mr-2" style="padding-top:10px">Monthly Report List</a>
@endsection
