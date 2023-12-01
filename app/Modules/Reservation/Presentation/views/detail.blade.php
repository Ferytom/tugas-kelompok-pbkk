@extends('master')
@section('content')
    <h1>Reservation Detail</h1>
    <div class="form-container">
        <label name="reserver">Reserver: {{$reservation->pemesan}}</label>

        <label name="address">Restaurant Location: {{$reservation->alamat}}</label>
        
        <label name="datetime">Date and Time: {{$reservation->waktu}}</label>
        
        <label name="total_price">Total Price: {{$reservation->hargaTotal}}</label>
        
        <label name="promo">Promo: {{$promo->nama}} - {{$promo->persenDiskon}}% s/d Rp {{$promo->maxDiskon}}</label>
        
        <label for="notes">Extra Notes:</label>
        <textarea name="notes" id="notes" style="width:100%" readonly>{{$reservation->keterangan}}</textarea>

        <h3>Menu Selection</h3>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Menu Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody id="menu_table">
                @foreach($orders as $order)
                    <tr>
                        <td>{{$order->nama}}</td>
                        <td>{{$order->harga}}</td>
                        <td>{{$order->quantity}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
