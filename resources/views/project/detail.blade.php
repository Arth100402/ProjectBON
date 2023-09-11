<div class="panel card-background-color">
    <div class="panel-heading">
        <h3>Profil project</h3>
    </div>
    <div class="panel-body">
        <b>ID Opti : </b>
        <p>{{ $data->idOpti }}</p>
        <b>Nama Opti : </b>
        <p class="wrap">{{ $data->namaOpti }}</p>
        <b>Nama Customer : </b>
        <p>{{ $data->cnama }}</p>
        <b>Nama Instansi Customer : </b>
        <p>{{ $data->cinstansi }}</p>
        <b>Nomor Telepon Customer : </b>
        <p>{{ $data->cnotelp }}
            <button value="{{ $data->cnotelp }}" class="linkwa" style="background-color: transparent;border-color: #ccc;">
                <img src="{{ asset('assets/img/icon-wa.png') }}" alt="wa" height="45%" width="45%">
            </button>
        </p>
        <b>Email Customer : </b>
        <p>{{ $data->cemail }}</p>
        <b>Alamat Customer : </b>
        <p>{{ $data->calamat }}</p>
        <b>Lokasi Project: </b>
        <p>{{ $data->posisi }}</p>
        <b>Dibuat pada : </b>
        <p>{{ $data->tglBuat }}</p>
        <b>Direalisasikan pada : </b>
        <p>{{ $data->tglRealisasi }}</p>
        <b>Deadline : </b>
        <p>{{ $data->deadline }}</p>
        <b>Status Project : </b>
        <p>{{ $data->status }}</p>
    </div>
</div>
<div class="panel card-background-color">
    <div class="panel-heading">
        <h3>Keuangan Project</h3>
    </div>
    <div class="panel-body">
        <b>Estimasi Nominal : </b>
        <p>{{ sprintf('Rp %s', number_format($data->estNominal, 0, ',', '.')) }}</p>
        <b>Profit Single : </b>
        <p>{{ sprintf('Rp %s', number_format($data->profitSingle, 0, ',', '.')) }}</p>
        <b>Profit Double : </b>
        <p>{{ sprintf('Rp %s', number_format($data->profitDouble, 0, ',', '.')) }}</p>
    </div>
</div>
<div class="panel-heading card-background-color">
    <h3>Anggota Project</h3>
    <div class="table-wrapper table-responsive" style="height:30vh; overflow-y:scroll">
        <table class="table table-bordered" style="background-color: white">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Aktifitas</th>
                    <th>Nama</th>
                    <th>Status Pekerja</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($anggota as $index => $value)
                    @if ($index === 0 || $value->tglAktifitas === $anggota[$index - 1]->tglAktifitas)
                        <tr>
                            <td>{{ $value->tglAktifitas }}</td>
                            <td>{{ $value->namaAktifitas }}</td>
                            <td>{{ $value->uname }}</td>
                            <td>{{ $value->rname }}</td>
                        </tr>
                    @else
                        <tr>
                            <td class="card-background-color" colspan="4"></td>
                        </tr>
                        <tr>
                            <td>{{ $value->tglAktifitas }}</td>
                            <td>{{ $value->namaAktifitas }}</td>
                            <td>{{ $value->uname }}</td>
                            <td>{{ $value->rname }}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="setAlign">
    <button type="button" class="btn btn-danger" id="btnClose" data-dismiss="modal">Tutup</button>
</div>
