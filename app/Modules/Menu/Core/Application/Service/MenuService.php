<?php

namespace App\Modules\Menu\Core\Application\Service;

use App\Modules\Menu\Core\Domain\Repository\MenuRepository;
use App\Modules\Shared\Core\Domain\Model\Menu;
use Illuminate\Database\Eloquent\Collection;

class MenuService
{
    private $menuRepository;

    public function __construct(MenuRepository $menuRepository)
    {
        $this->menuRepository = $menuRepository;
    }

    public function getAllMenus(): Collection
    {
        return $this->menuRepository->getAllMenus();
    }

    public function createMenu($data): Menu
    {
        return $this->menuRepository->createMenu($data);
    }

    public function getMenuById($menuId): Menu
    {
        return $this->menuRepository->getMenuById($menuId);
    }

    public function updateMenu($menuId, $data): Menu
    {
        return $this->menuRepository->updateMenu($menuId, $data);
    }

    public function deleteMenu($menuId): void
    {
        $this->menuRepository->deleteMenu($menuId);
    }
}

