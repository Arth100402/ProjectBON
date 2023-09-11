<div class="panel card-background-color">
    <div class="panel-heading">
        <h3>Profil project</h3>
    </div>
    <div class="panel-body">
        <b>Nama Customer : </b>
        <p>{{ $data->nama }}</p>
        <b>Alamat Customer : </b>
        <p>{{ $data->alamat }}</p>
        <b>Instansi Customer : </b>
        <p>{{ $data->instansi }}</p>
        <b>Nomor Telepon Customer : </b>
        <p>{{ $data->notelp }}
            <button value="{{ $data->notelp }}" class="linkwa" style="background-color: transparent;border-color: #ccc;">
                <img src="{{ asset('assets/img/icon-wa.png') }}" alt="wa" height="45%" width="45%">
            </button>
        </p>
        <b>Email Customer : </b>
        <p>{{ $data->email }}</p>
    </div>
</div>
<div class="setAlign">
    <button type="button" class="btn btn-danger" id="btnClose" data-dismiss="modal">Tutup</button>
</div>
