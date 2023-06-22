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

    <form method="POST" action="{{ url('/updateJadwalUmum/' . $jadwalUmum->ID_JADWAL_UMUM) }}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <div class="form-group col-md-6">
                <label for="inputEmail4">Kelas</label>
                <select type="text" name="ID_KELAS" class="form-control" id="inputEmail4" placeholder="Email">
                    <option value="" hidden>Pilih Kelas</option>
                    @foreach ($kelas as $items)
                        {{-- <option value="{{ $items->ID_KELAS }}">{{ $items->NAMA_KELAS }}</option> --}}
                        <option value="{{ $items->ID_KELAS }}"
                            {{ $jadwalUmum->ID_KELAS == $items->ID_KELAS ? 'selected' : '' }}>
                            {{ $items->NAMA_KELAS }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="inputAddress2">Tanggal</label>
                <input type="date" name="TANGGAL_JADWAL" class="form-control" id="inputAddress2" placeholder="Pilih Tanggal" value="{{ $jadwalUmum->TANGGAL_JADWAL }}"">
            </div>
            <div class="form-group col-md-6">
                <label for="inputPassword4">Hari</label>
                <select type="text" name="HARI_JADWAL" class="form-control" id="inputEmail4" placeholder="Email">
                    <option value="" hidden>Pilih Hari</option>
                    @if ($jadwalUmum->HARI_JADWAL == 'Senin')
                        <option value="Senin" selected>Senin</option>
                    @else
                        <option value="Senin">Senin</option>
                    @endif

                    @if ($jadwalUmum->HARI_JADWAL == 'Selasa')
                        <option value="Selasa" selected>Selasa</option>
                    @else
                        <option value="Selasa">Selasa</option>
                    @endif

                    @if ($jadwalUmum->HARI_JADWAL == 'Rabu')
                        <option value="Rabu" selected>Rabu</option>
                    @else
                        <option value="Rabu">Rabu</option>
                    @endif

                    @if ($jadwalUmum->HARI_JADWAL == 'Kamis')
                        <option value="Kamis" selected>Kamis</option>
                    @else
                        <option value="Kamis">Kamis</option>
                    @endif

                    @if ($jadwalUmum->HARI_JADWAL == 'Jumat')
                        <option value="Jumat" selected>Jumat</option>
                    @else
                        <option value="Jumat">Jumat</option>
                    @endif

                    @if ($jadwalUmum->HARI_JADWAL == 'Sabtu')
                        <option value="Sabtu" selected>Sabtu</option>
                    @else
                        <option value="Sabtu">Sabtu</option>
                    @endif

                    @if ($jadwalUmum->HARI_JADWAL == 'Minggu')
                        <option value="Minggu" selected>Minggu</option>
                    @else
                        <option value="Minggu">Minggu</option>
                    @endif
                </select>
            </div>
        </div>
        <div class="form-group col-md-6">
            <label for="inputAddress">Instruktur</label>
            <select type="text" name="ID_INSTRUKTUR" class="form-control" id="inputEmail4" placeholder="Email">
                <option value="" hidden>Pilih Instruktur</option>
                {{-- @foreach ($instruktur as $items)
                    <option value="{{ $items->ID_INSTRUKTUR }}">{{ $items->NAMA_INSTRUKTUR }}</option>
                @endforeach --}}

                @foreach ($instruktur as $items)
                        {{-- <option value="{{ $items->ID_KELAS }}">{{ $items->NAMA_KELAS }}</option> --}}
                        <option value="{{ $items->ID_INSTRUKTUR }}"
                            {{ $jadwalUmum->ID_INSTRUKTUR == $items->ID_INSTRUKTUR ? 'selected' : '' }}>
                            {{ $items->NAMA_INSTRUKTUR }}</option>
                    @endforeach
            </select>
        </div>
        <div class="form-group col-md-6">
            <label for="inputAddress2">Waktu</label>
            <input type="time" step="2" name="WAKTU_JADWAL" class="form-control" id="inputAddress2" placeholder="Pilih Waktu" value="{{ $jadwalUmum->WAKTU_JADWAL }}"">
        </div>
        <button type="submit" class="btn btn-primary mt-2">Submit</button>
    </form>

@endsection
