<footer class="footer">
    <div class="container-fluid">
        <nav class="pull-left">
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/') }}">
                        {{ config('app.name') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        Help
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        Licenses
                    </a>
                </li>
            </ul>
        </nav>
        <div class="copyright ml-auto">
            {{ now()->year }}, made with <i class="fa fa-heart heart text-danger"></i> by
            <a href="{{ url('/') }}">{{ config('app.name') }}</a>
        </div>
    </div>
</footer>
