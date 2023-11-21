@extends('master')
@section('content')
    <h1>Edit Transaction</h1>
    <div class="form-container">
        <form action="{{ route('transaction.update', $transaction->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <label for="user">Member:</label>
            <select name="user" id="user">
                @foreach($members as $member)
                    @if($member->id == $transaction->user_id)
                        <option value="{{$member->id}}" selected>{{$member->nama}}</option>
                    @endif
                    @if($member->id != $transaction->user_id)
                        <option value="{{$member->id}}">{{$member->nama}}</option>
                    @endif
                @endforeach
            </select>
            @error('user')
                <span class="text-xs text-red-600">{{ $message }}</span>
            @enderror

            <label for="address">Restaurant Location:</label>
            <select name="address" id="address">
                @foreach($locations as $location)
                    @if($location->id == $transaction->location_id)
                        <option value="{{ $location->id }}" selected>{{ $location->alamat }}</option>
                    @endif
                @endforeach
            </select>
            @error('address')
                <span class="text-xs text-red-600">{{ $message }}</span>
            @enderror
            
            <label for="total_price">Total Price:</label>
            <input type="text" name="total_price" id="total_price" readonly value="{{$transaction->hargaTotal}}">
            @error('total_price')
                <span class="text-xs text-red-600">{{ $message }}</span>
            @enderror
            
            <label for="notes">Extra Notes:</label>
            <textarea name="notes" id="notes" style="width:100%">{{$transaction->keterangan}}</textarea>
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
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="menu_table">
                    <!-- Selected menus will be populated dynamically -->
                </tbody>
            </table>
            
            <label for="menu">Menu:</label>
            <select name="menu" id="menu">
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

            <input type="hidden" name="menu_ids[]" id="menu_ids" value="">
            <input type="hidden" name="quantities[]" id="quantities" value="">

            <label for="promo">Promo:</label>
            <select name="promo" id="promo" onchange="updateTotalPrice()">
                @foreach($promos as $promo)
                    <option value="{{$promo->id}}">{{$promo->detail}} - {{$promo->persenDiskon}}% s/d Rp {{$promo->maxDiskon}}</option>
                @endforeach
            </select>

            <label for="reservation_status">Reservation Status:</label>
            <select name="reservation_status" id="reservation_status">
                <option value="Belum Dimulai">Belum Dimulai</option>
                <option value="Sedang Berjalan">Sedang Berjalan</option>
                <option value="Selesai">Selesai</option>
            </select>

            <label for="noMeja">Table Number:</label>
            <input type="number" name="noMeja" id="noMeja" min="1">

            <br>
            <input type="submit" value="Create" onclick="confirmOrder()">
        </form>
    </div>

    <script>
        var menuIds = @json($orders->pluck('menu_id')->toArray());
        var quantities = @json($orders->pluck('quantity')->toArray());
        updateMenuTable();

        function addMenu() {
            var menuId = document.getElementById("menu").value;
            var quantity = document.getElementById("quantity").value;
            var index = menuIds.indexOf(menuId);

            if (index !== -1) {
                quantities[index] = parseInt(quantity);
            } else {
                menuIds.push(menuId);
                quantities.push(quantity);
            }

            updateMenuTable();
            updateTotalPrice();
        }

        function createDeleteFunction(index) {
            return function() {
                menuIds.splice(index, 1);
                quantities.splice(index, 1);

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

                var menuDropdown = document.getElementById("menu");
                var selectedOption = menuDropdown.options[menuDropdown.selectedIndex];
                var menuPrice = parseFloat(selectedOption.text.split(" - ")[1]);

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

                var menuDropdown = document.getElementById("menu");
                var selectedOption = menuDropdown.options[menuDropdown.selectedIndex];
                var menuName = selectedOption.text.split(" - ")[0];
                var menuPrice = selectedOption.text.split(" - ")[1];

                var row = menuTableBody.insertRow();

                var menuNameCell = row.insertCell(0);
                var menuPriceCell = row.insertCell(1);
                var quantityCell = row.insertCell(2);
                var actionCell = row.insertCell(3);

                menuNameCell.innerHTML = menuName;
                menuPriceCell.innerHTML = menuPrice;
                quantityCell.innerHTML = quantity;

                var deleteButton = document.createElement("button");
                deleteButton.innerHTML = "Delete";
                deleteButton.addEventListener("click", createDeleteFunction(i));

                actionCell.appendChild(deleteButton);
            }
        }
        function confirmOrder() {
            document.getElementById("menu_ids").value = JSON.stringify(menuIds);
            document.getElementById("quantities").value = JSON.stringify(quantities);

            document.forms[0].submit();
        }
    </script>
@endsection
