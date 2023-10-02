<div class="panel card-background-color">
    <h3>History Bon</h3>
    <div class="panel card-background-color">
        <div class="panel-heading">
            <h3>Riwayat Dokumen</h3>
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
                    {{-- @foreach ($acc as $a)
                        <tr>
                            <td>{{ $a->acc_name }}</td>
                            @if ($a->status == 'Tolak')
                                <td>{{ $a->status }}, Karena {{ $a->keteranganTolak }}</td>
                            @else
                                <td>{{ $a->status }}</td>
                            @endif
                        </tr>
                    @endforeach --}}
                </tbody>
            </table>
        </div>
    </div>
    <div class="setAlign">
        <button type="button" class="btn btn-danger" id="btnClose" data-dismiss="modal">Tutup</button>
    </div>
</div>
