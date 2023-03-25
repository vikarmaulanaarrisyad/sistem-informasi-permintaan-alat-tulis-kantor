<aside class="main-sidebar sidebar-light-purple elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/') }}" class="brand-link bg-purple">
        <img src="{{ asset('AdminLTE/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3 bg-light" style="opacity: .8">
        <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
        {{-- <span class="brand-text font-weight-light">{{ $setting->company_name }}</span> --}}
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                {{-- @if (Storage::disk('public')->exists(auth()->user()->path_image))
                <img src="{{ Storage::disk('public')->url(auth()->user()->path_image) }}" alt="" class="img-circle elevation-2">
                @else
                @endif --}}
                <img src="{{ asset('AdminLTE/dist/img/user1-128x128.jpg') }}" alt=""
                    class="img-circle elevation-2">
            </div>
            <div class="info">
                <a href="{{ route('profile.show') }}" class="d-block" data-toggle="tooltip" data-placement="top"
                    title="Edit Profil">
                    {{ auth()->user()->name }}
                    <i class="fas fa-pencil-alt ml-2 text-sm text-primary"></i>
                </a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-compact nav-child-indent" data-widget="treeview"
                role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}"
                        class="nav-link {{ request()->is('dashboard*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                @if (auth()->user()->hasRole('admin'))
                    <li class="nav-header">DATA MASTER</li>
                    <li class="nav-item">
                        <a href="{{ route('semester.index') }}"
                            class="nav-link {{ request()->is('semester*') ? 'active' : '' }}">
                            <i class="fas fa-book nav-icon"></i>
                            <p>Semester</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="pages/charts/chartjs.html" class="nav-link">
                            <i class="fas fa-users nav-icon"></i>
                            <p>Supplier</p>
                        </a>
                    </li>
                    <li
                        class="nav-item {{ request()->is(['satuan', 'jenis-barang']) ? 'menu-is-opening menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->is(['satuan*', 'jenis-barang']) ? 'active' : '' }}">
                            <i class="nav-icon fas fa-cube"></i>
                            <p>
                                Barang
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview"
                            style="{{ request()->is(['satuan*', 'jenis-barang*']) ? 'display: block;' : 'display: none;' }}">
                            <li class="nav-item">
                                <a href="{{ route('satuan.index') }}"
                                    class="nav-link {{ request()->is('satuan*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Satuan Barang</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('jenis-barang.index') }}"
                                    class="nav-link {{ request()->is('jenis-barang*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Jenis Barang</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="pages/charts/inline.html" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Data Barang</p>
                                </a>
                            </li>

                        </ul>
                    </li>
                @else
                    <li class="nav-header">MASTER</li>
                @endif
                @if (auth()->user()->hasRole('admin'))
                    <li class="nav-header">PERMINTAAN</li>
                    @if (auth()->user()->hasRole('admin'))
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-download"></i>
                                <p>
                                    Permintaan Barang
                                </p>
                            </a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a href="#" class="nav-link {{ request()->is('orders*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-check-circle"></i>
                            <p>
                                Verifikasi Permintaan
                            </p>
                        </a>
                    </li>

                @endif

                @if (auth()->user()->hasRole('admin'))
                    <li class="nav-header">REPORT</li>
                    <li class="nav-item">
                        <a href="#" class="nav-link {{ request()->is('orders*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-file-pdf"></i>
                            <p>
                                Rekap Permintaan
                            </p>
                        </a>
                    </li>

                    <li class="nav-header">TRANSAKSI</li>
                    <li class="nav-item">
                        <a href="#" class="nav-link {{ request()->is('orders*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-shopping-cart"></i>
                            <p>
                                Pembelian Barang
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link {{ request()->is('orders*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-truck"></i>
                            <p>
                                Pendistribusian
                            </p>
                        </a>
                    </li>
                @endif

                @if (auth()->user()->hasRole('admin'))
                    <li class="nav-header">SISTEM</li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-cogs"></i>
                            <p>
                                Pengaturan
                            </p>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>