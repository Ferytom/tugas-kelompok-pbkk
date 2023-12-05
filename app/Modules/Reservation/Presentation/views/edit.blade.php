@extends('master')
@section('content')
    <h1>Edit Reservation</h1>
    <div class="form-container">
        <form action="{{ route('reservation.update', $reservation->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <label for="address">Restaurant Location:</label>
            <select name="address" id="address">
                @if(Auth::user()->role == 'pelanggan')
                    @foreach($locations as $location)
                        @if($location->id == $reservation->location_id)
                            <option value="{{ $location->id }}" selected>{{ $location->alamat }}</option>
                        @endif
                        @if($location->id != $reservation->location_id)
                            <option value="{{ $location->id }}">{{ $location->alamat }}</option>
                        @endif
                    @endforeach
                @endif
                @if(Auth::user()->role != 'pelanggan')                
                    @foreach($locations as $location)
                        @if($location->id == $reservation->location_id)
                            <option value="{{ $location->id }}" selected>{{ $location->alamat }}</option>
                        @endif
                    @endforeach
                @endif
            </select>
            @error('address')
                <span class="text-xs text-red-600">{{ $message }}</span>
            @enderror
            
            <label for="datetime">Date and Time:</label>
            @if(Auth::user()->role == 'pelanggan')
                <input type="datetime-local" name="datetime" id="datetime" value="{{$reservation->waktu}}">
            @endif
            @if(Auth::user()->role != 'pelanggan')
                <input type="datetime-local" name="datetime" id="datetime" value="{{$reservation->waktu}}" readonly>
            @endif
            @error('datetime')
                <span class="text-xs text-red-600">{{ $message }}</span>
            @enderror
            
            <label for="total_price">Total Price:</label>
            <input type="text" name="total_price" id="total_price" readonly value="{{$reservation->hargaTotal}}">
            @error('total_price')
                <span class="text-xs text-red-600">{{ $message }}</span>
            @enderror
            
            <label for="notes">Extra Notes:</label>
            <textarea name="notes" id="notes" style="width:100%">{{$reservation->keterangan}}</textarea>
            @error('notes')
                <span class="text-xs text-red-600">{{ $message }}</span>
            @enderror
            
            <h3>Menu Selection</h3>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Menu Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        @if(Auth::user()->role == 'pelanggan')
                            <th>Action</th>
                        @endif
                    </tr>
                </thead>
                <tbody id="menu_table">
                    @foreach($orders as $order)
                        <td>{{$order->nama}}</td>
                        <td>{{$order->harga}}</td>
                        <td>{{$order->quantity}}</td>                        
                    @endforeach
                </tbody>
            </table>

            @if(Auth::user()->role != 'pelanggan')
            <div style="display:none">
            @endif
                <label for="menu">Menu:</label>
                <select name="menu" id="menu" type="hidden">
                    @foreach($menus as $menu)
                        <option value="{{ $menu->id }}">{{ $menu->nama }} - {{ $menu->harga }}</option>
                    @endforeach
                </select>
                @error('menu_ids')
                    <span class="text-xs text-red-600">{{ $message }}</span>
                @enderror
                
                <label for="quantity">Quantity:</label>
                <input type="number" name="quantity" id="quantity" min="1" value="1">
                @error('quantity_ids')
                    <span class="text-xs text-red-600">{{ $message }}</span>
                @enderror
                
                <button type="button" onclick="addMenu()">Add Menu</button>
            @if(Auth::user()->role != 'pelanggan')
            </div>
            @endif

            <input type="hidden" name="menu_ids[]" id="menu_ids" value="">
            <input type="hidden" name="menu_count" id="menu_count" value="">
            <input type="hidden" name="quantities[]" id="quantities" value="">

            @if(Auth::user()->role != 'pelanggan')
            <div style="display:none">
            @endif
                <label for="promo">Promo:</label>
                <select name="promo" id="promo" onchange="updateTotalPrice()">
                    @foreach($promos as $promo)
                        @if($promo->id == $reservation->promo_id)
                            <option value="{{ $promo->id }}" selected>{{$promo->nama}} - {{$promo->persenDiskon}}% s/d Rp {{$promo->maxDiskon}}</option>
                        @endif
                    @endforeach
                </select>
            @if(Auth::user()->role != 'pelanggan')
            </div>
            @endif

            @if(Auth::user()->role != 'pelanggan')
                <label for="reservation_status">Reservation Status:</label>
                <select name="reservation_status" id="reservation_status">
                    <option value="Belum Dimulai">Belum Dimulai</option>
                    <option value="Sedang Berjalan">Sedang Berjalan</option>
                </select>

                <label for="noMeja">Table Number:</label>
                <input type="number" name="noMeja" id="noMeja" min="1" value="{{$reservation->noMeja}}">
            @endif

            <br>
            <input type="submit" value="Edit" onclick="confirmOrder()">
        </form>
    </div>

    <script>
        var menuIds = @json($orders->pluck('menu_id')->toArray());
        var quantities = @json($orders->pluck('quantity')->toArray());
        var prices = [];
        var names = [];
        var menuCount = 0;
        var userRole = @json(auth()->user()->role ?? ''); // Assuming 'role' is a property of the user model
        initNamePrice();
        updateMenuTable();

        function initNamePrice() {
            for (var i = 0; i < menuIds.length; i++) {
                var menuDropdown = document.getElementById("menu");
                var selectedOption = menuDropdown.options[i];
                var menuName = selectedOption.text.split(" - ")[0];
                var menuPrice = parseFloat(selectedOption.text.split(" - ")[1]);
                prices.push(menuPrice);
                names.push(menuName);
                menuCount++;
            }
        }

        function addMenu() {
            var menuId = document.getElementById("menu").value;
            var quantity = document.getElementById("quantity").value;
            var index = menuIds.indexOf(menuId);

            var menuDropdown = document.getElementById("menu");
            var selectedOption = menuDropdown.options[menuDropdown.selectedIndex];
            var menuName = selectedOption.text.split(" - ")[0];
            var menuPrice = parseFloat(selectedOption.text.split(" - ")[1]);


            console.log("Before Adding Menu:", menuIds, quantities, names, prices);

            if (index !== -1) {
                quantities[index] = parseInt(quantity);
            } else {
                menuIds.push(menuId);
                quantities.push(quantity);
                prices.push(menuPrice);
                names.push(menuName);
            }
            console.log("After Adding Menu:", menuIds, quantities, names, prices);

            updateMenuTable();
            updateTotalPrice();
        }

        function createDeleteFunction(index) {
            return function() {
                menuIds.splice(index, 1);
                quantities.splice(index, 1);
                prices.splice(index, 1);
                names.splice(index, 1);
                menuCount--;

                updateMenuTable();
                updateTotalPrice();
            };
        }

        function updateTotalPrice() {
            var totalPrice = 0;
            var promoValue = 0;

            var promoDropdown = document.getElementById("promo");
            var selectedPromoOption = promoDropdown.options[promoDropdown.selectedIndex];
            var promoDiscount = parseFloat(selectedPromoOption.text.split(" - ")[1].split("%")[0]);
            var promoMaxDiscount = parseFloat(selectedPromoOption.text.split(" s/d Rp ")[1]);

            for (var i = 0; i < menuIds.length; i++) {
                var menuId = menuIds[i];
                var quantity = quantities[i];
                var menuPrice = prices[i];

                var subtotal = menuPrice * quantity;
                totalPrice += subtotal;
            }

            if (promoDiscount > 0) {
                var discount = totalPrice * (promoDiscount / 100);
                promoValue = Math.min(discount, promoMaxDiscount);
            }

            document.getElementById("total_price").value = (totalPrice-promoValue).toFixed(2);
        }


        function updateMenuTable() {
            var menuTableBody = document.getElementById("menu_table");

            menuTableBody.innerHTML = "";

            for (var i = 0; i < menuIds.length; i++) {
                var menuId = menuIds[i];
                var quantity = quantities[i];
                var menuPrice = prices[i];
                var menuName = names[i];

                var row = menuTableBody.insertRow();

                var menuNameCell = row.insertCell(0);
                var menuPriceCell = row.insertCell(1);
                var quantityCell = row.insertCell(2);
                if (userRole == "pelanggan") {
                    var actionCell = row.insertCell(3);
                }

                menuNameCell.innerHTML = menuName;
                menuPriceCell.innerHTML = menuPrice;
                quantityCell.innerHTML = quantity;

                if (userRole == "pelanggan") {
                    var deleteButton = document.createElement("button");
                    deleteButton.innerHTML = "Delete";
                    deleteButton.addEventListener("click", createDeleteFunction(i));
                    actionCell.appendChild(deleteButton);
                }
            }
        }
        function confirmOrder() {
            document.getElementById("menu_ids").value = JSON.stringify(menuIds);
            document.getElementById("quantities").value = JSON.stringify(quantities);
            document.getElementById("menu_count").value = parseFloat(menuCount);

            document.forms[0].submit();
        }
    </script>
@endsection
