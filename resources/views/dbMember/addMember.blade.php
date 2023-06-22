@extends('/dashboard')
@section('container')

<form action="{{ url('/storeMember') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group mt-2">
      <label for="NAMA_MEMBER">Nama</label>
      <input type="text" class="form-control" name="NAMA_MEMBER" aria-describedby="emailHelp" placeholder="Enter Nama">
    </div>
    <div class="form-group mt-2">
      <label for="ALAMAT_MEMBER">Alamat</label>
      <input type="text" class="form-control" name="ALAMAT_MEMBER" placeholder="Enter Alamat">
    </div>
    <div class="form-group mt-2">
        <label for="EMAIL_MEMBER">Email</label>
        <input type="email" class="form-control" name="EMAIL_MEMBER" aria-describedby="emailHelp" placeholder="Enter email">
      </div>
      <div class="form-group mt-2">
        <label for="NOTELP_MEMBER">Nomor Telepon</label>
        <input type="text" class="form-control" name="NOTELP_MEMBER" aria-describedby="emailHelp" placeholder="08XXXXXXXXXX">
      </div>
      <div class="form-group mt-2">
        <label for="TANGGAL_LAHIR_MEMBER">Tanggal Lahir</label>
        <input type="date" class="form-control" name="TANGGAL_LAHIR_MEMBER" aria-describedby="emailHelp" placeholder="yyyy/mm/dd">
      </div>
      <div class="form-group mt-2">
        <label for="JENIS_KELAMIN_MEMBER" class="form-label">Jenis Kelamin</label>
        {{-- <input class="form-control" name="JENIS_KELAMIN_MEMBER" aria-describedby="emailHelp" placeholder="Laki-laki/Perempuan">
         --}}
         <select class="form-select" name="JENIS_KELAMIN_MEMBER" name="JENIS_KELAMIN_MEMBER">
            <option selected>. . .</option>
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