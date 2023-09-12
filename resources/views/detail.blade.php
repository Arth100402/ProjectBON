@if (Auth::user()->jabatan_id == 1)
    {{-- Staff --}}
    <div class="panel-heading card-background-color">
        <h3>Detail Bon</h3>
        <div class="table-wrapper table-responsive" style="height:30vh; overflow-y:scroll">
            <table class="table table-bordered" style="background-color: white">
                <thead>
                    <tr>
                        <th>Mulai Tanggal</th>
                        <th>Akhir Tanggal</th>
                        <th>Asal Kota</th>
                        <th>Tujuan</th>
                        <th>Sales</th>
                        <th>No PPC</th>
                        <th>Agenda</th>
                        <th>Keterangan</th>
                        <th>Kredit</th>
                        <th>Debit</th>
                        <th>Total Pengeluaran</th>
                        <th>Saldo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $d)
                        <tr>
                            <td>{{ $d->tglMulai }}</td>
                            <td>{{ $d->tglAkhir }}</td>
                            <td>{{ $d->asalKota }}</td>
                            <td>{{ $d->tujuan }}</td>
                            <td>{{ $d->user->id }}</td>
                            <td>{{ $d->project->idOpti }}</td>
                            <td>{{ $d->agenda }}</td>
                            <td>{{ $d->keterangan }}</td>
                            <td>{{ $d->kredit }}</td>
                            <td>{{ $d->debit }}</td>
                            <td>{{ $d->totalPengeluaran }}</td>
                            <td>{{ $d->saldo }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="panel card-background-color">
        <div class="panel-heading">
            <h3>Status Acc</h3>
        </div>
        <div class="panel-body">
            
        </div>
    </div>
@elseif(Auth::user()->jabatan_id != 1)
    <div class="panel card-background-color">
        <div class="panel-heading">
            <h3>Profil project</h3>
        </div>
        <div class="panel-body">
        </div>
    </div>
    <div class="panel card-background-color">
        <div class="panel-heading">
            <h3>Keuangan Project</h3>
        </div>
        <div class="panel-body">
            <b>Estimasi Nominal : </b>
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
                </tbody>
            </table>
        </div>
    </div>
    <div class="setAlign">
        <button type="button" class="btn btn-danger" id="btnClose" data-dismiss="modal">Tutup</button>
    </div>
@endif
