<?php
namespace App\Services;

use App\Models\Menu;

class MenuService {

    private $menus = [];

    public function __construct()
    {
        $menus = Menu::select(['type', 'items'])->where('active', 1)->get();
        foreach($menus as $menu) {
            $this->menus[$menu->type] = $menu->items;
        }
    }

    public function get($type = 'main') {
        return $this->menus[$type] ?? [];
    }
}
