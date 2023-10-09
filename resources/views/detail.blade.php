<div class="panel card-background-color">
    <div class="panel-heading">
        <h3>Detail Bon</h3>
    </div>
    <div class="panel-body">
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
                            <td>{{ $d->penggunaan }}</td>
                            <td>{{ sprintf('Rp %s', number_format($d->biaya, 0, ',', '.')) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="panel-heading">
        <h3>Riwayat Revisi: </h3>
    </div>
    <div class="panel-body">
        <div class="table-wrapper table-responsive" style="height:30vh; overflow-y:scroll">
            <table id="detailTableAcc" class="table table-bordered" style="background-color: white">
                <thead>
                    <tr>
                        <th>Atasan</th>
                        <th>Komentar</th>
                        <th>Tanggal Komentar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($revises as $d)
                        <tr>
                            <td>{{ $d->atasan }}</td>
                            <td>{{ $d->history }}</td>
                            <td>{{ $d->tglRevisi }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @if ($acc != null)
        <div class="panel card-background-color">
            <div class="panel-heading">
                <h3>Status Acc</h3>
            </div>
            <div class="panel-body">
                <table id="statusAcc" class="table table-bordered" style="background-color: white">
                    <thead>
                        <tr>
                            <th>Penyetuju</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($acc as $a)
                            @if ($a->acc_jabatan != 8 && !($a->acc_jabatan == 3 && $a->acc_depart == 8))
                                <tr>
                                    <td>{{ $a->acc_name }}</td>
                                    @if ($a->status == 'Tolak')
                                        <td>{{ $a->status }}, Karena {{ $a->keteranganTolak }}</td>
                                    @elseif ($a->status == 'Terima' && $a->keteranganAcc != null)
                                        <td>{{ $a->status }} dan {{ $a->keteranganAcc }}</td>
                                    @else 
                                        <td>{{ $a->status }}</td>
                                    @endif
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table><br>
                <h4>Finance Manager: </h4>
                @foreach ($acc as $a)
                    @if ($a->acc_jabatan == 3 && $a->acc_depart == 8)
                        <table class="table table-bordered" style="background-color: white">
                            <thead>
                                <tr>
                                    <th>Penyetuju</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $a->acc_name }}</td>
                                    @if ($a->status == 'Tolak')
                                        <td>{{ $a->status }}, Karena {{ $a->keteranganTolak }}</td>
                                    @else
                                        <td>{{ $a->status }}</td>
                                    @endif
                                </tr>
                            </tbody>
                        </table>
                    @endif
                @endforeach
                <h4>Kasir: </h4>
                @foreach ($acc as $a)
                    @if ($a->acc_jabatan == 8)
                        <table class="table table-bordered" style="background-color: white">
                            <thead>
                                <tr>
                                    <th>Penyetuju</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $a->acc_name }}</td>
                                    @if ($a->status == 'Tolak')
                                        <td>{{ $a->status }}, Karena {{ $a->keteranganTolak }}</td>
                                    @else
                                        <td>{{ $a->status }}</td>
                                    @endif
                                </tr>
                            </tbody>
                        </table>
                    @endif
                @endforeach
            </div>
        </div>
    @endif
    @if ($pdf != null)
        <div class="panel-heading">
            <h3>Dokumen Pendukung:</h3>
        </div>
        <div class="panel-body">
            <embed src="{{ asset('files/' . $pdf['filename']) }}" type="application/pdf" width="100%"
                height="600px" />
        </div>
    @endif
</div>
<div class="setAlign">
    <button type="button" class="btn btn-danger" id="btnClose" data-dismiss="modal">Tutup</button>
</div>
