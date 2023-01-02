<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
            <a href="/docs" class="nav-link">
                <i class="nav-icon fas fa-code"></i>
                <p>
                    Api Docs
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('users.index') }}" class="nav-link">
                <i class="nav-icon fas fa-user"></i>
                <p>
                    Users
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('users.create') }}" class="nav-link">
                <i class="nav-icon fas fa-plus"></i>
                <p>
                    Add User
                </p>
            </a>
        </li>
    </ul>
</nav>
