@extends('utama')

@section('title')
    Laporan Bon
@endsection

@section('css')
    <style>
        .cotainer {
            display: flex;
            flex-wrap: nowrap;
        }

        .dateTimePicker:hover,
        .glyphicon-calendar {
            cursor: pointer;
        }
    </style>
@endsection

@section('isi')
    <h3>Filter Data: </h3>
    <div class="container" style="max-width: 100%;">
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
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="pengaju">Nama Pengaju: </label>
                    <select class="form-control" name="pengaju" id="select-pengaju"></select>
                    @error('pengaju')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="opti">Opti: </label>
                    <select class="form-control" name="opti" id="select-opti"></select>
                    @error('opti')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="status">Status: </label>
                    <select class="form-control" name="status" id="select-status">
                        <option value=""></option>
                        <option value="Menunggu">Menunggu</option>
                        <option value="Terima">Diterima</option>
                        <option value="Tolak">Ditolak</option>
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
                    <tbody id="tableReportBody">
                        @foreach ($all as $row)
                            <tr>
                                <td>{{ $row['tglPengajuan'] }}</td>
                                <td>{{ $row['name'] }}</td>
                                <td>{{ $row['idOpti'] }}</td>
                                <td>{{ $row['total'] }}</td>
                                <td>{{ $row['status'] ? $row['status'] : 'Menunggu' }}</td>
                                <td><a href="#" class="btn btn-info btn-block">info</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <br>
            <div class="portlet-footer">
                <p>Total :</p>
                <p id="total">{{ $total }}</p>
            </div>

        </div>
    </div>
@endsection
@section('javascript')
    <script>
        $(document).ready(function() {
            // Variables & Initialization
            const today = new Date();
            const e = {!! $earliest !!}.tglPengajuan
            const l = {!! $latest !!}.tglPengajuan
            initDTP("#tglMulai", e)
            initDTP("#tglAkhir", l)
            $("#select-status").select2({
                placeholder: "Pilih status",
                allowClear: true,
                minimumResultsForSearch: -1
            })
            $("#select-pengaju").select2({
                placeholder: 'Tidak ada pengaju',
                allowClear: true,
                ajax: {
                    url: '{{ route('loadSales') }}',
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        return {
                            results: $.map(data.data, function(item) {
                                return {
                                    text: item.name,
                                    id: item.id,
                                }
                            })
                        };
                    },
                    cache: true
                }
            })
            $("#select-opti").select2({
                placeholder: 'Tidak ada ID Opti',
                allowClear: true,
                ajax: {
                    url: '{{ route('loadAllPPC') }}',
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        return {
                            results: $.map(data.data, function(item) {
                                return {
                                    text: item.namaOpti,
                                    id: item.id
                                }
                            })
                        };
                    },
                    cache: true
                }
            })

            // Events
            $(".datepick").on("click", function() {
                $(this).find(".dateTimePicker").focus()
            });
            $(".dateTimePicker").on("dp.change", function() {
                let mulai = $('#tglMulai').data("DateTimePicker").date()
                let deadline = $('#tglAkhir').data("DateTimePicker").date()
                if ($(this).attr("id") == "tglMulai") {
                    if (deadline.isBefore(mulai)) {
                        $('#tglAkhir').data("DateTimePicker").date(mulai)
                    } else return
                } else {
                    if (deadline.isBefore(mulai)) {
                        $('#tglMulai').data("DateTimePicker").date(deadline)
                    } else return
                }
            });
            $("#tglMulai, #tglAkhir").on("dp.change", function() {
                filterChangeListener()
            });

            $("#select-pengaju, #select-opti, #select-status").on("change", function() {
                filterChangeListener()
            });

        });


        // Functions
        const initDTP = (id, date) => {
            $(id).datetimepicker({
                format: 'dddd, DD-MM-yyyy',
                ignoreReadonly: true,
                locale: 'id'
            }).data("DateTimePicker").date(moment(date))
        }
        const filterChangeListener = () => {
            const m = $("#tglMulai").val();
            const a = $("#tglAkhir").val();
            const p = $("#select-pengaju").val();
            const o = $("#select-opti").val();
            const s = $("#select-status").val() ? $("#select-status").val() : "placeholder";
            const tb = $("#tableReportBody");
            $.ajax({
                type: "POST",
                url: "{{ route('fb') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "m": m,
                    "a": a,
                    "p": p,
                    "o": o,
                    "s": s,
                },
                success: function(response) {
                    console.log(response);
                    const d = response.data
                    const t = response.total
                    let c = ``
                    for (const r of d) {
                        c += `
                        <tr>
                            <td>${r.tglPengajuan}</td>
                            <td>${r.name}</td>
                            <td>${r.idOpti}</td>
                            <td>${r.total}</td>
                            <td>${r.status?r.status:"Menunggu"}</td>
                            <td><a href="#" class="btn btn-info btn-block">info</a></td>
                        </tr>
                    `
                    }
                    $(tb).html(c);
                    $("#total").html(t)
                },
                error: function(err) {
                    console.log(err);
                }
            });
        }
    </script>
@endsection
