@extends('/dashboard')
@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Data Terlambat Instruktur</h1>
        <a href="{{ url('/processResetTerlambat') }}" class="btn btn-md btn-dark">Reset Terlambat</a>
    </div>
    <div class="input-group input-group-sm mb-2">
        {{-- <form action="{{ url('/searchInstruktur') }}" method="GET">
            <div class="d-flex align-item-center align-item-beetween">
                <input class="form-control" type="search" placeholder="Search" aria-label="Search" name="search">
                <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form> --}}

    </div>
    <div class="table-responsive">
        <table class="table table-striped table-sm text-center">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Alamat</th>
                    <th scope="col">Email</th>
                    <th scope="col">Nomor Telepon</th>
                    <th scope="col">Tanggal Lahir</th>
                    <th scope="col">Jenis Kelamin</th>
                    <th scope="col">Jumlah Terlambat</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($instruktur as $items)
                    <tr>
                        <td class="text-center">{{ $items->ID_INSTRUKTUR }}</td>
                        <td class="text-center">{{ $items->NAMA_INSTRUKTUR }}</td>
                        <td class="text-center">{{ $items->ALAMAT_INSTRUKTUR }}</td>
                        <td class="text-center">{{ $items->EMAIL_INSTRUKTUR }}</td>
                        <td class="text-center">{{ $items->NOTELP_INSTRUKTUR }}</td>
                        <td class="text-center">{{ $items->TANGGAL_LAHIR_INSTRUKTUR }}</td>
                        <td class="text-center">{{ $items->JENIS_KELAMIN_INSTRUKTUR }}</td>
                        <td class="text-center">{{ $items->JUMLAH_TERLAMBAT }}</td>
                        {{-- <td class="text-center">
                            <form action="{{ url('/deleteInstruktur/' . $items->ID_INSTRUKTUR) }}" method="POST">
                                <a href="{{ url('/editInstruktur/' . $items->ID_INSTRUKTUR) }}" class="btn btn-primary"><span
                                        data-feather="edit"><i class="fas fa-pencil-alt"></i></span></a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td> --}}
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
