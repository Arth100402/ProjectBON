<div class="panel card-background-color">
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
        @php
            $images = explode(',', $data['image']);
        @endphp
        <!-- Indicators -->
        <ol class="carousel-indicators">
            @for ($i = 0; $i < count($images); $i++)
                @if ($i == 0)
                    <li data-target="#myCarousel" data-slide-to="{{ $i }}" class="active">
                    </li>
                @else
                    <li data-target="#myCarousel" data-slide-to="{{ $i }}"></li>
                @endif
            @endfor
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner" style="background-color: rgb(40, 40, 40)">
            @for ($i = 0; $i < count($images); $i++)
                @if ($i == 0)
                    <div class="item active"
                        style="height: 50vh; background-size:cover;background-position: center center;
                    background-repeat: no-repeat;">
                        <img src="{{ asset('images/' . $images[$i]) }}" alt="Los Angeles"
                            style="width:100%;height:100%; object-fit:contain;object-position:center">
                    </div>
                @else
                    <div class="item"
                        style="height: 50vh;background-size:cover;background-position: center center;
                    background-repeat: no-repeat;">
                        <img src="{{ asset('images/' . $images[$i]) }}" alt="Los Angeles"
                            style="width:100%;height:100%; object-fit:contain;object-position:center">
                    </div>
                @endif
            @endfor
        </div>

        <!-- Left and right controls -->
        <a class="left carousel-control" href="#myCarousel" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#myCarousel" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>




    
    <div class="panel-heading">
        <h3>Profil Kendaraan</h3>
    </div>
    <div class="panel-body">

        <b>Nomor Polisi : </b>
        <p>{{ $data->noPol }}</p>
        <b>Nomor Polisi Lama : </b>
        <p>{{ $data->noPolLama }}</p>
        <b>Jenis : </b>
        <p>{{ $data->jenis }}</p>
        <b>Merk : </b>
        <p>{{ $data->merk }}</p>
        <b>Tipe : </b>
        <p>{{ $data->tipe }}</p>
        <b>Warna : </b>
        <p>{{ $data->warna }}</p>
        <b>Tahun : </b>
        <p>{{ $data->tahun }}</p>
        <b>Lokasi : </b>
        <p>{{ $data->nama }}</p>
    </div>
</div>
<div class="panel card-background-color">

    <div class="panel-heading">
        <h3>Data Mesin</h3>
    </div>
    <div class="panel-body">
        <b>Nomor Mesin : </b>
        <p>{{ $data->noMesin }}</p>
        <b>Nomor Kerangka Mesin : </b>
        <p>{{ $data->noKerangka }}</p>
    </div>
</div>
<div class="panel card-background-color">

    <div class="panel-heading">
        <h3>Dokumen</h3>
    </div>
    <div class="panel-body">
        <b>Tanggal Bayar Pajak Tahunan : </b>
        <p>{{ $data->tanggalBayarPajakTahunan }}</p>
        <b>Masa Berlaku STNK : </b>
        <p>{{ $data->masaBerlakuSTNK }}</p>
        <b>Atas Nama STNK : </b>
        <p>{{ $data->atasNamaSTNK }}</p>
        <b>Posisi BPKB : </b>
        <p>{{ $data->posisiBPKB }}</p>
        <b>Tanggal KIR : </b>
        <p>{{ $data->tanggalKIR }}</p>
    </div>
</div>
<div class="panel card-background-color">
    <div class="panel-heading">
        <h3>GPS</h3>
    </div>
    <div class="panel-body">
        <b>Kode GPS : </b>
        <p>{{ $data->kodeGPS }}</p>
        <b>Nama GPS : </b>
        <p>{{ $data->namaGPS }}</p>
        <b>Kode Barcode : </b>
        <p>{{ $data->kodeBarcode }}</p>
        <b>Tanggal Bayar GPS : </b>
        <p>{{ $data->tglBayarGPS }}</p>
    </div>
</div>
<b>Created At : </b>
<p>{{ $data->created_at }}</p>
<b>Updated At : </b>
<p>{{ $data->updated_at }}</p>
<div class="setAlign">
    <button type="button" class="btn btn-danger" id="btnClose" data-dismiss="modal">Tutup</button>
</div>
