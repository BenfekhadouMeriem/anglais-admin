<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title">
                    <span>Main</span>
                </li>

                <!-- Users Submenu -->
                <li class="submenu {{ route_is('users.*') ? 'open' : '' }}">
                    <a href="#"><i class="fe fe-users"></i> <span> Users</span> <span class="fas fa-chevron-down"></span></a>
                    <ul style="display: {{ route_is('users.*') ? 'block' : 'none' }};">
                        <li><a class="{{ route_is('admin.users.index') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">Users</a></li>
                        <li><a class="{{ route_is('admin.users.create') ? 'active' : '' }}" href="{{ route('admin.users.create') }}">Add user</a></li>
                    </ul>
                </li>

                <!-- Category Submenu -->
                <li class="submenu {{ route_is('category.*') ? 'open' : '' }}">
                    <a href="#"><i class="fas fa-list" style="font-size: 19px;"></i> <span>Category</span> <span class="fas fa-chevron-down"></span></a>
                    <ul style="display: {{ route_is('category.*') ? 'block' : 'none' }};">
                        <li><a class="{{ route_is('admin.category.index') ? 'active' : '' }}" href="{{ route('admin.category.index') }}">Category</a></li>
                        <li><a class="{{ route_is('admin.category.create') ? 'active' : '' }}" href="{{ route('admin.category.create') }}">Add Category</a></li>
                    </ul>
                </li>

                <!-- Podcast Submenu -->
                <li class="submenu {{ route_is('contents.*') ? 'open' : '' }}">
                    <a href="#"><i class="fas fa-microphone-alt" style="font-size: 19px; padding-left: 2px;"></i> <span> Podcast</span> <span class="fas fa-chevron-down"></span></a>
                    <ul style="display: {{ route_is('contents.*') ? 'block' : 'none' }};">
                        <li><a class="{{ route_is('admin.contents.index') ? 'active' : '' }}" href="{{ route('admin.contents.index') }}">Podcast</a></li>
                        <li><a class="{{ route_is('admin.contents.create') ? 'active' : '' }}" href="{{ route('admin.contents.create') }}">Add Podcast</a></li>
                    </ul>
                </li>

                <!-- Favorite Submenu -->
                <li class="submenu {{ route_is('admin.favorites.index') ? 'open' : '' }}">
                    <a href="#"><i class="fe fe-heart"></i> <span> Favorite</span> <span class="fas fa-chevron-down"></span></a>
                    <ul style="display: {{ route_is('admin.favorites.index') ? 'block' : 'none' }};">
                        <li><a class="{{ route_is('admin.favorites.index') ? 'active' : '' }}" href="{{ route('admin.favorites.index') }}">Favorite</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- /Sidebar -->
