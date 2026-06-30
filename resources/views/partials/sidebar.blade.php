@php
    $planningActive = request()->routeIs('tasks.*');
    $propertyActive = request()->routeIs('projects.*', 'towers.*', 'floors.*', 'flats.*');
    $purchaseActive = request()->routeIs('vendors.*', 'purchase-orders.*');
    $salesActive = request()->routeIs('customers.*', 'leads.*', 'site-visits.*', 'bookings.*', 'installments.*', 'payments.*');
    $contractorActive = request()->routeIs('contractors.*', 'contractor-tasks.*', 'attendances.*', 'contractor-payments.*');
    $reportsActive = request()->routeIs('reports.*');
    $adminActive = request()->routeIs('users.*', 'roles.*', 'permissions.*', 'audit-logs.*');
@endphp

<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <div class="logo-header" data-background-color="dark">
            <a href="{{ route('dashboard') }}" class="logo">
                <span class="fw-bold text-white fs-4">REMS</span>
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar"><i class="gg-menu-right"></i></button>
                <button class="btn btn-toggle sidenav-toggler"><i class="gg-menu-left"></i></button>
            </div>
            <button class="topbar-toggler more"><i class="gg-more-vertical-alt"></i></button>
        </div>
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-section">
                    <span class="sidebar-mini-icon"><i class="fa fa-ellipsis-h"></i></span>
                    <h4 class="text-section">Operations</h4>
                </li>

                @can('manage planning')
                    <li class="nav-item {{ $planningActive ? 'active' : '' }}">
                        <a data-bs-toggle="collapse" href="#planningMenu" class="{{ $planningActive ? '' : 'collapsed' }}" aria-expanded="{{ $planningActive ? 'true' : 'false' }}">
                            <i class="fas fa-project-diagram"></i>
                            <p>Planning &amp; Gantt</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse {{ $planningActive ? 'show' : '' }}" id="planningMenu">
                            <ul class="nav nav-collapse">
                                <li class="{{ request()->routeIs('tasks.gantt') ? 'active' : '' }}"><a href="{{ route('tasks.gantt') }}"><span class="sub-item">Gantt Chart</span></a></li>
                                <li class="{{ request()->routeIs('tasks.index', 'tasks.create', 'tasks.edit') ? 'active' : '' }}"><a href="{{ route('tasks.index') }}"><span class="sub-item">Tasks</span></a></li>
                            </ul>
                        </div>
                    </li>
                @endcan

                @can('manage property')
                    <li class="nav-item {{ $propertyActive ? 'active' : '' }}">
                        <a data-bs-toggle="collapse" href="#propertyMenu" class="{{ $propertyActive ? '' : 'collapsed' }}" aria-expanded="{{ $propertyActive ? 'true' : 'false' }}">
                            <i class="fas fa-building"></i>
                            <p>Property</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse {{ $propertyActive ? 'show' : '' }}" id="propertyMenu">
                            <ul class="nav nav-collapse">
                                <li class="{{ request()->routeIs('projects.*') ? 'active' : '' }}"><a href="{{ route('projects.index') }}"><span class="sub-item">Projects</span></a></li>
                                <li class="{{ request()->routeIs('towers.*') ? 'active' : '' }}"><a href="{{ route('towers.index') }}"><span class="sub-item">Towers</span></a></li>
                                <li class="{{ request()->routeIs('floors.*') ? 'active' : '' }}"><a href="{{ route('floors.index') }}"><span class="sub-item">Floors</span></a></li>
                                <li class="{{ request()->routeIs('flats.*') ? 'active' : '' }}"><a href="{{ route('flats.index') }}"><span class="sub-item">Flats</span></a></li>
                            </ul>
                        </div>
                    </li>
                @endcan

                @can('manage purchase')
                    <li class="nav-item {{ $purchaseActive ? 'active' : '' }}">
                        <a data-bs-toggle="collapse" href="#purchaseMenu" class="{{ $purchaseActive ? '' : 'collapsed' }}" aria-expanded="{{ $purchaseActive ? 'true' : 'false' }}">
                            <i class="fas fa-shopping-cart"></i>
                            <p>Purchase</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse {{ $purchaseActive ? 'show' : '' }}" id="purchaseMenu">
                            <ul class="nav nav-collapse">
                                <li class="{{ request()->routeIs('vendors.*') ? 'active' : '' }}"><a href="{{ route('vendors.index') }}"><span class="sub-item">Vendors</span></a></li>
                                <li class="{{ request()->routeIs('purchase-orders.*') ? 'active' : '' }}"><a href="{{ route('purchase-orders.index') }}"><span class="sub-item">Purchase Orders</span></a></li>
                            </ul>
                        </div>
                    </li>
                @endcan

                @can('manage sales')
                    <li class="nav-item {{ $salesActive ? 'active' : '' }}">
                        <a data-bs-toggle="collapse" href="#salesMenu" class="{{ $salesActive ? '' : 'collapsed' }}" aria-expanded="{{ $salesActive ? 'true' : 'false' }}">
                            <i class="fas fa-handshake"></i>
                            <p>Sales &amp; CRM</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse {{ $salesActive ? 'show' : '' }}" id="salesMenu">
                            <ul class="nav nav-collapse">
                                <li class="{{ request()->routeIs('customers.*') ? 'active' : '' }}"><a href="{{ route('customers.index') }}"><span class="sub-item">Customers</span></a></li>
                                <li class="{{ request()->routeIs('leads.*') ? 'active' : '' }}"><a href="{{ route('leads.index') }}"><span class="sub-item">Leads</span></a></li>
                                <li class="{{ request()->routeIs('site-visits.*') ? 'active' : '' }}"><a href="{{ route('site-visits.index') }}"><span class="sub-item">Site Visits</span></a></li>
                                <li class="{{ request()->routeIs('bookings.*') ? 'active' : '' }}"><a href="{{ route('bookings.index') }}"><span class="sub-item">Bookings</span></a></li>
                                <li class="{{ request()->routeIs('installments.*') ? 'active' : '' }}"><a href="{{ route('installments.index') }}"><span class="sub-item">Installments</span></a></li>
                                <li class="{{ request()->routeIs('payments.*') ? 'active' : '' }}"><a href="{{ route('payments.index') }}"><span class="sub-item">Payments</span></a></li>
                            </ul>
                        </div>
                    </li>
                @endcan

                @can('manage contractors')
                    <li class="nav-item {{ $contractorActive ? 'active' : '' }}">
                        <a data-bs-toggle="collapse" href="#contractorMenu" class="{{ $contractorActive ? '' : 'collapsed' }}" aria-expanded="{{ $contractorActive ? 'true' : 'false' }}">
                            <i class="fas fa-hard-hat"></i>
                            <p>Contractors</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse {{ $contractorActive ? 'show' : '' }}" id="contractorMenu">
                            <ul class="nav nav-collapse">
                                <li class="{{ request()->routeIs('contractors.*') ? 'active' : '' }}"><a href="{{ route('contractors.index') }}"><span class="sub-item">Contractors</span></a></li>
                                <li class="{{ request()->routeIs('contractor-tasks.*') ? 'active' : '' }}"><a href="{{ route('contractor-tasks.index') }}"><span class="sub-item">Assignments</span></a></li>
                                <li class="{{ request()->routeIs('attendances.*') ? 'active' : '' }}"><a href="{{ route('attendances.index') }}"><span class="sub-item">Attendance</span></a></li>
                                <li class="{{ request()->routeIs('contractor-payments.*') ? 'active' : '' }}"><a href="{{ route('contractor-payments.index') }}"><span class="sub-item">Payments</span></a></li>
                            </ul>
                        </div>
                    </li>
                @endcan

                @can('view reports')
                    <li class="nav-item {{ $reportsActive ? 'active' : '' }}">
                        <a data-bs-toggle="collapse" href="#reportsMenu" class="{{ $reportsActive ? '' : 'collapsed' }}" aria-expanded="{{ $reportsActive ? 'true' : 'false' }}">
                            <i class="far fa-chart-bar"></i>
                            <p>Reports</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse {{ $reportsActive ? 'show' : '' }}" id="reportsMenu">
                            <ul class="nav nav-collapse">
                                <li class="{{ request()->routeIs('reports.index') ? 'active' : '' }}"><a href="{{ route('reports.index') }}"><span class="sub-item">Overview</span></a></li>
                                <li class="{{ request()->routeIs('reports.sales') ? 'active' : '' }}"><a href="{{ route('reports.sales') }}"><span class="sub-item">Sales</span></a></li>
                                <li class="{{ request()->routeIs('reports.purchase') ? 'active' : '' }}"><a href="{{ route('reports.purchase') }}"><span class="sub-item">Purchase</span></a></li>
                                <li class="{{ request()->routeIs('reports.revenue') ? 'active' : '' }}"><a href="{{ route('reports.revenue') }}"><span class="sub-item">Revenue</span></a></li>
                            </ul>
                        </div>
                    </li>
                @endcan

                @canany(['manage users', 'manage roles', 'manage permissions', 'view audit logs'])
                    <li class="nav-section">
                        <span class="sidebar-mini-icon"><i class="fa fa-ellipsis-h"></i></span>
                        <h4 class="text-section">Administration</h4>
                    </li>
                    <li class="nav-item {{ $adminActive ? 'active' : '' }}">
                        <a data-bs-toggle="collapse" href="#adminMenu" class="{{ $adminActive ? '' : 'collapsed' }}" aria-expanded="{{ $adminActive ? 'true' : 'false' }}">
                            <i class="fas fa-user-shield"></i>
                            <p>Access Control</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse {{ $adminActive ? 'show' : '' }}" id="adminMenu">
                            <ul class="nav nav-collapse">
                                @can('manage users')
                                    <li class="{{ request()->routeIs('users.*') ? 'active' : '' }}"><a href="{{ route('users.index') }}"><span class="sub-item">Users</span></a></li>
                                @endcan
                                @can('manage roles')
                                    <li class="{{ request()->routeIs('roles.*') ? 'active' : '' }}"><a href="{{ route('roles.index') }}"><span class="sub-item">Roles</span></a></li>
                                @endcan
                                @can('manage permissions')
                                    <li class="{{ request()->routeIs('permissions.*') ? 'active' : '' }}"><a href="{{ route('permissions.index') }}"><span class="sub-item">Permissions</span></a></li>
                                @endcan
                                @can('view audit logs')
                                    <li class="{{ request()->routeIs('audit-logs.*') ? 'active' : '' }}"><a href="{{ route('audit-logs.index') }}"><span class="sub-item">Audit Logs</span></a></li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcanany

                @can('manage settings')
                    <li class="nav-item {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                        <a href="{{ route('settings.index') }}">
                            <i class="fas fa-cog"></i>
                            <p>Settings</p>
                        </a>
                    </li>
                @endcan
            </ul>
        </div>
    </div>
</div>
