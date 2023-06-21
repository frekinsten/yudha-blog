<header class="navigation">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <nav class="navbar navbar-expand-lg p-0">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <h2 class="mb-0">{{ config('app.name') }}</h2>
                    </a>

                    <button class="navbar-toggler collapsed" type="button" data-toggle="collapse"
                        data-target="#navbarsExample09" aria-controls="navbarsExample09" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="ion-android-menu"></span>
                    </button>

                    <div class="collapse navbar-collapse ml-auto" id="navbarsExample09">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item {{ request()->is('posts') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ url('posts') }}">Home</a>
                            </li>
                            <li class="nav-item dropdown @@blog">
                                <a class="nav-link dropdown-toggle" href="#" id="dropdown03"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Blog <span class="ion-ios-arrow-down"></span>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="dropdown03">
                                    <li class="dropdown dropdown-submenu dropleft">
                                        <a class="dropdown-item dropdown-toggle" href="#!" id="dropdown0301"
                                            role="button" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">Kategori</a>

                                        <ul class="dropdown-menu" aria-labelledby="dropdown0301">
                                            @foreach ($categories as $category)
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ url('posts?category=' . $category->slug) }}">
                                                        {{ $category->category_name }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>

                                    <li class="dropdown dropdown-submenu dropleft">
                                        <a class="dropdown-item dropdown-toggle" href="#!" id="dropdown0301"
                                            role="button" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">Tag</a>

                                        <ul class="dropdown-menu" aria-labelledby="dropdown0301">
                                            @foreach ($tags as $tag)
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ url('posts?tag=' . $tag->slug) }}">
                                                        {{ $tag->tag_name }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            @auth
                                <li class="nav-item dropdown @@pages">
                                    <a class="nav-link dropdown-toggle" href="#" id="dropdown05"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Welcome back {{ auth()->user()->name }} <span class="ion-ios-arrow-down"></span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item @@dashboard"
                                                href="{{ url('main-menu/dashboard') }}">
                                                Dashboard
                                            </a>
                                        </li>
                                        <li>
                                            <form action="{{ url('auth/logout') }}" method="POST">
                                                @csrf
                                                <button type="submit" class="dropdown-item">
                                                    Logout
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                            @else
                                <li class="nav-item @@login">
                                    <button class="btn btn-primary btn-round ml-auto" data-toggle="modal"
                                        data-target="#modalLoginRegister">
                                        Login
                                    </button>
                                </li>
                            @endauth
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</header>
