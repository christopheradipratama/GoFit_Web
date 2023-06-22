{{-- @extends('dashboard') --}}
<html>
<head>
    <title>GOFIT</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css"
        rel="stylesheet"
    />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0- 
     alpha/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>    
    <link href="{{ asset('css/app.css')}}" rel="stylesheet" />
    <link href="{{ asset('css/style.css')}}" rel="stylesheet" />
</head>
<body>

<div class="container">
<main class="login-form">
        <form method="post" action="{{ url('/addTransaksiAktivasi') }}"  enctype="multipart/form-data">
        @csrf
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-md-5">
                    <div class="card h-75 text-white px-3" style="background-color: #212A3E">
                        <h5 class="text-center mb-0">Konfirmasi Pembayaran Transaksi Aktivasi</h5>
                        <div class="card-body mb-0 p-1">  
                            {{-- <hr style="border: 2px solid white; margin-bottom:0px"> --}}
                            <div class="mt-2">
                                <h6>ID Member : {{$member->ID_MEMBER}} / {{$member->NAMA_MEMBER}}</h6>
                                <h6>Nama Member : {{$member->NAMA_MEMBER}}</h6>
                                <h6>Alamat : {{$member->ALAMAT_MEMBER}}</h6>
                                
                                <label class="font-weight-bold mb-2">Tanggal Aktivasi</label>
                                <input type='text' class="form-control mb-3"name="TANGGAL_EXPIRED_TRANSAKSI_AKTIVASI"
                                    placeholder="Input date of birth member" autocomplete="off"
                                    value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" disabled />
                                <label class="font-weight-bold mb-2">Tanggal Kadaluarsa</label>
                                <input type='text' class="form-control mb-3"name="TANGGAL_EXPIRED_TRANSAKSI_AKTIVASI"
                                    placeholder="Input date of birth member" autocomplete="off"
                                    value="{{ Carbon\Carbon::now()->addYears(1)->format('Y-m-d') }}" disabled />
                                <label class="font-weight-bold mb-2">Biaya Aktivasi</label>
                                <input type='text' class="form-control mb-3"name="TANGGAL_EXPIRED_TRANSAKSI_AKTIVASI"
                                    placeholder="Input date of birth member" autocomplete="off" value="Rp.3.000.000" disabled />
                                <label class="mb-2 mt-0">Jumlah Uang </label>
                                <input type='text' class="form-control mb-3"name="JUMLAH_UANG" placeholder="Inputkan Jumlah Uang Aktivasi" autocomplete="off" />
                                <input type='text' class="form-control mb-3"name="ID_MEMBER"
                                placeholder="Input date of birth member" autocomplete="off" value="{{ $member->ID_MEMBER }}"
                                hidden />
                                <div class="text-center mt-3">
                                    <button type="submit" class="btn btn-success center-button display-inline">Submit</button>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </form>
</main>
</div>
<script>
    @if (Session::has('success'))
        toastr.options = {
            "closeButton": true,
            "progressBar": true
        }
        toastr.success("{{ session('success') }}");
    @endif

    @if (Session::has('error'))
        toastr.options = {
            "closeButton": true,
            "progressBar": true
        }
        toastr.error("{{ session('error') }}");
    @endif

    @if (Session::has('info'))
        toastr.options = {
            "closeButton": true,
            "progressBar": true
        }
        toastr.info("{{ session('info') }}");
    @endif

    @if (Session::has('warning'))
        toastr.options = {
            "closeButton": true,
            "progressBar": true
        }
        toastr.warning("{{ session('warning') }}");
    @endif
</script>
</body>
</html>