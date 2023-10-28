@if(checkAcl('category-list') || checkAcl('article-list'))
    <li class="nav-item nav-category">مدیریت مقالات</li>
@endif()


@if (checkAcl('category-list'))
    <li class="nav-item {{ active_class_with_route(['category.show','category.index','category.create','category.store','category.update','category.destroy','category.edit']) }}">
        <a href="{{ url('/admin/category') }}" class="nav-link">
            <i class="link-icon" data-feather="grid"></i>
            <span class="link-title">دسته بندی ها</span>
        </a>
    </li>
@endif()




