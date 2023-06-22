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
            <h1 class="h2">Data Jadwal Umum</h1>
            <a href="{{ url('/addJadwalUmum') }}" class="btn btn-md btn-dark">ADD</a>
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
                        <th>Monday
                            @foreach ($jadwalUmum as $items)
                                @if ($items->HARI_JADWAL == 'Senin')
                        <td>
                            <span
                                class="bg-sky padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">{{ $items->instruktur->NAMA_INSTRUKTUR }}</span>
                            <div class="margin-10px-top font-size14">{{ $items->WAKTU_JADWAL }}</div>
                            <div class="margin-10px-top font-size14">{{ $items->kelas->NAMA_KELAS }}</div>
                            <div class="d-flex align-items-between justify-content-center">
                                <a href='{{ url('/editJadwalUmum/' . $items->ID_JADWAL_UMUM) }}'
                                    class="btn btn-success btn-sm rounded circle mr-2"><i class="fas fa-pencil"></i></a>
                                <form onsubmit="return confirm('Apakah anda yakin delete?');"
                                    action="{{ url('/deleteJadwalUmum/' .$items->ID_JADWAL_UMUM) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm rounded circle ml-2"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                            {{-- <div class="font-size13 text-light-gray">Ivana Wong</div> --}}
                        </td>
                        @endif
                        @endforeach
                        </th>
                    </tr>
                    <tr>
                        <th>Tuesday
                            @foreach ($jadwalUmum as $items)
                                @if ($items->HARI_JADWAL == 'Selasa')
                        <td>
                            <span
                                class="bg-green padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">{{ $items->instruktur->NAMA_INSTRUKTUR }}</span>
                            <div class="margin-10px-top font-size14">{{ $items->WAKTU_JADWAL }}</div>
                            <div class="margin-10px-top font-size14">{{ $items->kelas->NAMA_KELAS }}</div>
                            <div class="d-flex align-items-between justify-content-center">
                                <a href='{{ url('/editJadwalUmum/' . $items->ID_JADWAL_UMUM) }}'
                                    class="btn btn-success btn-sm rounded circle mr-2"><i class="fas fa-pencil"></i></a>
                                <form onsubmit="return confirm('Apakah anda yakin delete?');"
                                    action="{{ url('/deleteJadwalUmum/' .$items->ID_JADWAL_UMUM) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm rounded circle ml-2"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                            {{-- <div class="font-size13 text-light-gray">Ivana Wong</div> --}}
                        </td>
                        @endif
                        @endforeach
                        </th>
                    </tr>
                    <tr>
                        <th>Wednesday
                            @foreach ($jadwalUmum as $items)
                                @if ($items->HARI_JADWAL == 'Rabu')
                        <td>
                            <span
                                class="bg-yellow padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">{{ $items->instruktur->NAMA_INSTRUKTUR }}</span>
                            <div class="margin-10px-top font-size14">{{ $items->WAKTU_JADWAL }}</div>
                            <div class="margin-10px-top font-size14">{{ $items->kelas->NAMA_KELAS }}</div>
                            <div class="d-flex align-items-between justify-content-center">
                                <a href='{{ url('/editJadwalUmum/' . $items->ID_JADWAL_UMUM) }}'
                                    class="btn btn-success btn-sm rounded circle mr-2"><i class="fas fa-pencil"></i></a>
                                <form onsubmit="return confirm('Apakah anda yakin delete?');"
                                    action="{{ url('/deleteJadwalUmum/' .$items->ID_JADWAL_UMUM) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm rounded circle ml-2"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                            {{-- <div class="font-size13 text-light-gray">Ivana Wong</div> --}}
                        </td>
                        @endif
                        @endforeach
                        </th>
                    </tr>
                    <tr>
                        <th>Thursday
                            @foreach ($jadwalUmum as $items)
                                @if ($items->HARI_JADWAL == 'Kamis')
                        <td>
                            <span
                                class="bg-lightred padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">{{ $items->instruktur->NAMA_INSTRUKTUR }}</span>
                            <div class="margin-10px-top font-size14">{{ $items->WAKTU_JADWAL }}</div>
                            <div class="margin-10px-top font-size14">{{ $items->kelas->NAMA_KELAS }}</div>
                            <div class="d-flex align-items-between justify-content-center">
                                <a href='{{ url('/editJadwalUmum/' . $items->ID_JADWAL_UMUM) }}'
                                    class="btn btn-success btn-sm rounded circle mr-2"><i class="fas fa-pencil"></i></a>
                                <form onsubmit="return confirm('Apakah anda yakin delete?');"
                                    action="{{ url('/deleteJadwalUmum/' .$items->ID_JADWAL_UMUM) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm rounded circle ml-2"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                            {{-- <div class="font-size13 text-light-gray">Ivana Wong</div> --}}
                        </td>
                        @endif
                        @endforeach
                        </th>
                    </tr>
                    <tr>
                        <th>Friday
                            @foreach ($jadwalUmum as $items)
                                @if ($items->HARI_JADWAL == 'Jumat')
                        <td>
                            <span
                                class="bg-purple padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">{{ $items->instruktur->NAMA_INSTRUKTUR }}</span>
                            <div class="margin-10px-top font-size14">{{ $items->WAKTU_JADWAL }}</div>
                            <div class="margin-10px-top font-size14">{{ $items->kelas->NAMA_KELAS }}</div>
                            <div class="d-flex align-items-between justify-content-center">
                                <a href='{{ url('/editJadwalUmum/' . $items->ID_JADWAL_UMUM) }}'
                                    class="btn btn-success btn-sm rounded circle mr-2"><i class="fas fa-pencil"></i></a>
                                <form onsubmit="return confirm('Apakah anda yakin delete?');"
                                    action="{{ url('/deleteJadwalUmum/' .$items->ID_JADWAL_UMUM) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm rounded circle ml-2"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                            {{-- <div class="font-size13 text-light-gray">Ivana Wong</div> --}}
                        </td>
                        @endif
                        @endforeach
                        </th>
                    </tr>
                    <tr>
                        <th>Saturday
                            @foreach ($jadwalUmum as $items)
                                @if ($items->HARI_JADWAL == 'Sabtu')
                        <td>
                            <span
                                class="bg-pink padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">{{ $items->instruktur->NAMA_INSTRUKTUR }}</span>
                            <div class="margin-10px-top font-size14">{{ $items->WAKTU_JADWAL }}</div>
                            <div class="margin-10px-top font-size14">{{ $items->kelas->NAMA_KELAS }}</div>
                            <div class="d-flex align-items-between justify-content-center">
                                <a href='{{ url('/editJadwalUmum/' . $items->ID_JADWAL_UMUM) }}'
                                    class="btn btn-success btn-sm rounded circle mr-2"><i class="fas fa-pencil"></i></a>
                                <form onsubmit="return confirm('Apakah anda yakin delete?');"
                                    action="{{ url('/deleteJadwalUmum/' .$items->ID_JADWAL_UMUM) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm rounded circle ml-2"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                            {{-- <div class="font-size13 text-light-gray">Ivana Wong</div> --}}
                        </td>
                        @endif
                        @endforeach
                        </th>
                    </tr>
                    <tr>
                        <th>Sunday
                            @foreach ($jadwalUmum as $items)
                                @if ($items->HARI_JADWAL == 'Minggu')
                        <td>
                            <span
                                class="bg-primary padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">{{ $items->instruktur->NAMA_INSTRUKTUR }}</span>
                            <div class="margin-10px-top font-size14">{{ $items->WAKTU_JADWAL }}</div>
                            <div class="margin-10px-top font-size14">{{ $items->kelas->NAMA_KELAS }}</div>
                            <div class="d-flex align-items-between justify-content-center">
                                <a href='{{ url('/editJadwalUmum/' . $items->ID_JADWAL_UMUM) }}'
                                    class="btn btn-success btn-sm rounded circle mr-2"><i class="fas fa-pencil"></i></a>
                                <form onsubmit="return confirm('Apakah anda yakin delete?');"
                                    action="{{ url('/deleteJadwalUmum/' .$items->ID_JADWAL_UMUM) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm rounded circle ml-2"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                            {{-- <div class="font-size13 text-light-gray">Ivana Wong</div> --}}
                        </td>
                        @endif
                        @endforeach
                        </th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
