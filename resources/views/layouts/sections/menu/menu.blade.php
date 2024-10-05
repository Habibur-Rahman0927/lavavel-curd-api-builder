<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item"> <a class="nav-link " href="index.html"> <i class="bi bi-grid"></i> <span>Dashboard</span> </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#users-nav" data-bs-toggle="collapse" href="#"> <i
                    class="bi bi-menu-button-wide"></i><span>User</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="users-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li> 
                    <a href="{{ route('user.index') }}"> <i class="bi bi-circle"></i><span>List</span> </a>
                </li>
                <li> 
                    <a href="{{ route('user.create') }}"> <i class="bi bi-circle"></i><span>Create</span> </a>
                </li>
            </ul>
        </li>
        {{-- <li class="nav-heading">Pages</li> --}}
    </ul>
</aside>
