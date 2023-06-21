<div class="sidebar sidebar-style-2">
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <div class="user">
                <div class="avatar-sm float-left mr-2">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=random"
                        alt="..." class="avatar-img rounded-circle">
                </div>
                <div class="info">
                    <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                        <span>
                            {{ auth()->user()->name }}
                            <span class="user-level">{{ auth()->user()->getRoleNames()->first() }}</span>
                            <span class="caret"></span>
                        </span>
                    </a>
                    <div class="clearfix"></div>

                    <div class="collapse in" id="collapseExample">
                        <ul class="nav">
                            <li>
                                <a href="{{ url('/') }}">
                                    <span class="link-collapse">Home</span>
                                </a>
                            </li>
                            <li>
                                <form action="{{ url('auth/logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn link-collapse dropdown-item pl-0">
                                        Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <ul class="nav nav-primary">
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Main Menu</h4>
                </li>
                <li class="nav-item {{ request()->is('main-menu/dashboard') ? 'active' : '' }}">
                    <a href="{{ url('main-menu/dashboard') }}">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Master Data</h4>
                </li>
                <li class="nav-item {{ request()->is('master-data/categories') ? 'active' : '' }}">
                    <a href="{{ url('master-data/categories') }}">
                        <i class="fas fa-layer-group"></i>
                        <p>Kategori</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->is('master-data/tags') ? 'active' : '' }}">
                    <a href="{{ url('master-data/tags') }}">
                        <i class="fas fa-tags"></i>
                        <p>Tag</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->is('master-data/posts*') ? 'active' : '' }}">
                    <a href="{{ url('master-data/posts') }}">
                        <i class="fas fa-newspaper"></i>
                        <p>Post</p>
                    </a>
                </li>

                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Manajemen</h4>
                </li>
                <li class="nav-item {{ request()->is('management-users') ? 'active' : '' }}">
                    <a href="{{ url('management-users') }}">
                        <i class="fas fa-users"></i>
                        <p>User</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
