<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="text-center">
        <img src="{{ asset('images/Logo.png')}}" alt="Smart Lion Logo" class="brand-image" style="opacity: 1; margin: 2% 0 0 11%;">
        <!-- <span class="brand-text font-weight-light">Smart Lion</span> -->
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ routeActive('dashboard') }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link {{ prefixActive('admin/home') }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Home
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('contact-us') }}" class="nav-link {{ prefixActive('admin/contact-us') }}">
                        <i class="nav-icon fas fa-address-card"></i>
                        <p>
                            Contact Us
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('about-us') }}" class="nav-link {{ prefixActive('admin/about-us') }}">
                        <i class="nav-icon fas fa-address-card"></i>
                        <p>
                            About Us
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('current-opening') }}" class="nav-link {{ prefixActive('admin/current-opening') }}">
                        <i class="nav-icon fas fa-file"></i>
                        <p>
                            Current Opening
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('team') }}" class="nav-link {{ prefixActive('admin/team') }}">
                        <i class="nav-icon fas fa-people-group"></i>
                        <p>
                            Team
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('testimonial') }}" class="nav-link {{ prefixActive('admin/testimonial') }}">
                        <i class="nav-icon fas fa-quote-right"></i>
                        <p>
                            Testimonial
                        </p>
                    </a>
                </li>
                <li class="nav-item {{ prefixBlock('admin/services') }}">
                    <a href="#" class="nav-link {{ prefixActive('admin/services') }}">
                        <i class="nav-icon fas fa-wrench"></i>
                        <p>
                            Services
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('services') }}" class="nav-link {{ routeActive('services') }} {{ routeActive('services-edit') }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Edit Service</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('corporate-solution') }}" class="nav-link {{ routeActive('corporate-solution') }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Corporate Solution</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('recruitmentIndex') }}" class="nav-link {{ routeActive('recruitmentIndex') }} ">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Recruitment Process</p>
                            </a>
                        </li>

                    </ul>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>