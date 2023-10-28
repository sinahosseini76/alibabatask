<nav class="sidebar">
    <div class="sidebar-header">
        <a href="#" class="sidebar-brand">
            {{--        //TODO : change logo--}}
            <img  src="{{asset('assets/images/Logo.svg')}}" width="150px"/>
        </a>
        <div class="sidebar-toggler not-active">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="sidebar-body">
        <ul class="nav">
            <li class="nav-item nav-category">موارد اصلی</li>
            @foreach(\Illuminate\Support\Facades\Cache::get('modules') as $module)
                @php($sidebar = "{$module}::layout.sidebar")
                @if(View::exists($sidebar))
                    @include($sidebar)
                @endif
            @endforeach
        </ul>
    </div>
</nav>
@if(config('shop.defaults.changeable_theme'))
    @component('Core::components.theme-settings')@endcomponent
@endif
