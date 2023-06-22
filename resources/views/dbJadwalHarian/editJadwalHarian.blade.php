@extends('/dashboard')
@section('container')

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ url('/updateJadwalHarian/' . $jadwalHarian->TANGGAL_JADWAL_HARIAN) }}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <div class="form-group col-md-6">
                <label for="inputEmail4">Instruktur</label>
                <select type="text" name="ID_INSTRUKTUR" class="form-control" id="inputEmail4" placeholder="Email">
                    <option value="" hidden>Pilih Instruktur</option>
                    @foreach ($instruktur as $items)
                        {{-- <option value="{{ $items->ID_KELAS }}">{{ $items->NAMA_KELAS }}</option> --}}
                        <option value="{{ $items->ID_INSTRUKTUR }}"
                            {{ $jadwalHarian->ID_INSTRUKTUR == $items->ID_INSTRUKTUR ? 'selected' : '' }}>
                            {{ $items->NAMA_INSTRUKTUR }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="inputAddress2">Keterangan</label>
            <input type="text" name="KETERANGAN_JADWAL_HARIAN" class="form-control" id="inputAddress2" placeholder="Input Keterangan" value="{{ $jadwalHarian->KETERANGAN_JADWAL_HARIAN }}"">
        </div>
        <button type="submit" class="btn btn-primary mt-2">Submit</button>
    </form>

@endsection
