@extends('utama')

@section('title')
    Laporan Bon
@endsection

@section('isi')
    <style>
        .cotainer {
            display: flex;
            flex-wrap: nowrap;
        }
    </style>
    <h3>Filter Data: </h3>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group required">
                    <label for="tglMulai">Mulai Tanggal:</label><br>
                    <div class="input-group datepick">
                        <input type="text" class="form-control dateTimePicker" name="tglMulai" id="tglMulai"
                            placeholder="Masukkan Tanggal Mulai" required readonly>
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </div>
                    </div>
                </div>
                <div class="btn-group" role="group" aria-label="...">
                    <button type="button" class="btn btn-default btn-info" onclick="appendDate('day','#tglMulai')">+1
                        Hari</button>
                    <button type="button" class="btn btn-default btn-primary" onclick="appendDate('week','#tglMulai')">+1
                        Minggu</button>
                    <button type="button" class="btn btn-default btn-info" onclick="appendDate('month','#tglMulai')">+1
                        Bulan</button>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group required">
                    <label for="tglAkhir">Sampai Tanggal:</label><br>
                    <div class="input-group datepick">
                        <input type="text" class="form-control dateTimePicker" name="tglAkhir" id="tglAkhir"
                            placeholder="Masukkan Tanggal Akhir" required readonly>
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </div>
                    </div>
                </div>
                <div class="btn-group" role="group" aria-label="...">
                    <button type="button" class="btn btn-default btn-info" onclick="appendDate('day','#tglMulai')">+1
                        Hari</button>
                    <button type="button" class="btn btn-default btn-primary" onclick="appendDate('week','#tglMulai')">+1
                        Minggu</button>
                    <button type="button" class="btn btn-default btn-info" onclick="appendDate('month','#tglMulai')">+1
                        Bulan</button>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="pengaju">Pilih Nama Pengaju: </label>
                    <select class="form-control" name="pengaju" id="select-pengaju"></select>
                    @error('pengaju')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="opti">Pilih Opti: </label>
                    <select class="form-control" name="opti" id="select-opti"></select>
                    @error('opti')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="status">Pilih Status: </label>
                    <select class="form-control" name="status" id="select-status">
                        <option value="" disabled selected readonly>Pilih Status</option>
                        <option value="">Menunggu</option>
                        <option value="Diterima">Diterima</option>
                        <option value="Ditolak">Ditolak</option>
                    </select>
                    @error('status')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
    </div>
    <div class="portlet">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-reorder"></i>Laporan Bon
            </div>
            <div class="tools">
                <a href="javascript:;" class="collapse"></a>
            </div>
        </div>
        <div class="portlet-body" style="display: block">
            <div class="table-responsive" style="overflow: scroll">
                <table id="tableReport" class="table table-striped table-bordered" style="table-layout: fixed">
                    <thead>
                        <tr>
                            <th>Tanggal Pengajuan</th>
                            <th>Nama Pengaju</th>
                            <th>ID Opti</th>
                            <th>Nominal Yang Diajukan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script></script>
@endsection
