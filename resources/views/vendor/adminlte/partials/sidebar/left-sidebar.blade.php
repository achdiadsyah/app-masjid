<aside class="main-sidebar {{ config('adminlte.classes_sidebar', 'sidebar-dark-primary elevation-4') }}">

    {{-- Sidebar brand logo --}}
    @if(config('adminlte.logo_img_xl'))
        @include('adminlte::partials.common.brand-logo-xl')
    @else
        @include('adminlte::partials.common.brand-logo-xs')
    @endif

    {{-- Sidebar menu --}}
    <div class="sidebar">
        <nav class="pt-2">
            <ul class="nav nav-pills nav-sidebar flex-column {{ config('adminlte.classes_sidebar_nav', '') }}"
                data-widget="treeview" role="menu"
                @if(config('adminlte.sidebar_nav_animation_speed') != 300)
                    data-animation-speed="{{ config('adminlte.sidebar_nav_animation_speed') }}"
                @endif
                @if(!config('adminlte.sidebar_nav_accordion'))
                    data-accordion="false"
                @endif>
                {{-- Configured sidebar links --}}
                @each('adminlte::partials.sidebar.menu-item', $adminlte->menu('sidebar'), 'item')
                @if(auth()->user()->user_level == "admin")
                <li class="nav-header ">
                    SETTING
                </li>
                <li class="nav-item">
                    <a class="nav-link  " href="{{route('setting.app')}}">                
                        <i class="fas fa-fw fa-cog "></i>
                        <p>App Setting</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  " href="{{route('setting.user')}}">                
                        <i class="fas fa-fw fa-cog "></i>
                        <p>User Management</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  " href="{{route('setting.running-text')}}">                
                        <i class="fas fa-fw fa-cog "></i>
                        <p>Running Text</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  " href="{{route('setting.wallpaper-gallery')}}">                
                        <i class="fas fa-fw fa-cog "></i>
                        <p>Wallpaper / Gallery</p>
                    </a>
                </li>
                @endif
                <li class="nav-header ">
                    SHORTCUT
                </li>
                <li class="nav-item">
                    <a class="nav-link  " href="{{route('display')}}">                
                        <i class="fas fa-fw fa-desktop "></i>
                        <p>TV Display</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

</aside>
