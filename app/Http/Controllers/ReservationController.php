<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class ReservationController extends Controller
{
    private $formData = [];
    public function index()
    {
        return view('reservation.index');
    }

    public function create()
    {
        return view ('reservation.create');
    }

    public function store(Request $request)
    {
        return redirect()->route('reservation.index')->with('success', 'Reservation has been created!');
    }

    public function edit($id)
    {
        return view('reservation.edit');
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('reservation.index')->with('success', 'Reservation has been updated');    
    }

    public function destroy($id)
    {    
        return redirect()->route('reservation.index')->with('success', 'Reservation deleted successfully');
    }
}
