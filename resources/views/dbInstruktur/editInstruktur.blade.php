@extends('/dashboard')
@section('container')

<form action="{{ url('/updateInstruktur/'.$instruktur->ID_INSTRUKTUR) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-group mt-2">
      <label for="NAMA_INSTRUKTUR">Nama</label>
      <input type="text" class="form-control" name="NAMA_INSTRUKTUR" aria-describedby="emailHelp" placeholder="Enter Nama"
      value="{{ $instruktur->NAMA_INSTRUKTUR }}">
    </div>
    <div class="form-group mt-2">
      <label for="ALAMAT_INSTRUKTUR">Alamat</label>
      <input type="text" class="form-control" name="ALAMAT_INSTRUKTUR" placeholder="Enter Alamat"
      value="{{ $instruktur->ALAMAT_INSTRUKTUR }}">
    </div>
    <div class="form-group mt-2">
        <label for="EMAIL_INSTRUKTUR">Email</label>
        <input type="email" class="form-control" name="EMAIL_INSTRUKTUR" aria-describedby="emailHelp" placeholder="Enter email"
        value="{{ $instruktur->EMAIL_INSTRUKTUR }}">
      </div>
      <div class="form-group mt-2">
        <label for="NOTELP_INSTRUKTUR">Nomor Telepon</label>
        <input type="text" class="form-control" name="NOTELP_INSTRUKTUR" aria-describedby="emailHelp" placeholder="08XXXXXXXXXX"
        value="{{ $instruktur->NOTELP_INSTRUKTUR }}">
      </div>
      <div class="form-group mt-2">
        <label for="TANGGAL_LAHIR_INSTRUKTUR">Tanggal Lahir</label>
        <input type="text" class="form-control" name="TANGGAL_LAHIR_INSTRUKTUR" aria-describedby="emailHelp" placeholder="yyyy/mm/dd"
        value="{{ $instruktur->TANGGAL_LAHIR_INSTRUKTUR}}">
      </div>
      <div class="form-group mt-2">
        <label for="JENIS_KELAMIN_INSTRUKTUR" class="form-label">Jenis Kelamin</label>
         <select class="form-select" name="JENIS_KELAMIN_INSTRUKTUR" name="JENIS_KELAMIN_INSTRUKTUR">
            <option selected hidden value="{{ $instruktur->JENIS_KELAMIN_INSTRUKTUR }}">{{ $instruktur->JENIS_KELAMIN_INSTRUKTUR }}</option>
            <option value="Laki-laki">Laki-laki</option>
            <option value="Perempuan">Perempuan</option>
         </select>
      </div>
      <div class="form-group mt-2">
        <label for="exampleInputEmail1">Password</label>
        <input class="form-control" type="text" name="password" aria-describedby="emailHelp" placeholder="Enter Password"
        value="{{ $instruktur->password }}">
      </div>
    <button type="submit" class="btn btn-primary mt-2">Submit</button>
</form>
@endsection