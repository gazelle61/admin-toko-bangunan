<aside class="main-sidebar sidebar-dark elevation-1">
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="info">
            <a href="{{ route('admin.dashboard') }}" class="d-block">Toko Bangunan NOTO 19</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            {{-- Dashboard --}}
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-home"></i>
                    <p>Dashboard</p>
                </a>
            </li>

            <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-wallet"></i>
                    <p>
                        Pemasukan
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>

                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('kasir.index') }}" class="nav-link">
                            <i class="far fa-cash-register nav-icon"></i>
                            <p>Kasir</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('penjualan.index') }}" class="nav-link">
                            <i class="far fa-receipt nav-icon"></i>
                            <p>Data Penjualan</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('barang.index') }}" class="nav-link">
                            <i class="far fa-box nav-icon"></i>
                            <p>Barang</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('kategori.index') }}" class="nav-link">
                            <i class="far fa-tags nav-icon"></i>
                            <p>Kategori</p>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-coins"></i>
                    <p>
                        Pengeluaran
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>

                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('pembelian.index') }}" class="nav-link">
                            <i class="far fa-receipt nav-icon"></i>
                            <p>Data Pembelian</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('supplier.index') }}" class="nav-link">
                            <i class="far fa-box nav-icon"></i>
                            <p>Data Supplier</p>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.faq.index') }}" class="nav-link {{ request()->is('admin/faq') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-envelope"></i>
                    <p>FAQ</p>
                </a>
            </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
