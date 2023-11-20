@extends('master')
@section('content')
    <h1>Hello, this is Report List</h1>
    <a href="{{ route('report.daily') }}" class="btn-info mr-2" style="padding-top:10px">Daily Report List</a>
    <a href="{{ route('report.monthly') }}" class="btn-info mr-2" style="padding-top:10px">Monthly Report List</a>
    
@endsection
