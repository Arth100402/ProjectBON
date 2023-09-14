<div class="panel card-background-color">
    <h3>Detail Bon</h3>
    <div class="table-wrapper table-responsive" style="height:30vh; overflow-y:scroll">
        <table id="detailTableAcc" class="table table-bordered" style="background-color: white">
            <thead>
                <tr>
                    <th>Mulai Tanggal</th>
                    <th>Akhir Tanggal</th>
                    <th>Asal Kota</th>
                    <th>Tujuan</th>
                    <th>Project</th>
                    <th>Pengaju</th>
                    <th>No Paket</th>
                    <th>Agenda</th>
                    <th>Penggunaan</th>
                    <th>Biaya</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($detail as $d)
                    <tr>
                        <td>{{ $d->tglMulai }}</td>
                        <td>{{ $d->tglAkhir }}</td>
                        <td>{{ $d->asalKota }}</td>
                        <td>{{ $d->tujuan }}</td>
                        <td>{{ $d->idOpti }}</td>
                        <td>{{ $d->name }}</td>
                        <td>{{ $d->noPaket }}</td>
                        <td>{{ $d->agenda }}</td>
                        <td>{{ sprintf('Rp %s', number_format($d->penggunaan, 0, ',', '.')) }}</td>
                        <td>{{ sprintf('Rp %s', number_format($d->biaya, 0, ',', '.')) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="setAlign">
        <button type="button" class="btn btn-danger" id="btnClose" data-dismiss="modal">Tutup</button>
    </div>