<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class MenuController extends Controller
{
    private $formData = [];
    public function index()
    {
        $menus = Cache::remember('menus', 120, function () {
            return Menu::all();
        });
        
        return view('menu.index', compact('menus'));
    }

    public function create()
    {
        return view ('menu.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
            'image' => 'required|image|file|max:2048',
        ]);

        $imagePath = $request->file('image')->store('public/assets/img/menu');
        $filename = basename($imagePath);

        $this->formData['nama'] = $request->input('name');
        $this->formData['harga'] = $request->input('price');
        $this->formData['deskripsi'] = $request->input('description');
        $this->formData['pathFoto'] = $filename;

        Menu::create($this->formData);

        Cache::forget('menus');

        return redirect()->route('menu.index')->with('success', 'Menu has been created!');
    }

    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        return view('menu.edit', compact('menu'));
    }

    public function update(Request $request, $id)
    {
        $menu = Menu::find($id);

        if ($request->input('name'))
        {
            $menu->nama = $request->input('name');
        }
        if ($request->input('deskripsi'))
        {
            $menu->deskripsi = $request->input('description');
        }
        if ($request->input('harga'))
        {
            $menu->harga = $request->input('price');
        }
        if ($request->file('image')) {
            $old_imagePath = 'storage/assets/img/menu/' . $menu->pathFoto;
            $new_imagePath = $request->file('image')->store('public/assets/img/menu');
            $filename = basename($new_imagePath);
            $menu->pathFoto = $filename;
            if (File::exists($old_imagePath))
            {
                File::delete($old_imagePath);
            }
        }
        
        $menu->save();
        Cache::forget('menus');
        return redirect()->route('menu.index')->with('success', 'Menu has been updated');    
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $imagePath = 'storage/assets/img/menu/' . $menu->pathFoto;
        $menu->delete();
        if (File::exist($imagePath))
        {
            File::delete($imagePath);
        }

        Cache::forget('menus');
    
        return redirect()->route('menu.index')->with('success', 'Menu deleted successfully');
    
    }
}
