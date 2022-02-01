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
                        <a href="{{ route('master.wilayah.index') }}" class="nav-link {{ Route::is('master.wilayah.*') ? 'active' : '' }}" >
                            <i class="fas fa-database nav-icon"></i>
                            <p>Master Wilayah</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('master.provinsi.index') }}" class="nav-link {{ Route::is('master.provinsi.*') ? 'active' : '' }}">
                            <i class="fas fa-database nav-icon"></i>
                            <p>Master Provinsi</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('master.kabupaten.index') }}" class="nav-link {{ Route::is('master.kabupaten.*') ? 'active' : '' }}">
                            <i class="fas fa-database nav-icon"></i>
                            <p>Master Kabupaten</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item has-treeview {{ Route::is('form.*') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ Route::is('form.*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-folder"></i>
                    <p>
                        Form
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('form.renja.index') }}" class="nav-link {{ Route::is('form.renja.*') ? 'active' : '' }}" >
                            <i class="fas fa-file-signature nav-icon"></i>
                            <p>Renja LKH</p>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</div>
