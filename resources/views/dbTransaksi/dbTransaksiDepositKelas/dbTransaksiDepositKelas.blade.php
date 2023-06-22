@extends('/dashboard')
@section('container')

    <div class="card shadow mt-4 mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold txt-title">Tampilan Transaksi Deposit Kelas </h6>
        </div>

        <form action="{{ url('/konfirmasiTransaksiDepositKelas') }}" method="get" enctype="multipart/form-data" class="ml-2 mr-2">
            @csrf
            <div class="form-group">
                <label>Member</label>
                <select class="form-control mb-3" aria-label="select member" name="ID_MEMBER">
                    <option value="" hidden>Select Member</option>
                    @if ($member->first() != null)
                        @foreach ($member as $item_member)
                            <option value="{{ $item_member->ID_MEMBER }}">
                                {{ $item_member->NAMA_MEMBER }}</option>
                        @endforeach
                    @else
                        <option value=""disabled>All member has been activated</option>
                    @endif
                </select>

                <label>Kelas</label>
                <select class="form-control mb-3" aria-label="select member" name="ID_KELAS">
                    <option value="" hidden>Pilih Kelas</option>
                    @if ($kelas->first() != null)
                        @foreach ($kelas as $items)
                            <option value="{{ $items->ID_KELAS }}">
                                {{ $items->NAMA_KELAS }}</option>
                        @endforeach
                    @endif
                </select>

                <label>Paket Kelas</label>
                <select class="form-control mb-3" aria-label="select member" name="JUMLAH_DEPOSIT_KELAS">
                    <option value="" hidden>Pilih Paket Kelas</option>
                    <option value="5">5 Paket Kelas</option>
                    <option value="10">10 Paket Kelas</option>
                </select>

                <label class="font-weight-bold mb-2">Kasir</label>
                <input type='text' class="form-control mb-3" name="NAMA_KASIR" id="NAMA_KASIR"
                    placeholder="Input Nominal" autocomplete="off" value="{{ $pegawai->NAMA_PEGAWAI }}" disabled />

                <label class="font-weight-bold mb-2">Activation Date</label>
                <input type='text' class="form-control mb-3" name="TANGGAL_DEPOSIT_UANG"
                    placeholder="Input date of birth member" autocomplete="off"
                    value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" disabled />

                <button type="submit" class="btn btn-info">Submit</button>
            </div>
        </form>

        <div class="card-body">
            <table class="table table-striped table-sm text-center">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nama Member</th>
                        <th scope="col">Promo</th>
                        <th scope="col">Nama Kasir</th>
                        <th scope="col">Nama Kelas</th>
                        <th scope="col">Nominal Deposit</th>
                        <th scope="col">Bonus</th>
                        <th scope="col">Total Deposit</th>
                        <th scope="col">Jumlah Pembayaran</th>
                        <th scope="col">Tanggal Deposit</th>
                        <th scope="col">Tanggal Kadaluarsa</th>
                        {{-- <th scope="col">Sisa Deposit Kelas</th> --}}
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transaksiDepositKelas as $items)
                        <tr>
                            <td class="text-center ">{{ $items->ID_TRANSAKSI_DEPOSIT_KELAS }}</td>
                            <td class="text-center ">{{ $items->member->NAMA_MEMBER }}</td>
                            @if ($items->ID_PROMO != null)
                                <td class="text-center">{{ $items->promo->NAMA_PROMO }}</td>
                            @else
                                <td class="text-center">-</td>
                            @endif
                            <td class="text-center ">{{ $items->pegawai->NAMA_PEGAWAI }}</td>
                            <td class="text-center ">{{ $items->kelas->NAMA_KELAS }}</td>
                            <td class="text-center ">{{ $items->JUMLAH_DEPOSIT_KELAS }}</td>
                            @if ($items->BONUS_DEPOSIT_KELAS != null)
                                <td class="text-center">{{ $items->BONUS_DEPOSIT_KELAS }}</td>
                            @else
                                <td class="text-center">-</td>
                            @endif
                            <td class="text-center ">{{ $items->TOTAL_DEPOSIT_KELAS }}</td>
                            <td class="text-center ">{{ $items->JUMLAH_PEMBAYARAN }}</td>
                            <td class="text-center ">{{ $items->TANGGAL_DEPOSIT_KELAS }}</td>
                            <td class="text-center ">{{ $items->MASA_BERLAKU_KELAS }}</td>
                            {{-- <td class="text-center ">{{ $items->member->SISA_DEPOSIT_KELAS }}</td> --}}
                            <td>
                                <a href="{{ url('/strukTransaksiDepositKelas/' . $items->ID_TRANSAKSI_DEPOSIT_KELAS) }}"
                                    class="btn btn-success"><span data-feather="edit"><i
                                            class="fas fa-vcard"></i></span></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
