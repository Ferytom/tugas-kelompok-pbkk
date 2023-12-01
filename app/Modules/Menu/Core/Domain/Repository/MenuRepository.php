<?php

namespace App\Modules\Menu\Core\Domain\Repository;

use App\Modules\Shared\Core\Domain\Model\Menu;
use Illuminate\Database\Eloquent\Collection;

interface MenuRepository
{
    public function getAllMenus(): Collection;

    public function getMenuById(int $menuId): Menu;

    public function createMenu(array $data): Menu;

    public function updateMenu(int $menuId, array $data): Menu;

    public function deleteMenu(int $menuId): void;
}
