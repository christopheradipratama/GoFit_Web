@extends('/dashboard')
@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Data Izin Instruktur</h1>
        {{-- <a href="{{ url('/addInstruktur') }}" class="btn btn-md btn-dark">ADD</a> --}}
    </div>
    <div class="input-group input-group-sm mb-2">
        <form action="{{ url('/searchInstruktur') }}" method="GET">
            <div class="d-flex align-item-center align-item-beetween">
                {{-- <input class="form-control" type="search" placeholder="Search" aria-label="Search" name="search">
                <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                </button> --}}
            </div>
        </form>

    </div>
    <div class="table-responsive">
        <table class="table table-striped table-sm text-center">
            <thead>
                <tr>
                    <th scope="col">ID Izin</th>
                    <th scope="col">ID Instruktur</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Tanggal Izin</th>
                    <th scope="col">Tanggal Pengajuan</th>
                    <th scope="col">Keterangan</th>
                    <th scope="col">Tanggal Konfirmasi</th>
                    <th scope="col">Status</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($izinInstruktur as $items)
                    <tr>
                        <td class="text-center">{{ $items->ID_IZIN_INSTRUKTUR }}</td>
                        <td class="text-center">{{ $items->ID_INSTRUKTUR }}</td>
                        <td class="text-center">{{ $items->instruktur->NAMA_INSTRUKTUR }}</td>
                        <td class="text-center">{{ $items->TANGGAL_IZIN_INSTRUKTUR }}</td>
                        <td class="text-center">{{ $items->TANGGAL_MELAKUKAN_IZIN }}</td>
                        <td class="text-center">{{ $items->KETERANGAN_IZIN }}</td>
                        <td class="text-center">{{ $items->TANGGAL_KONFIRMASI_IZIN }}</td>
                        <td class="text-center">{{ $items->STATUS_IZIN }}</td>
                        <td class="text-center">
                            <a href="{{ url('/updateIzinInstruktur/' . $items->ID_IZIN_INSTRUKTUR) }}" class="btn btn-primary"><span
                                    data-feather="edit"><i class="fas fa-undo"></i></span></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
