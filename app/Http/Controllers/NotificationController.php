<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Cache;

class NotificationController extends Controller
{
    public function index()
    {   
        return view('notification.index');
    }
}
