<li class="nav-item {{ active_class(['admin/dashboard']) }}">
    <a href="{{ route('adminDashboard') }}" class="nav-link">
        <i class="link-icon" data-feather="box"></i>
        <span class="link-title">داشبورد</span>
    </a>
</li>
@if (checkAcl('admin-list'))
    <li class="nav-item {{ active_class_with_route(['admins.show','admins.index','admins.create','admins.store','admins.update','admins.changeStatus','admins.destroy','admins.edit']) }}">
        <a href="{{ url('/admin/admins') }}" class="nav-link">
            <i class="link-icon" data-feather="user"></i>
            <span class="link-title">ادمین ها</span>
        </a>
    </li>
@endif


@if(checkAcl('role-list') || checkAcl('permission-list'))
    <li class="nav-item nav-category">مدیریت دسترسی و نقش</li>
@endif
@if (checkAcl('role-list'))
    <li class="nav-item {{ active_class_with_route(['roles.show','roles.index','roles.create','roles.store','roles.update','roles.changeStatus','roles.destroy','roles.edit']) }}">
        <a href="{{ url('/admin/roles') }}" class="nav-link">
            <i class="link-icon" data-feather="user-check"></i>
            <span class="link-title">نقش ها</span>
        </a>
    </li>
@endif()

@if (checkAcl('permission-list'))
    <li class="nav-item {{ active_class(['admin/permissions']) }}">
        <a href="{{ url('/admin/permissions') }}" class="nav-link">
            <i class="link-icon" data-feather="layers"></i>
            <span class="link-title">دسترسی ها</span>
        </a>
    </li>
@endif
