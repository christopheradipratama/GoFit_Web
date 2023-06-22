@extends('/dashboard')
@section('container')

    <div class="card shadow mt-4 mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold txt-title">Tampilan Transaksi Deposit Uang </h6>
        </div>

        <form action="{{ url('/addTransaksiDepositUang') }}" method="post" enctype="multipart/form-data" class="ml-5 mr-5">
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

                <label class="font-weight-bold mb-2">Input Nominal Deposit</label>
                <input type='text' class="form-control mb-3" name="JUMLAH_DEPOSIT_UANG" id="JUMLAH_DEPOSIT_UANG"
                    placeholder="Input Nominal" autocomplete="off" />

                <label class="font-weight-bold mb-2">Activation Date</label>
                <input type='text' class="form-control mb-3" name="TANGGAL_DEPOSIT_UANG"
                    placeholder="Input date of birth member" autocomplete="off"
                    value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" disabled />


                <button type="submit" class="btn btn-info mx-auto">Submit</button>
            </div>
        </form>

        <div class="card-body">
            {{-- <a href="{{ url('dashboard/createTransaksiAktivasi') }}" class="btn mb-3 mt-3 ml-2 buttonSubmit">Tambah
                Aktivasi</a> --}}

            <table class="table table-striped table-sm text-center">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nama Member</th>
                        <th scope="col">Promo</th>
                        <th scope="col">Nama Kasir</th>
                        <th scope="col">Nominal Deposit</th>
                        <th scope="col">Bonus</th>
                        <th scope="col">Sisa Deposit Uang</th>
                        <th scope="col">Total Deposit Uang</th>
                        <th scope="col">Tanggal Deposit Uang</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transaksiDepositUang as $items)
                        <tr>
                            <td class="text-center ">{{ $items->ID_TRANSAKSI_DEPOSIT_UANG }}</td>
                            <td class="text-center ">{{ $items->member->NAMA_MEMBER }}</td>
                            @if ($items->ID_PROMO != null)
                                <td class="text-center">{{ $items->promo->JENIS_PROMO }}</td>
                            @else
                                <td class="text-center">-</td>
                            @endif
                            <td class="text-center ">{{ $items->pegawai->NAMA_PEGAWAI }}</td>
                            <td class="text-center ">{{ $items->JUMLAH_DEPOSIT_UANG }}</td>
                            <td class="text-center ">{{ $items->BONUS_DEPOSIT_UANG }}</td>
                            <td class="text-center ">{{ $items->SISA_DEPOSIT }}</td>
                            <td class="text-center ">{{ $items->TOTAL_DEPOSIT_UANG }}</td>
                            <td class="text-center ">{{ $items->TANGGAL_DEPOSIT_UANG }}</td>
                            <td>
                                <a href="{{ url('/strukTransaksiDepositUang/' . $items->ID_TRANSAKSI_DEPOSIT_UANG) }}"
                                    class="btn btn-success"><span data-feather="edit"><i
                                            class="fas fa-vcard"></i></span></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>x
@endsection
