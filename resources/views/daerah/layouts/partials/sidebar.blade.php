<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item sidebar-category">
            <p>Navigation</p>
            <span></span>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/dashboard') }}">
                <i class="mdi mdi-view-quilt menu-icon"></i>
                <span class="menu-title">Dashboard</span>
                <div class="badge badge-info badge-pill">2</div>
            </a>
        </li>
        <li class="nav-item sidebar-category">
            <p>Components</p>
            <span></span>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                <i class="mdi mdi-palette menu-icon"></i>
                <span class="menu-title">UI Elements</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link" href="{{ url('ui/buttons') }}">Buttons</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('ui/typography') }}">Typography</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('forms') }}">
                <i class="mdi mdi-view-headline menu-icon"></i>
                <span class="menu-title">Form elements</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('charts') }}">
                <i class="mdi mdi-chart-pie menu-icon"></i>
                <span class="menu-title">Charts</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('tables') }}">
                <i class="mdi mdi-grid-large menu-icon"></i>
                <span class="menu-title">Tables</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('icons') }}">
                <i class="mdi mdi-emoticon menu-icon"></i>
                <span class="menu-title">Icons</span>
            </a>
        </li>
        <li class="nav-item sidebar-category">
            <p>Pages</p>
            <span></span>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
                <i class="mdi mdi-account menu-icon"></i>
                <span class="menu-title">User Pages</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="auth">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link" href="{{ url('auth/login') }}">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('auth/login-2') }}">Login 2</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('auth/register') }}">Register</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('auth/register-2') }}">Register 2</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('auth/lockscreen') }}">Lockscreen</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item sidebar-category">
            <p>Apps</p>
            <span></span>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('docs') }}">
                <i class="mdi mdi-file-document-box-outline menu-icon"></i>
                <span class="menu-title">Documentation</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="http://www.bootstrapdash.com/demo/spica/template/">
                <button class="btn btn-sm btn-danger menu-title">Upgrade to pro</button>
            </a>
        </li>
    </ul>
</nav>