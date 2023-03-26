@if (Auth::user()->is_admin == 1)
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
            <div class="sidebar-brand-icon">
                <i class="fa fa-university"></i>
            </div>
            <div class="sidebar-brand-text mx-3">{{ site('name') }}</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item {{ active('/', 'active') }}">
            <a class="nav-link" href="{{ route('home') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Master
        </div>

        <!-- Nav Item - Books -->
        <li class="nav-item {{ active('barang', 'active', 'group') }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#barang"
                aria-expanded="true" aria-controls="barang">
                <i class="fas fa-fw fa-book"></i>
                <span>Barang</span>
            </a>
            <div id="barang" class="collapse {{ active('barang', 'show', 'group') }}">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Barang</h6>
                    <a class="collapse-item {{ active('barang', 'active') }}" href="{{ route('barang.index') }}">Data
                        Barang</a>
                    <a class="collapse-item {{ active('barang/create', 'active') }}"
                        href="{{ route('barang.create') }}"> Tambah Barang</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Category -->
        <li class="nav-item {{ active('category', 'active') }}">
            <a class="nav-link" href="{{ route('category.index') }}">
                <i class="fas fa-fw fa-tag"></i>
                <span>Merk</span></a>
        </li>

        <!-- Nav Item - Stock -->
        <li class="nav-item {{ active('stock', 'active', 'group') }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#stock"
                aria-expanded="true" aria-controls="stock">
                <i class="fas fa-fw fa-archive"></i>
                <span>Stock</span>
            </a>
            <div id="stock" class="collapse {{ active('stock', 'show', 'group') }}">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Stock</h6>
                    <a class="collapse-item {{ active('stock/add', 'active') }}" href="{{ route('stock.add') }}">Stock
                        Masuk</a>
                    <a class="collapse-item {{ active('stock/remove', 'active') }}"
                        href="{{ route('stock.remove') }}">Stock Keluar</a>
                </div>
            </div>
        </li>
        <li class="nav-item {{ active('laporan', 'active', 'group') }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#laporan"
                aria-expanded="true" aria-controls="stock">
                <i class="fas fa-fw fa-archive"></i>
                <span>Laporan</span>
            </a>
            <div id="laporan" class="collapse {{ active('laporan', 'show', 'group') }}">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Laporan</h6>
                    <a class="collapse-item {{ active('laporan', 'active') }}"
                        href="{{ route('laporan.index') }}">Download Laporan</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Member -->
        <li class="nav-item {{ active('member', 'active', 'group') }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#member"
                aria-expanded="true" aria-controls="member">
                <i class="fas fa-fw fa-user"></i>
                <span>Member</span>
            </a>
            <div id="member" class="collapse {{ active('member', 'show', 'group') }}">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Member</h6>
                    <a class="collapse-item {{ active('member', 'active') }}" href="{{ route('member.index') }}">Data
                        Member</a>
                    <a class="collapse-item {{ active('member/create', 'active') }}"
                        href="{{ route('member.create') }}">Tambah Member</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - User -->
        <li class="nav-item {{ active('user', 'active') }}">
            <a class="nav-link" href="{{ route('user.index') }}">
                <i class="fas fa-fw fa-user"></i>
                <span>User</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Menu
        </div>

        <!-- Nav Item - Loan -->
        <li class="nav-item {{ active('loan', 'active', 'group') }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#loan" aria-expanded="true"
                aria-controls="loan">
                <i class="fas fa-fw fa-clipboard-list"></i>
                <span>Pinjaman</span>
            </a>
            <div id="loan" class="collapse {{ active('loan', 'show', 'group') }}">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Loan</h6>
                    <a class="collapse-item {{ active('loan', 'active') }}" href="{{ route('loan.index') }}">Data
                        Pinjaman</a>
                    <a class="collapse-item {{ active('loan/create', 'active') }}"
                        href="{{ route('loan.create') }}">Buat Pinjaman</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Setting -->
        <li class="nav-item {{ active('setting', 'active') }}">
            <a class="nav-link" href="{{ route('setting.index') }}">
                <i class="fas fa-fw fa-cogs"></i>
                <span>Setting</span></a>
        </li>

        <!-- Nav Item - Category -->
        <li class="nav-item {{ active('profile', 'active') }}">
            <a class="nav-link" href="{{ route('profile.index') }}">
                <i class="fas fa-fw fa-user"></i>
                <span>Profile</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>
@else
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
            <div class="sidebar-brand-icon">
                <i class="fa fa-university"></i>
            </div>
            <div class="sidebar-brand-text mx-3">{{ site('name') }}</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item {{ active('/', 'active') }}">
            <a class="nav-link" href="{{ route('home') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Heading -->
        <div class="sidebar-heading">
            Menu
        </div>

        <!-- Nav Item - Loan -->
        <li class="nav-item {{ active('loan', 'active', 'group') }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#loan"
                aria-expanded="true" aria-controls="loan">
                <i class="fas fa-fw fa-clipboard-list"></i>
                <span>Loan</span>
            </a>
            <div id="loan" class="collapse {{ active('loan', 'show', 'group') }}">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Loan</h6>
                    <a class="collapse-item {{ active('loan', 'active') }}" href="{{ route('loan.index') }}">Data
                        Loan</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Category -->
        <li class="nav-item {{ active('profile', 'active') }}">
            <a class="nav-link" href="{{ route('profile.index') }}">
                <i class="fas fa-fw fa-user"></i>
                <span>Profile</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>
@endif
