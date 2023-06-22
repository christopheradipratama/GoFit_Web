@extends('/dashboard')
@section('container')
    {{-- <div class="card mb-3" style="max-width: 540px;">
        <div class="row g-0">
            <div class="col-md-4">
                <img src="https://avataaars.io/?avatarStyle=Transparent&topType=WinterHat4&accessoriesType=Kurt&hatColor=PastelBlue&hairColor=Blonde&facialHairType=BeardMajestic&facialHairColor=Black&clotheType=Hoodie&clotheColor=PastelRed&eyeType=Surprised&eyebrowType=Angry&mouthType=Tongue&skinColor=Brown"
                    class="img-fluid rounded-start" alt="...">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional
                        content. This content is a little bit longer.</p>
                    <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                </div>
            </div>
        </div>
    </div> --}}

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
        <div class="container mx-auto mt-5">
            <div class="card">
                @if ($member->JENIS_KELAMIN_MEMBER === 'Perempuan')
                    <img src='https://avataaars.io/?avatarStyle=Circle&topType=LongHairBob&accessoriesType=Blank&hairColor=Black&facialHairType=Blank&clotheType=BlazerSweater&eyeType=Happy&eyebrowType=DefaultNatural&mouthType=Smile&skinColor=Light'
                        class="card-img-top" style="max-width: 150px" alt="Member Photo">
                    @else
                    <img src="https://avataaars.io/?avatarStyle=Transparent&topType=WinterHat4&accessoriesType=Kurt&hatColor=PastelBlue&hairColor=Blonde&facialHairType=BeardMajestic&facialHairColor=Black&clotheType=Hoodie&clotheColor=PastelRed&eyeType=Surprised&eyebrowType=Angry&mouthType=Tongue&skinColor=Brown"
                        class="card-img-top" style="max-width: 150px" alt="Member Photo">
                        @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $member->NAMA_MEMBER }}</h5>
                        <p class="card-text">ID : {{ $member->ID_MEMBER }}</p>
                        <p class="card-text">Tanggal Lahir : {{ $member->TANGGAL_LAHIR_MEMBER }}</p>
                        <p class="card-text">Jenis Kelamin : {{ $member->JENIS_KELAMIN_MEMBER }}</p>
                        <p class="card-text">Alamat : {{ $member->ALAMAT_MEMBER }}</p>
                        <p class="card-text">No Telepon : {{ $member->NOTELP_MEMBER }}</p>
                        <p class="card-text">Email : {{ $member->EMAIL_MEMBER }}</p>
                        <p class="card-text">
                            @if ($member->MASA_AKTIVASI === null)
                                Belum Diaktivasi
                            @else
                                Masa Aktivasi : {{ $member->MASA_AKTIVASI }}
                            @endif
                        </p>
                        <p class="card-text">
                            @if ($member->SISA_DEPOSIT_KELAS === null)
                                0
                            @else
                                Sisa Deposit Kelas : {{ $member->SISA_DEPOSIT_KELAS }}
                            @endif
                        </p>
                        <p class="card-text">
                            @if ($member->SISA_DEPOSIT_UANG === null)
                                0
                            @else
                                Sisa Deposit Uang : {{ $member->SISA_DEPOSIT_UANG }}
                            @endif
                        </p>
                    </div>
            </div>
            <button type="submit" class="btn btn-info mt-2" value="print" onclick="window.print()">Cetak Kartu</button>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.1/js/bootstrap.min.js"
            integrity="sha512-dm49+blLlGmTZPyZU6c85QeO/uzB/5E5h5r5O5N1/CkO5L5v4Zrra4gbX9+CJWGB4lGGFiwJJyzS1zxp2D8W/Q=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    </body>

    </html>
@endsection
