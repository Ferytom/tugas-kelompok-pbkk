<?php

namespace App\Modules\Menu\Infrastructure\Repository;
use App\Modules\Menu\Core\Domain\Repository\MenuRepository;
use Cache;
use Illuminate\Support\Facades\File;
use App\Modules\Shared\Core\Domain\Model\Menu;
use Illuminate\Database\Eloquent\Collection;


class EloquentMenuRepository implements MenuRepository
{
    public function getAllMenus(): Collection
    {
        $menus = Cache::remember('menus', 120, function () {
            return Menu::all();
        });

        return $menus;
    }

    public function createMenu(array $data): Menu
    {
        return Menu::create($data);
    }

    public function getMenuById(int $menuId): Menu
    {
        $menu = Menu::findOrFail($menuId);
        return $menu;
    }

    public function updateMenu(int $menuId, array $data): Menu
    {
        $menu = Menu::findOrFail($menuId);
        $menu->update($data);
        return $menu;
    }

    public function deleteMenu(int $menuId): void
    {
        $menu = Menu::findOrFail($menuId);
        $imagePath = 'storage/assets/img/menu/' . $menu->pathFoto;
        $menu->delete();
        if (File::exists($imagePath))
        {
            File::delete($imagePath);
        }
    }
}
