@extends('/dashboard')
@section('container')
{{-- <link href="/css/style.css" rel="stylesheet"> --}}
    <div class="card shadow mt-4 mb-4">
        <div class="card-header py-3">
            <h6 class="mx-auto font-weight-bold txt-title">Tampilan Transaksi Aktivasi</h6>
        </div>

        <form action="{{ url('/konfirmasiTransaksiAktivasi') }}" method="get" enctype="multipart/form-data" class="ml-2 mr-2">
            @csrf
            <div class="form-group mt-2">
                <label>Member</label>
                <select class="form-control mb-3 ml-2" aria-label="select member" name="ID_MEMBER">
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
                <label class="font-weight-bold mb-2">Activation Date</label>
                <input type='text' class="form-control mb-3"name="TANGGAL_TRANSAKSI_AKTIVASI"
                    placeholder="Input date of birth member" autocomplete="off"
                    value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" disabled />

                <label class="font-weight-bold mb-2">Expired Date</label>
                <input type='text' class="form-control mb-3"name="EXPIRED_TRANSAKSI_AKTIVASI"
                    placeholder="Input date of birth member" autocomplete="off"
                    value="{{ Carbon\Carbon::now()->addYears(1)->format('Y-m-d') }}" disabled />

                <button type="submit" class="btn btn-info">Submit</button>
            </div>
        </form>

        <div class="card-body">
            {{-- <a href="{{ url('dashboard/createTransaksiAktivasi')}}" class="btn mb-3 mt-3 ml-2 buttonSubmit">Tambah Aktivasi</a> --}}
            <div class="table-responsive">
                <table class="table table-striped table-sm text-center" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nama Member</th>
                            <th scope="col">Nama Kasir</th>
                            <th scope="col">Tanggal Transaksi</th>
                            <th scope="col">Tanggal Kadaluarsa Transaksi</th>
                            <th scope="col">Biaya Aktivasi</th>
                            <th scope="col">Status</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transaksiAktivasi as $items)
                            <tr>
                                <th class="text-center">{{ $items->ID_TRANSAKSI_AKTIVASI }}</th>
                                <td class="text-center">{{ $items->member->NAMA_MEMBER }}</td>
                                <td class="text-center">{{ $items->pegawai->NAMA_PEGAWAI }}</td>
                                <td class="text-center">{{ $items->TANGGAL_TRANSAKSI_AKTIVASI }}</td>
                                <td class="text-center">{{ $items->EXPIRED_TRANSAKSI_AKTIVASI }}</td>
                                <td class="text-center">{{ $items->BIAYA_AKTIVASI }}</td>
                                <td class="text-center">{{ $items->STATUS_AKTIVASI }}</td>
                                <td class="text-center">
                                    <a href="{{ url('/strukTransaksiAktivasi/' . $items->ID_TRANSAKSI_AKTIVASI) }}"
                                        class="btn btn-success"><span data-feather="edit"><i
                                                class="fas fa-vcard"></i></span></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
