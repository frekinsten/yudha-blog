<div class="main-header">
    <!-- Logo Header -->
    <div class="logo-header" data-background-color="blue">

        <a href="{{ url('main-menu/dashboard') }}" class="logo">
            <img src="https://ui-avatars.com/api/?name=Yudha+Blog&background=FFFFFF&size=45&rounded=true"
                alt="navbar brand" class="mb-1">
            <h3 class="navbar-brand text-white">{{ config('app.name') }}</h3>
        </a>
        <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse"
            data-target="collapse">
            <span class="navbar-toggler-icon">
                <i class="icon-menu"></i>
            </span>
        </button>
        <button class="topbar-toggler more">
            <i class="icon-options-vertical"></i>
        </button>
        <div class="nav-toggle">
            <button class="btn btn-toggle toggle-sidebar">
                <i class="icon-menu"></i>
            </button>
        </div>
    </div>
    <!-- End Logo Header -->

    <!-- Navbar Header -->
    <nav class="navbar navbar-header navbar-expand-lg" data-background-color="blue2">

        <div class="container-fluid">
            <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
                <li class="nav-item dropdown hidden-caret">
                    <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button"
                        data-toggle="dropdown">
                        <i class="fa fa-bell"></i>
                        <span class="notification">
                            {{ auth()->user()->unreadNotifications->count() }}
                        </span>
                    </a>
                    <ul class="dropdown-menu notif-box animated fadeIn">
                        <li>
                            <div class="dropdown-title d-flex justify-content-between align-items-center">
                                {{ auth()->user()->unreadNotifications->count() }} notifikasi baru
                            </div>
                        </li>
                        <li>
                            <div class="notif-scroll scrollbar-outer">
                                <div class="card m-0">
                                    <div class="card-body py-0 px-3">
                                        <div class="card-list p-0">
                                            @forelse ($notifications as $notification)
                                                @if (auth()->user()->hasRole('Admin'))
                                                    <div class="item-list">
                                                        <div class="info-user">
                                                            <div class="name">
                                                                New user: <b>{{ $notification->data['name'] }}</b>
                                                            </div>
                                                            <div class="status">
                                                                {{ $notification->created_at->format('d-m-Y H:i:s') }}
                                                            </div>
                                                        </div>
                                                        <button
                                                            class="btn btn-icon btn-success btn-round btn-xs mark-as-read"
                                                            data-id="{{ $notification->id }}">
                                                            <i class="fa fa-check"></i>
                                                        </button>
                                                    </div>
                                                @endif
                                            @empty
                                                <div class="item-list">
                                                    <div class="info-user">
                                                        <div class="name">Tidak Ada</div>
                                                    </div>
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <a class="see-all" href="javascript:void(0);" id="mark-all">
                                <i class="fa fa-check"> Tandai dibaca semua</i>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item dropdown hidden-caret">
                    <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#">
                        <div class="avatar-sm">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=random"
                                alt="..." class="avatar-img rounded-circle">
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-user animated fadeIn">
                        <div class="dropdown-user-scroll scrollbar-outer">
                            <li>
                                <div class="user-box">
                                    <div class="avatar-lg">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=random"
                                            alt="image profile" class="avatar-img rounded">
                                    </div>
                                    <div class="u-text">
                                        <h4>{{ auth()->user()->name }}</h4>
                                        <p class="text-muted">{{ auth()->user()->email }}</p>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ url('/') }}">Home</a>
                                <div class="dropdown-divider"></div>
                                <form action="{{ url('auth/logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-md dropdown-item py-1">
                                        Logout
                                    </button>
                                </form>
                            </li>
                        </div>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
    <!-- End Navbar -->
</div>

@push('scripts')
    @if (auth()->user()->hasRole('Admin'))
        <script>
            function sendMarkRequest(id = null) {
                return $.ajax({
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    url: "{{ url('mark-notification') }}",
                    data: {
                        id: id
                    }
                });
            }

            $(document).ready(function() {
                $('.mark-as-read').click(function() {
                    let request = sendMarkRequest($(this).data('id'));
                    request.done(() => {
                        $(this).parents('div.item-list').remove();
                        location.reload();
                    });
                });

                $('#mark-all').click(function() {
                    let request = sendMarkRequest();
                    request.done(() => {
                        $('div.item-list').remove();
                        location.reload();
                    })
                });
            });
        </script>
    @endif
@endpush
