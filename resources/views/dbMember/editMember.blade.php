@extends('/dashboard')
@section('container')

<form action="{{ url('/updateMember/'.$member->ID_MEMBER) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-group mt-2">
      <label for="NAMA_MEMBER">Nama</label>
      <input type="text" class="form-control" name="NAMA_MEMBER" aria-describedby="emailHelp" placeholder="Enter Nama"
      value="{{ $member->NAMA_MEMBER }}">
    </div>
    <div class="form-group mt-2">
      <label for="ALAMAT_MEMBER">Alamat</label>
      <input type="text" class="form-control" name="ALAMAT_MEMBER" placeholder="Enter Alamat"
      value="{{ $member->ALAMAT_MEMBER }}">
    </div>
    <div class="form-group mt-2">
        <label for="EMAIL_MEMBER">Email</label>
        <input type="email" class="form-control" name="EMAIL_MEMBER" aria-describedby="emailHelp" placeholder="Enter email"
        value="{{ $member->EMAIL_MEMBER }}">
      </div>
      <div class="form-group mt-2">
        <label for="NOTELP_MEMBER">Nomor Telepon</label>
        <input type="text" class="form-control" name="NOTELP_MEMBER" aria-describedby="emailHelp" placeholder="08XXXXXXXXXX"
        value="{{ $member->NOTELP_MEMBER }}">
      </div>
      <div class="form-group mt-2">
        <label for="TANGGAL_LAHIR_MEMBER">Tanggal Lahir</label>
        <input type="text" class="form-control" name="TANGGAL_LAHIR_MEMBER" aria-describedby="emailHelp" placeholder="yyyy/mm/dd"
        value="{{ $member->TANGGAL_LAHIR_MEMBER}}">
      </div>
      <div class="form-group mt-2">
        <label for="JENIS_KELAMIN_MEMBER" class="form-label">Jenis Kelamin</label>
         <select class="form-select" name="JENIS_KELAMIN_MEMBER" name="JENIS_KELAMIN_MEMBER">
            <option selected value="{{ $member->JENIS_KELAMIN_MEMBER }}">{{ $member->JENIS_KELAMIN_MEMBER }}</option>
            <option value="Laki-laki">Laki-laki</option>
            <option value="Perempuan">Perempuan</option>
         </select>
      </div>
      <div class="form-group mt-2">
        <label for="exampleInputEmail1">Password</label>
        <input class="form-control" type="text" name="password" aria-describedby="emailHelp" placeholder="Enter Password"
        value="{{ $member->password }}">
      </div>
    <button type="submit" class="btn btn-primary mt-2">Submit</button>
</form>
@endsection