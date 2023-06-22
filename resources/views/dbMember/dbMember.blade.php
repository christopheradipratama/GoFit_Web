@extends('/dashboard')
@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Data Member</h1>
        <a href="{{ url('/addMember') }}" class="btn btn-md btn-dark">ADD</a>
    </div>
    <div class="input-group input-group-sm mb-2">
        <form action="{{ url('/searchMember') }}" method="GET">
            <div class="d-flex align-item-center align-item-beetween">
                <input class="form-control" type="search" placeholder="Search" aria-label="Search" name="search">
                <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-sm text-center">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Alamat</th>
                    <th scope="col">Nomor Telepon</th>
                    <th scope="col">Tanggal Lahir</th>
                    <th scope="col">Jenis Kelamin</th>
                    <th scope="col">Masa Aktivasi</th>
                    <th scope="col">Sisa Deposit Kelas</th>
                    <th scope="col">Sisa Deposit uang</th>
                    <th scope="col">Tanggal Deactive</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($member as $items)
                    <tr>
                        <td class="text-center">{{ $items->ID_MEMBER }}</td>
                        <td class="text-center">{{ $items->NAMA_MEMBER }}</td>
                        <td class="text-center">{{ $items->ALAMAT_MEMBER }}</td>
                        <td class="text-center">{{ $items->NOTELP_MEMBER }}</td>
                        <td class="text-center">{{ $items->TANGGAL_LAHIR_MEMBER }}</td>
                        <td class="text-center">{{ $items->JENIS_KELAMIN_MEMBER }}</td>
                        <td class="text-center">
                            @if ($items->MASA_AKTIVASI === null)
                                Belum Diaktivasi
                            @else
                                {{ $items->MASA_AKTIVASI }}
                            @endif
                        </td>
                        {{-- <td class="text-center">{{$items->MASA_AKTIVASI}}</td> --}}
                        <td class="text-center">
                            @if ($items->SISA_DEPOSIT_KELAS === null)
                                0
                            @else
                                {{ $items->SISA_DEPOSIT_KELAS }}
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($items->SISA_DEPOSIT_UANG === null)
                                0
                            @else
                                {{ $items->SISA_DEPOSIT_UANG }}
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($items->TANGGAL_DEACTIVE_MEMBER === null)
                                -
                            @else
                                {{ $items->TANGGAL_DEACTIVE_MEMBER }}
                            @endif
                        </td>
                        {{-- <td class="text-center">{{ $items->password }}</td> --}}
                        <td class="text-center">
                            <form action="{{ url('/deleteMember/' . $items->ID_MEMBER) }}" method="POST">
                                <a href="{{ url('/editMember/' . $items->ID_MEMBER) }}" class="btn btn-primary"><span
                                        data-feather="edit"><i class="fas fa-pencil-alt"></i></span></a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>

                                <a href="{{ url('/resetPasswordMember/' . $items->ID_MEMBER) }}"
                                    class="btn btn-dark"><span data-feather="edit"><i class="fas fa-unlock-alt"></i></span></a>
                                <a href="{{ url('/cardMember/' . $items->ID_MEMBER) }}"
                                    class="btn btn-success"><span data-feather="edit"><i class="fas fa-vcard"></i></span></a>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{-- <div class="d-flex justify-content-center">
            {!! $member->links() !!}
        </div> --}}
    </div>
@endsection
