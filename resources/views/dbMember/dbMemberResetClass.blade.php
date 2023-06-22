@extends('/dashboard')
@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Data Kelas Belum Reset</h1>
        <a href="{{ url('/proccessResetClass') }}" class="btn btn-md btn-dark">Reset</a>
    </div>
    <div class="input-group input-group-sm mb-2">
        <form action="{{ url('/searchMember') }}" method="GET">
            <div class="d-flex align-item-center align-item-beetween">
                {{-- <input class="form-control" type="search" placeholder="Search" aria-label="Search" name="search">
                <button class="btn btn-navbar" type="submit"> --}}
                {{-- <i class="fas fa-search"></i> --}}
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
                    <th scope="col">Kelas</th>
                    <th scope="col">Sisa Deposit</th>
                    <th scope="col">Masa Berlaku</th>
                    <th scope="col">Masa Expired</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($member as $items)
                    <tr>
                        <td class="text-center">{{ $items->ID_MEMBER_DEPOSIT_KELAS }}</td>
                        <td class="text-center">{{ $items->member->NAMA_MEMBER }}</td>
                        <td class="text-center">{{ $items->kelas->NAMA_KELAS }}</td>
                        <td class="text-center">{{ $items->SISA_DEPOSIT }}</td>
                        <td class="text-center">{{ $items->MASA_BERLAKU }}</td>
                        <td class="text-center">{{ $items->EXPIRED_RESET_KELAS }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Data Kelas Reset</h1>
        {{-- <a href="{{ url('/addMember') }}" class="btn btn-md btn-dark">ADD</a> --}}
    </div>
    <div class="input-group input-group-sm mb-2">
        <form action="{{ url('/searchMember') }}" method="GET">
            <div class="d-flex align-item-center align-item-beetween">
                {{-- <input class="form-control" type="search" placeholder="Search" aria-label="Search" name="search">
                <button class="btn btn-navbar" type="submit"> --}}
                {{-- <i class="fas fa-search"></i> --}}
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
                    <th scope="col">Kelas</th>
                    <th scope="col">Sisa Deposit</th>
                    <th scope="col">Masa Berlaku</th>
                    <th scope="col">Masa Expired</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($member_after as $items)
                    <tr>
                        <td class="text-center">{{ $items->ID_MEMBER_DEPOSIT_KELAS }}</td>
                        <td class="text-center">{{ $items->member->NAMA_MEMBER }}</td>
                        <td class="text-center">{{ $items->kelas->NAMA_KELAS }}</td>
                        <td class="text-center">{{ $items->SISA_DEPOSIT }}</td>
                        <td class="text-center">
                            @if ($items->MASA_BERLAKU === null)
                                -
                            @else
                                {{ $items->MASA_BERLAKU }}
                            @endif
                        </td>
                        <td class="text-center">{{ $items->EXPIRED_RESET_KELAS }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    </div>
@endsection
