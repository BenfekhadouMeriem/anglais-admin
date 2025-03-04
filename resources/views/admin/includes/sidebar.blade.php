<!-- Sidebar -->
<div class="sidebar" id="sidebar">
	<div class="sidebar-inner slimscroll" style="background: rgba(245, 144, 164, 0.4);">
		<div id="sidebar-menu" class="sidebar-menu">
			
		<ul>
				<li class="menu-title"> 
					<span>Main</span>
				</li>

				<li class="submenu">
					<a href="#"><i class="fe fe-star-o"></i> <span> Users</span> <span class="fas fa-chevron-down"></span></a>
					<ul style="display: none;">
						<li><a class="{{ route_is('users.*') ? 'active' : '' }}" href="{{route('admin.users.index')}}">Users</a></li>
						<li><a class="{{ route_is('users.create') ? 'active' : '' }}" href="{{route('admin.users.create')}}">Add user</a></li>
					</ul>
				</li>

				<li class="submenu">
					<a href="#"><i class="fe fe-star-o"></i> <span> Podcast</span> <span class="fas fa-chevron-down"></span></a>
					<ul style="display: none;">
						<li><a class="{{ route_is('contents.*') ? 'active' : '' }}" href="{{route('admin.contents.index')}}">Vidéo</a></li>
						<li><a class="{{ route_is('contents.create') ? 'active' : '' }}" href="{{route('admin.contents.create')}}">Add Vidéo</a></li>
					</ul>
				</li>


				<li class="submenu">
					<a href="#"><i class="fe fe-star-o"></i> <span> Vidéo</span> <span class="fas fa-chevron-down"></span></a>
					<ul style="display: none;">
						<li><a class="{{ route_is('videos.*') ? 'active' : '' }}" href="{{route('admin.videos.index')}}">Vidéo</a></li>
						<li><a class="{{ route_is('videos.create') ? 'active' : '' }}" href="{{route('admin.videos.create')}}">Add Vidéo</a></li>
					</ul>
				</li>
				
			</ul>
		</div>
	</div>
</div><!-- Visit codeastro.com for more projects -->
<!-- /Sidebar -->