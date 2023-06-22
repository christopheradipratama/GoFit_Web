@extends('/dashboard')
@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Data Presensi Booking Gym Sebelum</h1>
        {{-- <a href="{{ url('/addMember') }}" class="btn btn-md btn-dark">ADD</a> --}}
    </div>
    <div class="input-group input-group-sm mb-2">
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-sm text-center">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Slot Waktu</th>
                    <th scope="col">Tanggal Gym</th>
                    <th scope="col">Tanggal Booking</th>
                    <th scope="col">Waktu Konfirmasi</th>
                    <th scope="col">Status</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bookingGym as $items)
                    <tr>
                        <td class="text-center">{{ $items->KODE_BOOKING_GYM }}</td>
                        <td class="text-center">{{ $items->member->NAMA_MEMBER }}</td>
                        <td class="text-center">{{ $items->SLOT_WAKTU_GYM }}</td>
                        <td class="text-center">{{ $items->TANGGAL_BOOKING_GYM }}</td>
                        <td class="text-center">{{ $items->TANGGAL_MELAKUKAN_BOOKING }}</td>
                        <td class="text-center">{{ $items->WAKTU_PRESENSI_GYM }}</td>
                        <td class="text-center">
                            @if ($items->STATUS_PRESENSI_GYM === null)
                                -
                            @else
                                {{ $items->STATUS_PRESENSI_GYM }}
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ url('/konfirmasiGym/' . $items->KODE_BOOKING_GYM) }}" class="btn btn-success"><span
                                    data-feather="edit"><i class="fas fa-vcard"></i></span></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Data Presensi Booking Gym</h1>
        {{-- <a href="{{ url('/addMember') }}" class="btn btn-md btn-dark">ADD</a> --}}
    </div>
    <div class="input-group input-group-sm mb-2">
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-sm text-center">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Slot Waktu</th>
                    <th scope="col">Tanggal Gym</th>
                    <th scope="col">Tanggal Booking</th>
                    <th scope="col">Waktu Konfirmasi</th>
                    <th scope="col">Status</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bookingGym_after as $items)
                    <tr>
                        <td class="text-center">{{ $items->KODE_BOOKING_GYM }}</td>
                        <td class="text-center">{{ $items->member->NAMA_MEMBER }}</td>
                        <td class="text-center">{{ $items->SLOT_WAKTU_GYM }}</td>
                        <td class="text-center">{{ $items->TANGGAL_BOOKING_GYM }}</td>
                        <td class="text-center">{{ $items->TANGGAL_MELAKUKAN_BOOKING }}</td>
                        <td class="text-center">{{ $items->WAKTU_PRESENSI_GYM }}</td>
                        <td class="text-center">
                            @if ($items->STATUS_PRESENSI_GYM === null)
                                -
                            @else
                                {{ $items->STATUS_PRESENSI_GYM }}
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ url('/strukBookingGym/' . $items->KODE_BOOKING_GYM) }}" class="btn btn-success"><span
                                    data-feather="edit"><i class="fas fa-vcard"></i></span></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
