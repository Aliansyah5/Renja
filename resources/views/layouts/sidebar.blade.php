<div class="sidebar">
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="true">
            <li class="nav-item">
                <a href="{{ route('home') }}" class="nav-link {{ Route::is('home') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Beranda</p>
                </a>
            </li>
            <li class="nav-item has-treeview {{ Route::is('master.*') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ Route::is('master.*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-cog"></i>
                    <p>
                        Master Data
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('master.template.index') }}" class="nav-link {{ Route::is('master.template.*') ? 'active' : '' }}">
                            <i class="fas fa-adjust nav-icon"></i>
                            <p>Template Kartu</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('master.karyawan.index') }}" class="nav-link {{ Route::is('master.karyawan.*') ? 'active' : '' }}">
                            <i class="fas fa-users nav-icon"></i>
                            <p>Karyawan (AAP)</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('master.kartu.index') }}" class="nav-link {{ Route::is('master.kartu.*') ? 'active' : '' }}">
                            <i class="fas fa-id-card nav-icon"></i>
                            <p>Kartu</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="{{ route('kartu.index') }}" class="nav-link {{ Route::is('kartu.*') ? 'active' : '' }}">
                    <i class="fas fa-print nav-icon"></i>
                    <p>Kartu Karyawan</p>
                </a>
            </li>
        </ul>
    </nav>
</div>