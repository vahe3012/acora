<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <div class='row'>
        <a href="{{ url('/') }}" class="brand-link m-auto">
            <img src="{{asset("images/acora-logo.png")}}" alt="Acora Logo"
                 class="brand-image img-circle elevation-3 m-0" id="admin-sidebar-logo">
        </a>
    </div>
    <!-- Sidebar Menu -->
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @include('admin.partials.menu')
            </ul>
        </nav>
    </div>

</aside>
