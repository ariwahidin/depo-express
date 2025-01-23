<div class="menu-inner py-1">

    @foreach(\App\Models\ParentMenu::all() as $parent_menu)
    <li class="menu-item {{ Request::is($parent_menu->prefix) ? 'active open' : '' }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="{{ $parent_menu->icon }}"></i>
            <div data-i18n="{{ $parent_menu->name }}">{{ $parent_menu->name }}</div>
        </a>
        <ul class="menu-sub">
            @foreach(\App\Models\Menu::where('parent_menu_id', $parent_menu->id)->get() as $menu)
            <li class="menu-item {{ Request::routeIs($menu->route_name) ? 'active' : '' }}">
                <a wire:navigate href="{{ route($menu->route_name) }}" class="menu-link btn-page-block">
                    <div data-i18n="{{ $menu->name }}">{{ $menu->name }}</div>
                </a>
            </li>
            @endforeach
        </ul>
    </li>
    @endforeach

    <!-- <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons ti ti-layout-sidebar"></i>
            <div data-i18n="Menu">Menu</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item {{ Request::routeIs('home') ? 'active' : '' }}">
                <a wire:navigate href="{{ route('home') }}" class="menu-link">
                    <div data-i18n="Home">Home</div>
                </a>
            </li>
            <li class="menu-item {{ Request::routeIs('category') ? 'active' : '' }}">
                <a wire:navigate.hover href="{{ route('category')."?id=".Str::random(10) }}" }}" class="menu-link">
                    <div data-i18n="Category">Category</div>
                </a>
            </li>
            <li class="menu-item {{ Request::routeIs('product') ? 'active' : '' }}">
                <a wire:navigate.hover href="{{ route('product')."?id=".Str::random(10) }}" class="menu-link">
                    <div data-i18n="Product">Product</div>
                </a>
            </li>
            <li class="menu-item {{ Request::routeIs('post') ? 'active' : '' }}">
                <a wire:navigate href="{{ route('post') }}" class="menu-link">
                    <div data-i18n="Post">Post</div>
                </a>
            </li>
            <li class="menu-item {{ Request::routeIs('shop') ? 'active' : '' }}">
                <a wire:navigate href="{{ route('shop') }}" class="menu-link">
                    <div data-i18n="Shop">Shop</div>
                </a>
            </li>
            <li class="menu-item {{ Request::routeIs('good-receipt') ? 'active' : '' }}">
                <a wire:navigate href="{{ route('good-receipt') }}" class="menu-link">
                    <div data-i18n="Good Receipt">Good Receipt</div>
                </a>
            </li>
            <li class="menu-item {{ Request::routeIs('inventory') ? 'active' : '' }}">
                <a wire:navigate href="{{ route('inventory') }}" class="menu-link">
                    <div data-i18n="Inventory">Inventory</div>
                </a>
            </li>
        </ul>
    </li> -->

</div>