<li class="nav-item">
    <a href="{{route('admin.partners.index')}}" class="nav-link {{ Route::is('admin.partners.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-th"></i>
        <p>Գործընկերներ</p>
    </a>
</li>

<li class="nav-item {{ Route::is('admin.news.*') || Route::is('admin.categories.*') ? 'menu-is-opening menu-open' : '' }}">
    <a href="" class="nav-link">
        <i class="nav-icon fas fa-th"></i>
        <p> Նորություններ
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{route('admin.news.index')}}" class="nav-link {{ Route::is('admin.news.*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>{{ __('main.news.all_news') }}</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.categories.index') }}" class="nav-link {{ Route::is('admin.categories.*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Կատեգորիա</p>
            </a>
        </li>
    </ul>
</li>

<li class="nav-item {{ Route::is('admin.reports.*') || Route::is('admin.analyzes.*') || Route::is('admin.digital-images.*') ? 'menu-is-opening menu-open' : '' }}">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-th"></i>
        <p>Հրապարակումներ
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{route('admin.reports.index')}}" class="nav-link {{ Route::is('admin.reports.*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Հաշվետվություններ</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('admin.analyzes.index')}}" class="nav-link {{ Route::is('admin.analyzes.*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Վերլուծություններ</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.digital-images.index')  }}" class="nav-link {{ Route::is('admin.digital-images.*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Թվապատկերներ</p>
            </a>
        </li>
    </ul>
</li>

<li class="nav-item {{ Route::is('admin.laws.*') ? 'menu-is-opening menu-open' : '' }}">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-th"></i>
        <p>Իրավական դաշտ
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ url('/admin/laws?type=') . \App\Models\Law::TYPE_LAW }}" class="nav-link {{ (Request::get('type') && session()->get('lawType') == \App\Models\Law::TYPE_LAW) ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Օրենքներ</p>
            </a>
        </li>
    </ul>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ url('/admin/laws?type=') . \App\Models\Law::TYPE_REGULATION}}" class="nav-link {{ (Request::get('type') && session()->get('lawType') == \App\Models\Law::TYPE_REGULATION) ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Կանոնակարգեր</p>
            </a>
        </li>
    </ul>
</li>

<li class="nav-item">
    <a href="{{ route('admin.courses.index') }}" class="nav-link {{ Route::is('admin.courses.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-th"></i>
        <p>Դասընթացներ</p>
    </a>
</li>

<li class="nav-item {{ Route::is('admin.programs.*') ? 'menu-is-opening menu-open' : '' }}">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-th"></i>
        <p>Ծրագրեր
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>

    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('admin.programs.index') }}" class="nav-link {{ Route::is('admin.programs.*')? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Իրականացված</p>
            </a>
        </li>
    </ul>
</li>

<li class="nav-item">
    <a href="{{route('admin.about.index')}}" class="nav-link {{ Route::is('admin.about.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-th"></i>
        <p>Մեր մասին</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{route('admin.staff.index')}}" class="nav-link {{ Route::is('admin.staff.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-th"></i>
        <p>Մեր անձնակազմը</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{route('admin.settings.index')}}" class="nav-link {{ Route::is('admin.settings.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-th"></i>
        <p>Կարգավորումներ</p>
    </a>
</li>
