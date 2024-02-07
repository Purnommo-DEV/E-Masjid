<aside
    class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-gradient-dark"
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="#!" target="_blank">
            <img src="{{ asset('Back/img/logo-ct.png') }}" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold text-white">Administrator</span>
        </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link text-white" href="../pages/dashboard.html">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white @menuActive('admin.ProfilMasjid')" href="{{ route('admin.ProfilMasjid') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-mosque"></i>
                    </div>
                    <span class="nav-link-text ms-1">Profil Masjid</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white @menuActive('admin.HalamanKasMasjid')" href="{{ route('admin.HalamanKasMasjid') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-money-bill-wave-alt"></i>
                    </div>
                    <span class="nav-link-text ms-1">Kas Masjid</span>
                </a>
            </li>
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#informasiInfaq" class="nav-link text-white @menuActiveCollapsed('admin.InformasiInfaq.*')"
                    aria-controls="informasiInfaq" role="button" aria-expanded="false">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <span class="nav-link-text ms-1">Informasi Infaq</span>
                </a>
                <div class="collapse @menuShow('admin.InformasiInfaq.*')" id="informasiInfaq">
                    <ul class="nav ">
                        <li class="nav-item @menuActiveSub('admin.InformasiInfaq.HalamanKategori')">
                            <a class="nav-link text-white @menuActiveSub('admin.InformasiInfaq.HalamanKategori')"
                                href="{{ route('admin.InformasiInfaq.HalamanKategori') }}">
                                <span class="sidenav-mini-icon"> A </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Kategori </span>
                            </a>
                        </li>
                        <li class="nav-item @menuActiveSub('admin.InformasiInfaq.HalamanInfaq.*')">
                            <a class="nav-link text-white @menuActiveSub('admin.InformasiInfaq.HalamanInfaq.*')"
                                href="{{ route('admin.InformasiInfaq.HalamanInfaq.Infaq') }}">
                                <span class="sidenav-mini-icon"> D </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Data Infaq </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white " href="{{ route('ProsesLogout') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-arrow-left"></i>
                    </div>
                    <span class="nav-link-text ms-1">Keluar</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
