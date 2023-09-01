<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
        <a href="{{ route('admin.beranda') }}">SPIKS</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
        {{-- <a href="index.html" class="">SPIKS</a> --}}
    </div>
    <ul class="sidebar-menu">
        <li class="menu-header">Dashboard</li>
        <li class="nav-item {{ request()->is('admin/beranda*') ? 'active' : '' }}">
            <a href="{{ route('admin.beranda') }}"><i class="fas fa-home"></i>
                <span>Beranda</span>
            </a>
        </li>
        <li class="nav-item {{ request()->is('admin/cek*') ? 'active' : '' }}">
            <a href="{{ route('admin.cek') }}"><i class="fas fa-book"></i>
                <span>Cek Kepribadian</span>
            </a>
        </li>
        <li class="nav-item {{ request()->is('admin/kepribadian*') ? 'active' : '' }}">
            <a href="{{ route('admin.kepribadian') }}"><i class="fas fa-laptop"></i>
                <span>Kepribadian</span>
            </a>
        </li>
        <li class="nav-item {{ request()->is('admin/indikasi*') ? 'active' : '' }}">
            <a href="{{ route('admin.indikasi') }}"><i class="fas fa-flag"></i>
                <span>Indikasi</span>
            </a>
        </li>
        <li class="nav-item {{ request()->is('admin/rule*') ? 'active' : '' }}">
            <a href="{{ route('admin.rule') }}"><i class="fas fa-landmark"></i>
                <span>Aturan</span>
            </a>
        </li>
        <li class="nav-item {{ request()->is('admin/histori-diagnosis*') ? 'active' : '' }}">
            <a href="{{ route('admin.histori.diagnosis') }}"><i class="fas fa-fire"></i>
                <span>Histori</span>
            </a>
        </li>
    </ul>
</aside>
