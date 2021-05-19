@if(auth()->user()->role_id == 1)
    <li class="nav-item">
        <div class="menu-title">
            <div>Developer Tools</div>
        </div>
    </li>
    <li class="nav-item{{ $admiko_data['sideBarActive'] === "admikoImport" ? " active" : "" }}">
        <a class="nav-link" href="{{route("dashboard.admiko_page_import")}}"><i class="fas fa-tools fa-fw"></i>Page Import</a>
    </li>
    <li class="nav-item{{ $admiko_data['sideBarActive'] === "admikoAdmins" ? " active" : "" }}">
        <a class="nav-link" href="{{route("dashboard.admins.index")}}"><i class="fas fa-users fa-fw"></i>Admin Users</a>
    </li>
    <li class="nav-item{{ $admiko_data['sideBarActive'] === "admiko_auditable_logs" ? " active" : "" }}">
        <a class="nav-link" href="{{route('dashboard.admiko_auditable_logs.index')}}"><i class="fas fas fa-filter fa-fw fa-fw"></i>Auditable Logs</a>
    </li>
@endif