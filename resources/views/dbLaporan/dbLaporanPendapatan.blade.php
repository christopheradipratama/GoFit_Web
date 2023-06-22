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
        <h3 class="card-title text-center">Laporan Pendapatan</h3>
        <hr style="width: 100%; color: black; height: 1px; background-color:black;" />
        <form action="{{ url('laporanPendapatanProccess') }}" method="get" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <label class="font-weight-bold mb-2">Tahun</label>
                    <select class="form-control mb-3" aria-label="Default select example" name="tahun" id="deposit">
                        <option selected value="" hidden>Pilih Tahun</option>
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
            
                <div class="col-md-6">
                    <label class="font-weight-bold mb-2">Manajer Operasional</label>
                    <input type='text' class="form-control mb-3" name="ID_PEGAWAI"
                        placeholder="Input date of birth member" autocomplete="off"
                        value="P{{ $pegawai->ID_PEGAWAI }} / {{ $pegawai->NAMA_PEGAWAI }}" disabled />
                </div>
            
                <div class="col-md-12">
                    <button type="submit" class="btn btn-success btn-block mb-4">Tampilkan</button>
                </div>
            </div>
        </form>
    </div>
    @if (
        !($data_activation && $data_depo_class && $data_total_income) &&
            !(Session::get('data_activation') && Session::get('data_depo_class') && Session::get('data_total_income')))
    @else
        @php
            $data_activation = Session::get('data_activation');
            $data_depo_class = Session::get('data_depo_class');
            $data_total_income = Session::get('data_total_income');
        @endphp
        <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Laporan Pendapatan</h1>
        </div>
        <div class="card"style="background-color:#B0E0E6">
            {{-- <div class="card-header"style="background-color:#F9E2AF">
            <h3 class="card-title">INCOME REPORT {{ Session::get('year') }}</h3>
        </div> --}}
            <div class="pb-3 ps-3 pe-3 pt-3 d-flex flex-row-reverse justify-content-between">
                <button type="button" class="btn text-black mt-2 no-print" style="background-color: #F0F8FF" onclick="window.print()"><i class="fas fa-solid fa-print fa-fw"></i></button>
                <h3 class="card-title">Laporan Pendatapan Tahun {{ Session::get('year') }}</h3>
            </div>
        </div>
        <!-- START DATA -->
        <div class=" card my-1 p-3 bg-body rounded shadow-sm mt-3">

            <h3>GoFit</h3>
            <p>Jl. Centralpark No.10 Yogyakarta</p>
            <h5 class="underline">LAPORAN PENDAPATAN TAHUNAN</h5>
            <p>PERIODE: {{ Session::get('year') }}</p>
            <p>Tanggal cetak: {{ \Carbon\Carbon::now()->translatedformat('d M Y') }}</p>

            <hr style="width: 100%; color: black; height: 1px; background-color:black;" />

            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th class="col-md-2">Bulan</th>
                        <th class="col-md-2">Aktivasi</th>
                        <th class="col-md-2">Deposit</th>
                        <th class="col-md-2">Total</th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <td class="col-md-2">January</td>
                        @if ($data_activation[0])
                            <td>{{ $data_activation[0][0]->total_income_activation }}</td>
                        @else
                            <td>0</td>
                        @endif
                        @if ($data_depo_class[0])
                            <td class="col-md-2">
                                {{ $data_depo_class[0][0]->total_income_deposit }}
                            </td>
                        @else
                            <td>0</td>
                        @endif
                        @if ($data_total_income[0])
                            <td class="col-md-2">{{ $data_total_income[0][0]->total_income }}</td>
                            @php
                                $temp_total_all = $data_total_income[0][0]->total_income;
                            @endphp
                        @else
                            <td>0</td>
                            @php
                                $temp_total_all = 0;
                            @endphp
                        @endif
                    </tr>

                    <tr>
                        <td class="col-md-2">February</td>
                        @if ($data_activation[1])
                            <td>{{ $data_activation[1][0]->total_income_activation }}</td>
                        @else
                            <td>0</td>
                        @endif
                        @if ($data_depo_class[1])
                            <td class="col-md-2">{{ $data_depo_class[1][0]->total_income_deposit }}</td>
                        @else
                            <td>0</td>
                        @endif
                        @if ($data_total_income[1])
                            <td class="col-md-2">{{ $data_total_income[1][0]->total_income }}</td>
                            @php
                                $temp_total_all += $data_total_income[1][0]->total_income;
                            @endphp
                        @else
                            <td>0</td>
                            @php
                                $temp_total_all += 0;
                            @endphp
                        @endif
                    </tr>

                    <tr>
                        <td class="col-md-2">March</td>
                        @if ($data_activation[2])
                            <td>{{ $data_activation[2][0]->total_income_activation }}</td>
                        @else
                            <td>0</td>
                        @endif
                        @if ($data_depo_class[2])
                            <td class="col-md-2">{{ $data_depo_class[2][0]->total_income_deposit }}</td>
                        @else
                            <td>0</td>
                        @endif
                        @if ($data_total_income[2])
                            <td class="col-md-2">{{ $data_total_income[2][0]->total_income }}</td>
                            @php
                                $temp_total_all += $data_total_income[2][0]->total_income;
                            @endphp
                        @else
                            <td>0</td>
                            @php
                                $temp_total_all += 0;
                            @endphp
                        @endif
                    </tr>
                    <tr>
                        <td class="col-md-2">April</td>
                        @if ($data_activation[3])
                            <td>{{ $data_activation[3][0]->total_income_activation }}</td>
                        @else
                            <td>0</td>
                        @endif
                        @if ($data_depo_class[3])
                            <td class="col-md-2">{{ $data_depo_class[3][0]->total_income_deposit }}</td>
                        @else
                            <td>0</td>
                        @endif
                        @if ($data_total_income[3])
                            <td class="col-md-2">{{ $data_total_income[3][0]->total_income }}</td>
                            @php
                                $temp_total_all += $data_total_income[3][0]->total_income;
                            @endphp
                        @else
                            <td>0</td>
                            @php
                                $temp_total_all += 0;
                            @endphp
                        @endif
                    </tr>
                    <tr>
                        <td class="col-md-2">May</td>
                        @if ($data_activation[4])
                            <td>{{ $data_activation[4][0]->total_income_activation }}</td>
                        @else
                            <td>0</td>
                        @endif
                        @if ($data_depo_class[4])
                            <td class="col-md-2">{{ $data_depo_class[4][0]->total_income_deposit }}</td>
                        @else
                            <td>0</td>
                        @endif
                        @if ($data_total_income[4])
                            <td class="col-md-2">{{ $data_total_income[4][0]->total_income }}</td>
                            @php
                                $temp_total_all += $data_total_income[4][0]->total_income;
                            @endphp
                        @else
                            <td>0</td>
                            @php
                                $temp_total_all += 0;
                            @endphp
                        @endif
                    </tr>
                    <tr>
                        <td class="col-md-2">June</td>
                        @if ($data_activation[5])
                            <td>{{ $data_activation[5][0]->total_income_activation }}</td>
                        @else
                            <td>0</td>
                        @endif
                        @if ($data_depo_class[5])
                            <td class="col-md-2">{{ $data_depo_class[5][0]->total_income_deposit }}</td>
                        @else
                            <td>0</td>
                        @endif
                        @if ($data_total_income[5])
                            <td class="col-md-2">{{ $data_total_income[5][0]->total_income }}</td>
                            @php
                                $temp_total_all += $data_total_income[5][0]->total_income;
                            @endphp
                        @else
                            <td>0</td>
                            @php
                                $temp_total_all += 0;
                            @endphp
                        @endif
                    </tr>
                    <tr>
                        <td class="col-md-2">July</td>
                        @if ($data_activation[6])
                            <td>{{ $data_activation[6][0]->total_income_activation }}</td>
                        @else
                            <td>0</td>
                        @endif
                        @if ($data_depo_class[6])
                            <td class="col-md-2">{{ $data_depo_class[6][0]->total_income_deposit }}</td>
                        @else
                            <td>0</td>
                        @endif
                        @if ($data_total_income[6])
                            <td class="col-md-2">{{ $data_total_income[6][0]->total_income }}</td>
                            @php
                                $temp_total_all += $data_total_income[6][0]->total_income;
                            @endphp
                        @else
                            <td>0</td>
                            @php
                                $temp_total_all += 0;
                            @endphp
                        @endif
                    </tr>
                    <tr>
                        <td class="col-md-2">August</td>
                        @if ($data_activation[7])
                            <td>{{ $data_activation[7][0]->total_income_activation }}</td>
                        @else
                            <td>0</td>
                        @endif
                        @if ($data_depo_class[7])
                            <td class="col-md-2">{{ $data_depo_class[7][0]->total_income_deposit }}</td>
                        @else
                            <td>0</td>
                        @endif
                        @if ($data_total_income[7])
                            <td class="col-md-2">{{ $data_total_income[7][0]->total_income }}</td>
                            @php
                                $temp_total_all += $data_total_income[7][0]->total_income;
                            @endphp
                        @else
                            <td>0</td>
                            @php
                                $temp_total_all += 0;
                            @endphp
                        @endif
                    </tr>
                    <tr>
                        <td class="col-md-2">September</td>
                        @if ($data_activation[8])
                            <td>{{ $data_activation[8][0]->total_income_activation }}</td>
                        @else
                            <td>0</td>
                        @endif
                        @if ($data_depo_class[8])
                            <td class="col-md-2">{{ $data_depo_class[8][0]->total_income_deposit }}</td>
                        @else
                            <td>0</td>
                        @endif
                        @if ($data_total_income[8])
                            <td class="col-md-2">{{ $data_total_income[8][0]->total_income }}</td>
                            @php
                                $temp_total_all += $data_total_income[8][0]->total_income;
                            @endphp
                        @else
                            <td>0</td>
                            @php
                                $temp_total_all += 0;
                            @endphp
                        @endif
                    </tr>
                    <tr>
                        <td class="col-md-2">October</td>
                        @if ($data_activation[9])
                            <td>{{ $data_activation[9][0]->total_income_activation }}</td>
                        @else
                            <td>0</td>
                        @endif
                        @if ($data_depo_class[9])
                            <td class="col-md-2">{{ $data_depo_class[9][0]->total_income_deposit }}</td>
                        @else
                            <td>0</td>
                        @endif
                        @if ($data_total_income[9])
                            <td class="col-md-2">{{ $data_total_income[9][0]->total_income }}</td>
                            @php
                                $temp_total_all += $data_total_income[9][0]->total_income;
                            @endphp
                        @else
                            <td>0</td>
                            @php
                                $temp_total_all += 0;
                            @endphp
                        @endif
                    </tr>
                    <tr>
                        <td class="col-md-2">November</td>
                        @if ($data_activation[10])
                            <td>{{ $data_activation[10][0]->total_income_activation }}</td>
                        @else
                            <td>0</td>
                        @endif
                        @if ($data_depo_class[10])
                            <td class="col-md-2">{{ $data_depo_class[10][0]->total_income_deposit }}</td>
                        @else
                            <td>0</td>
                        @endif
                        @if ($data_total_income[10])
                            <td class="col-md-2">{{ $data_total_income[10][0]->total_income }}</td>
                            @php
                                $temp_total_all += $data_total_income[10][0]->total_income;
                            @endphp
                        @else
                            <td>0</td>
                            @php
                                $temp_total_all += 0;
                            @endphp
                        @endif
                    </tr>
                    <tr>
                        <td class="col-md-2">December</td>
                        @if ($data_activation[11])
                            <td>{{ $data_activation[11][0]->total_income_activation }}</td>
                        @else
                            <td>0</td>
                        @endif
                        @if ($data_depo_class[11])
                            <td class="col-md-2">{{ $data_depo_class[11][0]->total_income_deposit }}</td>
                        @else
                            <td>0</td>
                        @endif
                        @if ($data_total_income[11])
                            <td class="col-md-2">{{ $data_total_income[11][0]->total_income }}</td>
                            @php
                                $temp_total_all += $data_total_income[11][0]->total_income;
                            @endphp
                        @else
                            <td>0</td>
                            @php
                                $temp_total_all += 0;
                            @endphp
                        @endif
                    </tr>
                </tbody>
                <tfoot>
                    <td class="col-md-2" style="text-align: right   " colspan="3"><strong>Total</strong></td>
                        <td>{{ $temp_total_all }}</td>
                </tfoot>
            </table>
            {{-- <div>
        {{ $members->links('pagination::bootstrap-5') }}
    </div> --}}
        </div>

        <div class="card mt-5">
            <div class="card-body mr-5">
                <canvas id="myChart" height="100px"></canvas>
            </div>
        </div>
        {{-- <div class="card mt-5">
        <div class="card-body ms-5">
            <canvas id="myChart2" height="100px"></canvas>
        </div>
    </div> --}}
    @endif


    </div>
    </div>


    </div>
@endsection

@section('footer-script')
    <script type="text/javascript">
        var year = {{ Session::get('year') }};
        var label = {{ Js::from(Session::get('report_keys')) }}
        var value = {{ Js::from(Session::get('report_value')) }}

        console.log(value)

        const data = {
            labels: label,
            datasets: [{
                label: 'Laporan Pendapatan Bulanan Tahun ' + year,
                backgroundColor: 'rgb(176,224,230)',
                borderColor: 'rgb(176,224,230)',
                borderWidth: 1,
                data: value,
            }]
        };

        const config = {
            type: 'bar',
            data: data,
            options: {

            }
        };

        const myChart = new Chart(
            document.getElementById('myChart'),
            config
        );
    </script>
@endsection
