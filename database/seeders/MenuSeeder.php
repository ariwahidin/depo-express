<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Master Data

        $parent_menu = \App\Models\ParentMenu::create(
            [
                'name' => 'Master Data',
                'prefix' => 'wms/master*',
                'icon' => 'menu-icon tf-icons ti ti-layout-grid',
            ]
        );

        $menuSupplier = \App\Models\Menu::create(
            [
                'parent_menu_id' => $parent_menu->id,
                'route_name' => 'supplier',
                'icon' => '',
                'name' => 'Supplier',
                'route' => '/supplier',
            ],
        );

        $menuCustomer = \App\Models\Menu::create(
            [
                'parent_menu_id' => $parent_menu->id,
                'route_name' => 'customer',
                'icon' => '',
                'name' => 'Customer',
                'route' => '/customer',
            ],
        );

        $menuCategory = \App\Models\Menu::create(
            [
                'parent_menu_id' => $parent_menu->id,
                'route_name' => 'category',
                'icon' => '',
                'name' => 'Category',
                'route' => '/category',
            ],
        );

        $menuItem = \App\Models\Menu::create(
            [
                'parent_menu_id' => $parent_menu->id,
                'route_name' => 'item',
                'icon' => '',
                'name' => 'Item',
                'route' => '/item',
            ],
        );

        $menuTransporter = \App\Models\Menu::create(
            [
                'parent_menu_id' => $parent_menu->id,
                'route_name' => 'transporter',
                'icon' => '',
                'name' => 'Transporter',
                'route' => '/transporter',
            ],
        );

        $menuTruckSize = \App\Models\Menu::create(
            [
                'parent_menu_id' => $parent_menu->id,
                'route_name' => 'truck-size',
                'icon' => '',
                'name' => 'Truck Size',
                'route' => '/truck-size',
            ],
        );

        $menuWarehouse = \App\Models\Menu::create(
            [
                'parent_menu_id' => $parent_menu->id,
                'route_name' => 'warehouse',
                'icon' => '',
                'name' => 'Warehouse',
                'route' => '/warehouse',
            ],
        );

        // Inbound Section
        $inboundMenu  = \App\Models\ParentMenu::create(
            [
                'name' => 'Inbound',
                'prefix' => 'wms/receiving*',
                'icon' => 'menu-icon tf-icons ti ti-layout-grid',
            ]
        );

        $menuInbound = \App\Models\Menu::create(
            [
                'parent_menu_id' => $inboundMenu->id,
                'route_name' => 'inbound',
                'icon' => '',
                'name' => 'List Inbound',
                'route' => '/inbound',
            ],
        );

        $menuInboundCreate = \App\Models\Menu::create(
            [
                'parent_menu_id' => $inboundMenu->id,
                'route_name' => 'inbound-create',
                'icon' => '',
                'name' => 'Create Inbound',
                'route' => '/inbound/create',
            ],
        );

        // Inbound Section
        $outboundMenu  = \App\Models\ParentMenu::create(
            [
                'name' => 'Outbound',
                'prefix' => 'wms/shipment*',
                'icon' => 'menu-icon tf-icons ti ti-layout-grid',
            ]
        );

        $menuOutbound = \App\Models\Menu::create(
            [
                'parent_menu_id' => $outboundMenu->id,
                'route_name' => 'outbound',
                'icon' => '',
                'name' => 'List Outbound',
                'route' => '/outbound',
            ],
        );

        $menuOutboundCreate = \App\Models\Menu::create(
            [
                'parent_menu_id' => $outboundMenu->id,
                'route_name' => 'outbound-create',
                'icon' => '',
                'name' => 'Create Outbound',
                'route' => '/outbound/create',
            ],
        );

        // Inventory Section
        $inventoryMenu  = \App\Models\ParentMenu::create(
            [
                'name' => 'Inventory',
                'prefix' => 'wms/inventory*',
                'icon' => 'menu-icon tf-icons ti ti-layout-grid',
            ]
        );

        $menuInventoryStock = \App\Models\Menu::create(
            [
                'parent_menu_id' => $inventoryMenu->id,
                'route_name' => 'inventory-stock',
                'icon' => '',
                'name' => 'Stock',
                'route' => '/stock',
            ],
        );
    }
}
