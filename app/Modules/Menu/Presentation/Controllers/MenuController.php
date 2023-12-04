<?php

namespace App\Modules\Menu\Presentation\Controllers;

use App\Modules\Menu\Core\Application\Service\MenuService;
use Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class MenuController
{
    private $formData = [];
    private $menuService;

    public function __construct(MenuService $menuService)
    {
        $this->menuService = $menuService;
    }

    public function index()
    {
        $menus = $this->menuService->getAllMenus();
        
        return view('menu::index', compact('menus'));
    }

    public function create()
    {
        return view ('menu::create');
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
        $filename = 'storage/assets/img/menu/' . basename($imagePath);

        $data = [
            'nama' => $request->input('name'),
            'harga' => $request->input('price'),
            'deskripsi' => $request->input('description'),
            'pathFoto' => $filename,
        ];

        $this->menuService->createMenu($data);

        Cache::forget('menus');

        return redirect()->route('menu.index')->with('success', 'Menu has been created!');
    }

    public function edit($id)
    {
        $menu = $this->menuService->getMenuById($id);
        return view('menu::edit', compact('menu'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'max:255',
            'price' => 'numeric',
            'image' => 'image|file|max:2048',
        ]);

        $menu = $this->menuService->getMenuById($id);

        $data = [
            'nama' => $request->input('name', $menu->nama),
            'harga' => $request->input('price', $menu->harga),
            'deskripsi' => $request->input('description', $menu->deskripsi),
        ];

        if ($request->file('image')) {
            $old_imagePath = 'storage/assets/img/menu/' . $menu->pathFoto;
            $new_imagePath = $request->file('image')->store('public/assets/img/menu');
            $filename = basename($new_imagePath);
            $data['pathFoto'] = $filename;
            if (File::exists($old_imagePath))
            {
                File::delete($old_imagePath);
            }
        }
        
        $this->menuService->updateMenu($id, $data);

        Cache::forget('menus');

        return redirect()->route('menu.index')->with('success', 'Menu has been updated');    
    }

    public function destroy($id)
    {
        $this->menuService->deleteMenu($id);

        Cache::forget('menus');
    
        return redirect()->route('menu.index')->with('success', 'Menu deleted successfully');
    }
}
