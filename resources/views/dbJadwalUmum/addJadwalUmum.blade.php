@extends('/dashboard')
@section('container')

{{-- @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif --}}

<form method="POST" action="{{ url('/storeJadwalUmum') }}">
    @csrf
    <div class="form-group">
      <div class="form-group col-md-6">
        <label for="inputEmail4">Kelas</label>
        <select type="text" name="ID_KELAS" class="form-control" id="inputEmail4" placeholder="Email">
            <option value="" hidden>Pilih Kelas</option>
            @foreach($kelas as $items)
            <option value="{{ $items->ID_KELAS }}">{{ $items->NAMA_KELAS }}</option>
            @endforeach
        </select>
      </div>
      <div class="form-group">
        <label for="inputAddress2">Tanggal</label>
        <input type="date" name="TANGGAL_JADWAL" class="form-control" id="inputAddress2" placeholder="Pilih Tanggal">
      </div>
      <div class="form-group col-md-6">
        <label for="inputPassword4">Hari</label>
        <select type="text" name="HARI_JADWAL" class="form-control" id="inputEmail4" placeholder="Email">
            <option value="" hidden>Pilih Hari</option>
            <option value="Senin">Senin</option>
            <option value="Selasa">Selasa</option>
            <option value="Rabu">Rabu</option>
            <option value="Kamis">Kamis</option>
            <option value="Jumat">Jumat</option>
            <option value="Sabtu">Sabtu</option>
            <option value="Minggu">Minggu</option>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label for="inputAddress">Instruktur</label>
      <select type="text" name="ID_INSTRUKTUR" class="form-control" id="inputEmail4" placeholder="Email">
        <option value="" hidden>Pilih Instruktur</option>
        @foreach($instruktur as $items)
        <option value="{{ $items->ID_INSTRUKTUR }}">{{ $items->NAMA_INSTRUKTUR }}</option>
        @endforeach
    </select>
    </div>
    <div class="form-group">
      <label for="inputAddress2">Waktu</label>
      <input type="time" step="2" name="WAKTU_JADWAL" class="form-control" id="inputAddress2" placeholder="Pilih Waktu">
    </div>
    <button type="submit" class="btn btn-primary mt-2">Submit</button>
</form>
  
@endsection