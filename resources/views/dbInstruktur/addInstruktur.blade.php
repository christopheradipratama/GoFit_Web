@extends('/dashboard')
@section('container')

<form action="{{ url('/storeInstruktur') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group mt-2">
      <label for="NAMA_INSTRUKTUR">Nama</label>
      <input type="text" class="form-control" name="NAMA_INSTRUKTUR" aria-describedby="emailHelp" placeholder="Enter Nama">
    </div>
    <div class="form-group mt-2">
      <label for="ALAMAT_INSTRUKTUR">Alamat</label>
      <input type="text" class="form-control" name="ALAMAT_INSTRUKTUR" placeholder="Enter Alamat">
    </div>
    <div class="form-group mt-2">
        <label for="EMAIL_INSTRUKTUR">Email</label>
        <input type="email" class="form-control" name="EMAIL_INSTRUKTUR" aria-describedby="emailHelp" placeholder="Enter email">
      </div>
      <div class="form-group mt-2">
        <label for="NOTELP_INSTRUKTUR">Nomor Telepon</label>
        <input type="text" class="form-control" name="NOTELP_INSTRUKTUR" aria-describedby="emailHelp" placeholder="08XXXXXXXXXX">
      </div>
      <div class="form-group mt-2">
        <label for="TANGGAL_LAHIR_INSTRUKTUR">Tanggal Lahir</label>
        <input type="text" class="form-control" name="TANGGAL_LAHIR_INSTRUKTUR" aria-describedby="emailHelp" placeholder="yyyy-mm-dd">
      </div>
      <div class="form-group mt-2">
        <label for="JENIS_KELAMIN_INSTRUKTUR" class="form-label">Jenis Kelamin</label>
        {{-- <input class="form-control" name="JENIS_KELAMIN_INSTRUKTUR" aria-describedby="emailHelp" placeholder="Laki-laki/Perempuan">
         --}}
         <select class="form-select" name="JENIS_KELAMIN_INSTRUKTUR" name="JENIS_KELAMIN_INSTRUKTUR">
            <option selected hidden>Pilih Jenis Kelamin</option>
            <option value="Laki-laki">Laki-laki</option>
            <option value="Perempuan">Perempuan</option>
         </select>
      </div>
      <div class="form-group mt-2">
        <label for="exampleInputEmail1">Password</label>
        <input class="form-control" type="password" name="password" aria-describedby="emailHelp" placeholder="Enter Password">
      </div>
    <button type="submit" class="btn btn-primary mt-2">Submit</button>
</form>
@endsection