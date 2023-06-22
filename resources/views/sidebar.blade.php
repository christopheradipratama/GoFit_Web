<style>
    .profile {
        margin-left: auto;
        margin-right: auto;
        text-align: center;
        margin-bottom: 30px;
        padding-bottom: 30px;
        border-bottom: 1px solid #efefef;
        max-width: 200px;
    }

    .name {
        font-size: 18px;
        margin-top: 5px;
        margin-bottom: 5px;
    }

    .country {
        font-size: 14px;
        color: #cfcfcf;
    }
</style>
@if ($pegawai->ROLE_PEGAWAI == 'Kasir')
    <ul class="nav flex-column">
        <div class="toggle">
            <a href="#" class="burger js-menu-toggle" data-toggle="collapse" data-target="#main-navbar">
                <span></span>
            </a>
        </div>
        <div class="side-inner">
            <div class="profile">
                <img src='https://avataaars.io/?avatarStyle=Circle&topType=ShortHairShortWaved&accessoriesType=Blank&hairColor=Black&facialHairType=Blank&clotheType=BlazerSweater&eyeType=Default&eyebrowType=DefaultNatural&mouthType=Smile&skinColor=Light'
                    alt="Image" class="img-fluid">
                <h3 class="name">{{ $pegawai->NAMA_PEGAWAI }} </h3>
                <span class="country">{{ $pegawai->ROLE_PEGAWAI }}</span>
            </div>
            <li class="">
                <a class="nav-link" aria-current="page" href="{{ url('member') }}">
                    <span data-feather="home" class="align-text-bottom"></span>
                    Kelola Member
                </a>
            </li>
            <li class="">
                <a class="nav-link" aria-current="page" href="{{ url('deactiveMember') }}">
                    <span data-feather="home" class="align-text-bottom"></span>
                    Kelola Deactive Member
                </a>
            </li>
            <li class="">
                <a class="nav-link" aria-current="page" href="{{ url('transaksiAktivasi') }}">
                    <span data-feather="home" class="align-text-bottom"></span>
                    Kelola Transaksi Aktivasi
                </a>
            </li>
            <li class="">
                <a class="nav-link" aria-current="page" href="{{ url('transaksiDepositUang') }}">
                    <span data-feather="home" class="align-text-bottom"></span>
                    Kelola Transaksi Deposit Uang
                </a>
            </li>
            <li class="">
                <a class="nav-link" aria-current="page" href="{{ url('transaksiDepositKelas') }}">
                    <span data-feather="home" class="align-text-bottom"></span>
                    Kelola Transaksi Deposit Kelas
                </a>
            </li>
            <li class="">
                <a class="nav-link" aria-current="page" href="{{ url('resetClass') }}">
                    <span data-feather="home" class="align-text-bottom"></span>
                    Reset Kelas
                </a>
            </li>
            <li class="">
                <a class="nav-link" aria-current="page" href="{{ url('resetTerlambat') }}">
                    <span data-feather="home" class="align-text-bottom"></span>
                    Reset Terlambat Instruktur
                </a>
            </li>
            <li class="">
                <a class="nav-link" aria-current="page" href="{{ url('presensiBookingKelas') }}">
                    <span data-feather="home" class="align-text-bottom"></span>
                    Kelola Presensi Booking Kelas
                </a>
            </li>
            <li class="">
                <a class="nav-link" aria-current="page" href="{{ url('presensiBookingGym') }}">
                    <span data-feather="home" class="align-text-bottom"></span>
                    Kelola Presensi Booking Gym
                </a>
            </li>
    </ul>
@endif

@if ($pegawai->ROLE_PEGAWAI == 'Manajer Operasional')
    <ul class="nav flex-column">
        <div class="toggle">
            <a href="#" class="burger js-menu-toggle" data-toggle="collapse" data-target="#main-navbar">
                <span></span>
            </a>
        </div>
        <div class="side-inner">
            <div class="profile">
                <img src='https://avataaars.io/?avatarStyle=Circle&topType=ShortHairShortWaved&accessoriesType=Blank&hairColor=Black&facialHairType=Blank&clotheType=BlazerSweater&eyeType=Default&eyebrowType=DefaultNatural&mouthType=Smile&skinColor=Light'
                    alt="Image" class="img-fluid">
                <h3 class="name">{{ $pegawai->NAMA_PEGAWAI }} </h3>
                <span class="country">{{ $pegawai->ROLE_PEGAWAI }}</span>
            </div>
        <li class="">
            <a class="nav-link" aria-current="page" href="{{ url('jadwalUmum') }}">
                <span data-feather="home" class="align-text-bottom"></span>
                Kelola Jadwal Umum
            </a>
        </li>
        <li class="">
            <a class="nav-link" aria-current="page" href="{{ url('jadwalHarian') }}">
                <span data-feather="home" class="align-text-bottom"></span>
                Kelola Jadwal Harian
            </a>
        </li>
        <li class="">
            <a class="nav-link" aria-current="page" href="{{ url('izinInstruktur') }}">
                <span data-feather="home" class="align-text-bottom"></span>
                Reset Izin Instruktur
            </a>
        </li>
        <li class="">
            <a class="nav-link" aria-current="page" href="{{ url('laporanPendapatan') }}">
                <span data-feather="home" class="align-text-bottom"></span>
                Kelola Laporan Pendapatan
            </a>
        </li>
        <li class="">
            <a class="nav-link" aria-current="page" href="{{ url('laporanKelas') }}">
                <span data-feather="home" class="align-text-bottom"></span>
                Kelola Laporan Aktivitas Kelas Bulanan
            </a>
        </li>
        <li class="">
            <a class="nav-link" aria-current="page" href="{{ url('laporanGym') }}">
                <span data-feather="home" class="align-text-bottom"></span>
                Kelola Laporan Aktivitas Gym Bulanan
            </a>
        </li>
        <li class="">
            <a class="nav-link" aria-current="page" href="{{ url('laporanInstruktur') }}">
                <span data-feather="home" class="align-text-bottom"></span>
                Kelola Laporan Kinerja Instruktur
            </a>
        </li>
    </ul>
@endif

@if ($pegawai->ROLE_PEGAWAI == 'Admin')
    <ul class="nav flex-column">
        <div class="toggle">
            <a href="#" class="burger js-menu-toggle" data-toggle="collapse" data-target="#main-navbar">
                <span></span>
            </a>
        </div>
        <div class="side-inner">
            <div class="profile">
                <img src='https://avataaars.io/?avatarStyle=Circle&topType=ShortHairShortWaved&accessoriesType=Blank&hairColor=Black&facialHairType=Blank&clotheType=BlazerSweater&eyeType=Default&eyebrowType=DefaultNatural&mouthType=Smile&skinColor=Light'
                    alt="Image" class="img-fluid">
                <h3 class="name">{{ $pegawai->NAMA_PEGAWAI }} </h3>
                <span class="country">{{ $pegawai->ROLE_PEGAWAI }}</span>
            </div>
        <li class="">
            <a class="nav-link" aria-current="page" href="{{ url('instruktur') }}">
                <span data-feather="home" class="align-text-bottom"></span>
                Kelola Instruktur
            </a>
        </li>
    </ul>
@endif
