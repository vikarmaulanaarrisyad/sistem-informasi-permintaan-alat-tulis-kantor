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
                    <li
                        class="nav-item {{ request()->is(['user', 'semester', 'supplier', 'satuan', 'jenis-barang', 'barang']) ? 'menu-is-opening menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ request()->is(['user*', 'semester*', 'supplier*', 'satuan*', 'jenis-barang', 'barang']) ? 'active' : '' }}">
                            <i class="nav-icon fas fa-cube"></i>
                            <p>
                                Master Data
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview"
                            style="{{ request()->is(['user*','semester*', 'supplier*', 'satuan*', 'jenis-barang*', 'barang*']) ? 'display: block;' : 'display: none;' }}">
                            <li class="nav-item">
                                <a href="{{ route('user.index') }}"
                                    class="nav-link {{ request()->is('user*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>User</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('semester.index') }}"
                                    class="nav-link {{ request()->is('semester*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Semester</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('supplier.index') }}"
                                    class="nav-link {{ request()->is('supplier*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Supplier</p>
                                </a>
                            </li>
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
                                <a href="{{ route('barang.index') }}"
                                    class="nav-link {{ request()->is('barang*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Barang</p>
                                </a>
                            </li>

                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a href="{{ route('permintaan-barang.index') }}"
                            class="nav-link {{ request()->is('permintaan-barang') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-folder-open"></i>
                            <p>
                                Pengajuan Barang
                            </p>
                        </a>
                    </li>
                @endif
                @if (auth()->user()->hasRole('admin'))
                    <li class="nav-item">
                        <a href="{{ route('verifikasi-permintaan.index') }}"
                            class="nav-link {{ request()->is('verifikasi-permintaan*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-check-circle"></i>
                            <p>
                                Verifikasi Pengajuan
                            </p>
                        </a>
                    </li>
                @endif

                @if (auth()->user()->hasRole('admin'))
                    <li class="nav-item {{ request()->is(['pembelian-barang','pengeluaran-barang']) ? 'menu-is-opening menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->is(['pembelian-barang','pengeluaran-barang']) ? 'active' : '' }}">
                            <i class="nav-icon fas fa-list"></i>
                            <p>
                                Transaksi
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview"
                            style="{{ request()->is(['pembelian-barang','pengeluaran-barang']) ? 'display: block;' : 'display: none;' }}">
                            <li class="nav-item">
                                <a href="{{ route('pembelian-barang.index') }}"
                                    class="nav-link {{ request()->is('pembelian-barang*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        Barang Masuk
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('pengeluaran-barang.index') }}"
                                    class="nav-link {{ request()->is('pengeluaran-barang*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        Barang Keluar
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item {{ request()->is(['report']) ? 'menu-is-opening menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->is(['report']) ? 'active' : '' }}">
                            <i class="nav-icon fas fa-file-pdf"></i>
                            <p>
                                Laporan
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview"
                            style="{{ request()->is(['report']) ? 'display: block;' : 'display: none;' }}">
                            <li class="nav-item">
                                <a href="{{ route('report.index') }}"
                                    class="nav-link {{ request()->is('report') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Stok Barang</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-sign-in-alt"></i>
                            <p>
                                Keluar
                            </p>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
</aside>
