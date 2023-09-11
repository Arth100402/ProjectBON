@if (Auth::user()->jabatan_id == 1)
    {{-- Staff --}}
    <p>s</p>
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
