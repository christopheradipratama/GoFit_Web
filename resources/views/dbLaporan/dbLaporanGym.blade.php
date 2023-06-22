@extends('/dashboard')
@section('container')
    <style>
        @media print {

            .no-print,
            .no-print * {
                display: none !important;
            }
        }

        .underline {
            text-decoration: underline;
        }
    </style>
    <div class=" card my-5 p-3 bg-body rounded shadow-lg w-50 mx-auto no-print">
        <h3 class="card-title text-center">Laporan Aktivitas Gym Bulanan</h3>
        <hr style="width: 100%; color: black; height: 1px; background-color:black;" />
        <form action="{{ url('/laporanGymProccess') }}" method="get" enctype="multipart/form-data">
            @csrf
            <div class="form-row mb-2">
                <div class="form-group col-md-6">
                    <label class="font-weight-bold mb-2">Tahun</label>
                    <select class="form-control mb-3" aria-label="Default select example" name="year_filter">
                        <option value="" hidden>Pilih Tahun</option>
                        @php
                            $year = \Carbon\Carbon::now()->addYears(1);
                        @endphp
                        @for ($i = 0; $i < 3; $i++)
                            @php
                                $year->subYears(1);
                            @endphp
                            <option value={{ $year->format('Y') }}>
                                {{ $year->format('Y') }}</option>
                        @endfor
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label class="font-weight-bold mb-2">Bulan</label>
                    <select class="form-control mb-3" aria-label="Default select example" name="month_filter">
                        <option value="" hidden>Pilih Bulan</option>
                        @php
                            $month = \Carbon\Carbon::now()->month();
                        @endphp
                        @for ($i = 0; $i < 12; $i++)
                            @php
                                $month->addMonth(1);
                            @endphp
                            <option value={{ $month->format('m') }}>
                                {{ $month->format('F') }}</option>
                        @endfor
                    </select>
                </div>

                <div class="form-group col-md-12">
                    <label class="font-weight-bold mb-2">Manajer Operasional</label>
                    <input type='text' class="form-control mb-3"name="ID_PEGAWAI"
                        placeholder="Input date of birth member" autocomplete="off"
                        value="P{{ $pegawai->ID_PEGAWAI }} / {{ $pegawai->NAMA_PEGAWAI }}" disabled />
                </div>



                <button type="submit" class="btn btn-success btn-block mb-4">Tampilkan</button>
            </div>
        </form>
    </div>
    @if (!Session::get('print'))
        {{-- <div class="alert alert-danger">
            Data report not found. Please input month and year!
        </div> --}}
    @else
        @php
            $data_gym_activity = Session::get('data_gym_activity');
        @endphp
        <div class="card"style="background-color:#B0E0E6">
            <div class="pb-3 ps-3 pe-3 pt-3 d-flex justify-content-between">
                <h3 class="card-title">Laporan Aktivitas Gym Bulan {{ Session::get('year') }}</h3>
                @if ($data_gym_activity)
                    <button type="button" class="btn text-black mt-2 no-print" style="background-color: #F0F8FF"
                        onclick="window.print()"><i class="fas fa-solid fa-print fa-fw"></i></button>
                @endif

            </div>
        </div>

        <div class=" card my-1 p-3 bg-body rounded shadow-sm mt-3">

            <h3>GoFit</h3>
            <p>Jl. Centralpark No.10 Yogyakarta</p>
            <h5 class="underline">LAPORAN PENDAPATAN TAHUNAN</h5>
            <div class="d-flex">
                <p>BULAN: {{ \Carbon\Carbon::now()->month(Session::get('month'))->translatedformat('F') }} </p>
                <p class="ms-3">PERIODE: {{ Session::get('year') }}</p>
            </div>

            <p>Tanggal cetak: {{ \Carbon\Carbon::now()->translatedformat('d M Y') }}</p>

            <hr style="width: 100%; color: black; height: 1px; background-color:black;" />

            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th class="col-md-2">TANGGAL</th>
                        <th class="col-md-2">JUMLAH MEMBER</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data_gym_activity as $item)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedformat('d F Y') }}</td>
                            <td>{{ $item->jumlah_member }}</td>
                        </tr>
                    @empty
                        <div class="alert alert-danger">
                            Data report empty
                        </div>
                    @endforelse
                </tbody>
            </table>
            {{-- <div>
            {{ $members->links('pagination::bootstrap-5') }}
        </div> --}}
            {{-- </div>

        <div class="card mt-5">
            <div class="card-body mr-5">
                <canvas id="myChart" height="100px"></canvas>
            </div>
        </div> --}}
            {{-- <div class="card mt-5">
            <div class="card-body ms-5">
                <canvas id="myChart2" height="100px"></canvas>
            </div>
        </div> --}}
    @endif
@endsection
