@extends('/dashboard')
@section('container')
    <style>
        #content {
            background-color: white;
        }

        @media print {
            body * {
                visibility: hidden;
            }

            #content,
            #content * {
                visibility: visible;
            }
        }
    </style>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Member Card</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.1/css/bootstrap.min.css"
            integrity="sha512-8W7CscL+Kj/Y9cE+0pwMcJlFrxUiUzH/FdSN37GVwi6JWU6f99U+Rqb+kfS1jQZGhTbcTb4sL+4Kq3hC+nTXMg=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>

    <body>
        <div class="card overflow-hidden mt-4" style="width: 50rem;" id="content">
            <div class="ml-2 p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <b>Go-Fit</b>
                        <p>Jl. Centralpark No. 10 Yogyakarta</p>
                    </div>
                    <div>
                        <p>No Struk : {{ $transaksiDepositKelas->ID_TRANSAKSI_DEPOSIT_KELAS }}</p>
                        <p>Tanggal Aktivasi : {{ $transaksiDepositKelas->TANGGAL_DEPOSIT_KELAS }}</p>
                    </div>
                </div>
                <p> <b> Member </b> : {{ $transaksiDepositKelas->member->ID_MEMBER }} /
                    {{ $transaksiDepositKelas->member->NAMA_MEMBER }} </p>
                <p> Kelas : {{ $transaksiDepositKelas->ID_KELAS }}</p>
                <p> Jumlah Deposit kelas : {{ $transaksiDepositKelas->JUMLAH_DEPOSIT_KELAS }} </p>
                <p class="text-right">Kasir : {{ $transaksiDepositKelas->pegawai->NAMA_PEGAWAI }}</p>
            </div>

        </div>
        <div class="mt-2">
            <a class="btn btn-primary" onclick="window.print()">
                <span data-feather="edit">
                    <i class="fas fa-print"></i>
                </span>
            </a>
            <a href="{{ url('/transaksiDepositKelas') }}" class="btn btn-danger"><span data-feather="edit"><i
                        class="fas fa-undo"></i></span></a>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.1/js/bootstrap.min.js"
            integrity="sha512-dm49+blLlGmTZPyZU6c85QeO/uzB/5E5h5r5O5N1/CkO5L5v4Zrra4gbX9+CJWGB4lGGFiwJJyzS1zxp2D8W/Q=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <script>
            const printBtn = document.getElementById('print');

            printBtn.addEventListener('click', function() {
                print();
            })
        </script>
    </body>

    </html>
@endsection
