{{--@if(checkAcl('category-list') || checkAcl('article-list-list'))--}}
{{--    <li class="nav-item nav-category">مدیریت مقالات</li>--}}
{{--@endif()--}}




@if (checkAcl('article-list'))
    <li class="nav-item {{ active_class_with_route(['article.show','article.index','article.create','article.store','article.update','article.destroy','article.edit']) }}">
        <a href="{{ url('/admin/article') }}" class="nav-link">
            <i class="link-icon" data-feather="package"></i>
            <span class="link-title">مقالات</span>
        </a>
    </li>
@endif()


