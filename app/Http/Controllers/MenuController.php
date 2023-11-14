<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Cache;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Cache::remember('menus', 120, function () {
            return Menu::all();
        });
        
        return view('menu.index', compact('menus'));
    }
}
