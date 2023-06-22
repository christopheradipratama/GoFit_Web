@extends('/dashboard')
@section('container')
    <style>
        body {
            /* margin-top:20px; */
        }

        .bg-light-gray {
            background-color: #f7f7f7;
        }

        .table-bordered thead td,
        .table-bordered thead th {
            border-bottom-width: 2px;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
        }

        .table-bordered td,
        .table-bordered th {
            border: 1px solid #dee2e6;
        }


        .bg-sky.box-shadow {
            box-shadow: 0px 5px 0px 0px #00a2a7
        }

        .bg-orange.box-shadow {
            box-shadow: 0px 5px 0px 0px #af4305
        }

        .bg-green.box-shadow {
            box-shadow: 0px 5px 0px 0px #4ca520
        }

        .bg-yellow.box-shadow {
            box-shadow: 0px 5px 0px 0px #dcbf02
        }

        .bg-pink.box-shadow {
            box-shadow: 0px 5px 0px 0px #e82d8b
        }

        .bg-purple.box-shadow {
            box-shadow: 0px 5px 0px 0px #8343e8
        }

        .bg-lightred.box-shadow {
            box-shadow: 0px 5px 0px 0px #d84213
        }


        .bg-sky {
            background-color: #02c2c7
        }

        .bg-orange {
            background-color: #e95601
        }

        .bg-green {
            background-color: #5bbd2a
        }

        .bg-yellow {
            background-color: #f0d001
        }

        .bg-pink {
            background-color: #ff48a4
        }

        .bg-purple {
            background-color: #9d60ff
        }

        .bg-lightred {
            background-color: #ff5722
        }

        .padding-15px-lr {
            padding-left: 15px;
            padding-right: 15px;
        }

        .padding-5px-tb {
            padding-top: 5px;
            padding-bottom: 5px;
        }

        .margin-10px-bottom {
            margin-bottom: 10px;
        }

        .border-radius-5 {
            border-radius: 5px;
        }

        .margin-10px-top {
            margin-top: 10px;
        }

        .font-size14 {
            font-size: 14px;
        }

        .text-light-gray {
            color: #d6d5d5;
        }

        .font-size13 {
            font-size: 13px;
        }

        .table-bordered td,
        .table-bordered th {
            border: 1px solid #dee2e6;
        }

        .table td,
        .table th {
            padding: .75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }
    </style>

    <div class="container">
        <div class="timetable-img text-center">
            <img src="img/content/timetable.png" alt="">
        </div>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Data Jadwal Harian</h1>
            <a href="{{ url('/generateJadwalHarian') }}" class="btn btn-md btn-dark">GENERATE</a>
        </div>
        <div class="input-group input-group-sm mb-2">
            <form action="{{ url('/searchJadwalHarian') }}" method="GET">
                <div class="d-flex align-item-center align-item-beetween">
                    <input class="form-control" type="search" placeholder="Search" aria-label="Search" name="search">
                    <button class="btn btn-navbar" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered text-center">
                <thead>
                    <tr class="bg-light-gray">
                        <th class="text-uppercase">DAY
                        </th>
                        <th colspan="10" class="text-uppercase text-center">TIME</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>
                            @if ($tanggalJadwalHarian != null)
                                <div>{{ $tanggalJadwalHarian->TANGGAL_JADWAL_HARIAN->format('l') }}</div>
                                <div>{{ $tanggalJadwalHarian->TANGGAL_JADWAL_HARIAN->format('Y m d') }}</div>
                            @endif
                        </td>
                        @foreach ($jadwalHarian as $items)
                            @if ($items->jadwalUmum->HARI_JADWAL == $tanggalJadwalHarian->TANGGAL_JADWAL_HARIAN->translatedformat('l'))
                                <td>
                                    <span
                                        class="bg-sky padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">{{ $items->TANGGAL_JADWAL_HARIAN->format('H:i:s') }}</span>
                                    <div class="margin-10px-top font-size14">{{ $items->jadwalUmum->kelas->NAMA_KELAS }}
                                    </div>
                                    <div class="margin-10px-top font-size14">{{ $items->instruktur->NAMA_INSTRUKTUR }}</div>
                                    <div class="margin-10px-top font-size14">{{ $items->KETERANGAN_JADWAL_HARIAN }}</div>
                                    <div class="d-flex align-items-between justify-content-center">
                                        <a href='{{ url('/editJadwalHarian/' . $items->TANGGAL_JADWAL_HARIAN) }}'
                                            class="btn btn-success btn-sm rounded circle mr-2"><i
                                                class="fas fa-pencil"></i></a>
                                        {{-- <form onsubmit="return confirm('Apakah anda yakin delete?');"
                                            action="{{ url('/deleteJadwalHarian/' . $items->TANGGAL_JADWAL_HARIAN) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm rounded circle ml-2"><i
                                                    class="fas fa-trash"></i></button>
                                        </form> --}}
                                    </div>

                                </td>
                            @endif
                        @endforeach
                    </tr>

                    <tr>
                        <td>
                            @if ($tanggalJadwalHarian != null)
                                <div>{{ $tanggalJadwalHarian->TANGGAL_JADWAL_HARIAN->addDays(1)->format('l') }}</div>
                                <div>{{ $tanggalJadwalHarian->TANGGAL_JADWAL_HARIAN->addDays(1)->format('Y m d') }}</div>
                            @endif
                        </td>

                        @foreach ($jadwalHarian as $items)
                            @if ($items->jadwalUmum->HARI_JADWAL == $tanggalJadwalHarian->TANGGAL_JADWAL_HARIAN->addDays(1)->translatedformat('l'))
                                <td>
                                    <span
                                        class="bg-sky padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">{{ $items->TANGGAL_JADWAL_HARIAN->format('H:i:s') }}</span>
                                    <div class="margin-10px-top font-size14">{{ $items->jadwalUmum->kelas->NAMA_KELAS }}
                                    </div>
                                    <div class="margin-10px-top font-size14">{{ $items->instruktur->NAMA_INSTRUKTUR }}
                                    </div>
                                    <div class="margin-10px-top font-size14">{{ $items->KETERANGAN_JADWAL_HARIAN }}</div>
                                    <div class="d-flex align-items-between justify-content-center">
                                        <a href='{{ url('/editJadwalHarian/' . $items->TANGGAL_JADWAL_HARIAN) }}'
                                            class="btn btn-success btn-sm rounded circle mr-2"><i
                                                class="fas fa-pencil"></i></a>
                                        {{-- <form onsubmit="return confirm('Apakah anda yakin delete?');"
                                            action="{{ url('/deleteJadwalHarian/' . $items->TANGGAL_JADWAL_HARIAN) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm rounded circle ml-2"><i
                                                    class="fas fa-trash"></i></button>
                                        </form> --}}
                                    </div>
                                </td>
                            @endif
                        @endforeach
                    </tr>

                    <tr>
                        <td>
                            @if ($tanggalJadwalHarian != null)
                                <div>{{ $tanggalJadwalHarian->TANGGAL_JADWAL_HARIAN->addDays(2)->format('l') }}</div>
                                <div>{{ $tanggalJadwalHarian->TANGGAL_JADWAL_HARIAN->addDays(2)->format('Y m d') }}</div>
                            @endif
                        </td>

                        @foreach ($jadwalHarian as $items)
                            @if ($items->jadwalUmum->HARI_JADWAL == $tanggalJadwalHarian->TANGGAL_JADWAL_HARIAN->addDays(2)->translatedformat('l'))
                                <td>
                                    <span
                                        class="bg-sky padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">{{ $items->TANGGAL_JADWAL_HARIAN->format('H:i:s') }}</span>
                                    <div class="margin-10px-top font-size14">{{ $items->jadwalUmum->kelas->NAMA_KELAS }}
                                    </div>
                                    <div class="margin-10px-top font-size14">{{ $items->instruktur->NAMA_INSTRUKTUR }}
                                    </div>
                                    <div class="margin-10px-top font-size14">{{ $items->KETERANGAN_JADWAL_HARIAN }}</div>
                                    <div class="d-flex align-items-between justify-content-center">
                                        <a href='{{ url('/editJadwalHarian/' . $items->TANGGAL_JADWAL_HARIAN) }}'
                                            class="btn btn-success btn-sm rounded circle mr-2"><i
                                                class="fas fa-pencil"></i></a>
                                        {{-- <form onsubmit="return confirm('Apakah anda yakin delete?');"
                                            action="{{ url('/deleteJadwalHarian/' . $items->TANGGAL_JADWAL_HARIAN) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm rounded circle ml-2"><i
                                                    class="fas fa-trash"></i></button>
                                        </form> --}}
                                    </div>
                                </td>
                            @endif
                        @endforeach
                    </tr>

                    <tr>
                        <td>
                            @if ($tanggalJadwalHarian != null)
                                <div>{{ $tanggalJadwalHarian->TANGGAL_JADWAL_HARIAN->addDays(3)->format('l') }}</div>
                                <div>{{ $tanggalJadwalHarian->TANGGAL_JADWAL_HARIAN->addDays(3)->format('Y m d') }}</div>
                            @endif
                        </td>

                        @foreach ($jadwalHarian as $items)
                            @if ($items->jadwalUmum->HARI_JADWAL == $tanggalJadwalHarian->TANGGAL_JADWAL_HARIAN->addDays(3)->translatedformat('l'))
                                <td>
                                    <span
                                        class="bg-sky padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">{{ $items->TANGGAL_JADWAL_HARIAN->format('H:i:s') }}</span>
                                    <div class="margin-10px-top font-size14">{{ $items->jadwalUmum->kelas->NAMA_KELAS }}
                                    </div>
                                    <div class="margin-10px-top font-size14">{{ $items->instruktur->NAMA_INSTRUKTUR }}
                                    </div>
                                    <div class="margin-10px-top font-size14">{{ $items->KETERANGAN_JADWAL_HARIAN }}</div>
                                    <div class="d-flex align-items-between justify-content-center">
                                        <a href='{{ url('/editJadwalHarian/' . $items->TANGGAL_JADWAL_HARIAN) }}'
                                            class="btn btn-success btn-sm rounded circle mr-2"><i
                                                class="fas fa-pencil"></i></a>
                                        {{-- <form onsubmit="return confirm('Apakah anda yakin delete?');"
                                            action="{{ url('/deleteJadwalHarian/' . $items->TANGGAL_JADWAL_HARIAN) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm rounded circle ml-2"><i
                                                    class="fas fa-trash"></i></button>
                                        </form> --}}
                                    </div>
                                </td>
                            @endif
                        @endforeach
                    </tr>

                    <tr>
                        <td>
                            @if ($tanggalJadwalHarian != null)
                                <div>{{ $tanggalJadwalHarian->TANGGAL_JADWAL_HARIAN->addDays(4)->format('l') }}</div>
                                <div>{{ $tanggalJadwalHarian->TANGGAL_JADWAL_HARIAN->addDays(4)->format('Y m d') }}</div>
                            @endif
                        </td>

                        @foreach ($jadwalHarian as $items)
                            @if ($items->jadwalUmum->HARI_JADWAL == $tanggalJadwalHarian->TANGGAL_JADWAL_HARIAN->addDays(4)->translatedformat('l'))
                                <td>
                                    <span
                                        class="bg-sky padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">{{ $items->TANGGAL_JADWAL_HARIAN->format('H:i:s') }}</span>
                                    <div class="margin-10px-top font-size14">{{ $items->jadwalUmum->kelas->NAMA_KELAS }}
                                    </div>
                                    <div class="margin-10px-top font-size14">{{ $items->instruktur->NAMA_INSTRUKTUR }}
                                    </div>
                                    <div class="margin-10px-top font-size14">{{ $items->KETERANGAN_JADWAL_HARIAN }}</div>
                                    <div class="d-flex align-items-between justify-content-center">
                                        <a href='{{ url('/editJadwalHarian/' . $items->TANGGAL_JADWAL_HARIAN) }}'
                                            class="btn btn-success btn-sm rounded circle mr-2"><i
                                                class="fas fa-pencil"></i></a>
                                        {{-- <form onsubmit="return confirm('Apakah anda yakin delete?');"
                                            action="{{ url('/deleteJadwalHarian/' . $items->TANGGAL_JADWAL_HARIAN) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm rounded circle ml-2"><i
                                                    class="fas fa-trash"></i></button>
                                        </form> --}}
                                    </div>
                                </td>
                            @endif
                        @endforeach
                    </tr>

                    <tr>
                        <td>
                            @if ($tanggalJadwalHarian != null)
                                <div>{{ $tanggalJadwalHarian->TANGGAL_JADWAL_HARIAN->addDays(5)->format('l') }}</div>
                                <div>{{ $tanggalJadwalHarian->TANGGAL_JADWAL_HARIAN->addDays(5)->format('Y m d') }}</div>
                            @endif
                        </td>

                        @foreach ($jadwalHarian as $items)
                            @if ($items->jadwalUmum->HARI_JADWAL == $tanggalJadwalHarian->TANGGAL_JADWAL_HARIAN->addDays(5)->translatedformat('l'))
                                <td>
                                    <span
                                        class="bg-sky padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">{{ $items->TANGGAL_JADWAL_HARIAN->format('H:i:s') }}</span>
                                    <div class="margin-10px-top font-size14">{{ $items->jadwalUmum->kelas->NAMA_KELAS }}
                                    </div>
                                    <div class="margin-10px-top font-size14">{{ $items->instruktur->NAMA_INSTRUKTUR }}
                                    </div>
                                    <div class="margin-10px-top font-size14">{{ $items->KETERANGAN_JADWAL_HARIAN }}</div>
                                    <div class="d-flex align-items-between justify-content-center">
                                        <a href='{{ url('/editJadwalHarian/' . $items->TANGGAL_JADWAL_HARIAN) }}'
                                            class="btn btn-success btn-sm rounded circle mr-2"><i
                                                class="fas fa-pencil"></i></a>
                                        {{-- <form onsubmit="return confirm('Apakah anda yakin delete?');"
                                            action="{{ url('/deleteJadwalHarian/' . $items->TANGGAL_JADWAL_HARIAN) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm rounded circle ml-2"><i
                                                    class="fas fa-trash"></i></button>
                                        </form> --}}
                                    </div>
                                </td>
                            @endif
                        @endforeach
                    </tr>

                    <tr>
                        <td>
                            @if ($tanggalJadwalHarian != null)
                                <div>{{ $tanggalJadwalHarian->TANGGAL_JADWAL_HARIAN->addDays(6)->format('l') }}</div>
                                <div>{{ $tanggalJadwalHarian->TANGGAL_JADWAL_HARIAN->addDays(6)->format('Y m d') }}</div>
                            @endif
                        </td>

                        @foreach ($jadwalHarian as $items)
                            @if ($items->jadwalUmum->HARI_JADWAL == $tanggalJadwalHarian->TANGGAL_JADWAL_HARIAN->addDays(6)->translatedformat('l'))
                                <td>
                                    <span
                                        class="bg-sky padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">{{ $items->TANGGAL_JADWAL_HARIAN->format('H:i:s') }}</span>
                                    <div class="margin-10px-top font-size14">{{ $items->jadwalUmum->kelas->NAMA_KELAS }}
                                    </div>
                                    <div class="margin-10px-top font-size14">{{ $items->instruktur->NAMA_INSTRUKTUR }}
                                    </div>
                                    <div class="margin-10px-top font-size14">{{ $items->KETERANGAN_JADWAL_HARIAN }}</div>
                                    <div class="d-flex align-items-between justify-content-center">
                                        <a href='{{ url('/editJadwalHarian/' . $items->TANGGAL_JADWAL_HARIAN) }}'
                                            class="btn btn-success btn-sm rounded circle mr-2"><i
                                                class="fas fa-pencil"></i></a>
                                        {{-- <form onsubmit="return confirm('Apakah anda yakin delete?');"
                                            action="{{ url('/deleteJadwalHarian/' . $items->TANGGAL_JADWAL_HARIAN) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm rounded circle ml-2"><i
                                                    class="fas fa-trash"></i></button>
                                        </form> --}}
                                    </div>
                                </td>
                            @endif
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
