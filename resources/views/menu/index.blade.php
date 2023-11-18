@extends('master')
@section('content')
        @if (session('success'))
                <div class="alert alert-success mt-5 flex justify-between">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert"
                        onclick="this.parentElement.remove();">{{ 'x' }}</button>
                </div>
        @endif
        <h1>Menu List</h1>
        <div class="menu-card-container">
                @foreach($menus as $menu)
                        <div class="menu-card">
                                        <img src="{{asset('storage/assets/img/menu/' . $menu->pathFoto)}}" alt="{{ $menu->nama }}">
                                        <div class='name'> {{ $menu->nama }} </div>
                                        <div class='description'> {{ $menu->deskripsi }} </div>
                                        <div class='price'> Rp {{ $menu->harga }} </div>
                                        @if ((Auth::check()) && (Auth::user()->role == 'pemilik'))
                                                <a href="{{ route('menu.edit', $menu->id) }}" class="btn-info mr-2">Edit</a>
                                                <a href="{{ route('menu.destroy', $menu->id) }}" type="submit" class="btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                                        @endif
                                </div>
                        </div>
                @endforeach
                @if ((Auth::check()) && (Auth::user()->role == 'pemilik'))
                        <a href="{{ route('menu.create') }}" class='button' style="display: block; margin-top: 20px; width: 100%;">Create New Menu</a>
                @endif
        </div>
@endsection

