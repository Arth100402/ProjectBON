@extends('utama')
@section('title')
    Form Ubah Pengajuan Perjalanan Dinas
@endsection

@section('isi')
    <style>
        .nopading {
            padding: 0px !important;
        }

        .padding {
            padding: 10px !important;
        }

        .bootstrap-datetimepicker-widget.dropdown-menu {
            z-index: 99999 !important;
            top: auto !important;
            bottom: auto !important;
        }

        #table-revise-container td {
            white-space: nowrap;
        }

        .lineStrike {
            text-decoration: line-through;
            background-color: #F8D7DA;
        }

        .maroon {
            background-color: maroon;
        }

        .salmon {
            background-color: #fafafa;
        }
    </style>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @csrf
    <div class="form-group required" style="min-width:25%; max-width:30%">
        <label for="tglMulai">Mulai Tanggal:</label><br>
        <div class="input-group datepick">
            <input type="text" class="form-control dateTimePicker" name="tglMulai" id="tglMulai"
                placeholder="Masukkan Tanggal Mulai" required readonly disabled value="{{ $bon->tglPengajuan }}">
            <div class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
            </div>
        </div>
    </div>
    <div class="form-group required" style="min-width:25%; max-width:30%">
        <label for="tglAkhir">Akhir Tanggal:</label><br>
        <div class="input-group datepick">
            <input type="text" class="form-control dateTimePicker" name="tglAkhir" id="tglAkhir"
                placeholder="Masukkan Tanggal Akhir" required readonly>
            <div class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
            </div>
        </div>
        <div class="btn-group" role="group" aria-label="...">
            <button type="button" class="btn btn-default btn-info" onclick="appendDate('day','#tglAkhir')">+1
                Hari</button>
            <button type="button" class="btn btn-default btn-primary" onclick="appendDate('week','#tglAkhir')">+1
                Minggu</button>
            <button type="button" class="btn btn-default btn-info" onclick="appendDate('month','#tglAkhir')">+1
                Bulan</button>
        </div>
    </div>
    <div class="form-group">
        <label for="asalKota">Asal Kota:</label><br>
        <input type="text" name="asalKota" id="asalKota" class="form-control" placeholder="Masukkan Asal Kota"
            required></select>
        @error('asalKota')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group">
        <label for="tujuan">Tujuan:</label><br>
        <input type="text" name="tujuan" id="tujuan" class="form-control" placeholder="Masukkan Kota Tujuan"
            required></select>
        @error('tujuan')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    {{-- Admin --}}
    @if (Auth::user()->jabatan_id == 9)
        <div class="form-group">
            <label for="sales">Pilih Sales: </label>
            <select class="form-control" name="sales" id="select-sales" disabled>
                <option value="{{ $bon->users_id }}">{{ $bon->name }}</option>
            </select>
            @error('sales')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    @else
        <div class="form-group">
            <label for="sales">Pilih Sales: </label>
            <select class="form-control" name="sales" id="select-sales" disabled>
                <option value="{{ Auth::user()->id }}">{{ Auth::user()->name }}</option>
            </select>
            @error('sales')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    @endif
    <div class="form-group">
        <label for="ppc">Pilih PPC: </label>
        <select class="form-control" name="ppc" id="select-ppc"></select>
        @error('ppc')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group">
        <label for="asalKota">No Paket/SO/SQ:</label><br>
        <input type="text" name="nopaket" id="nopaket" class="form-control" placeholder="Masukkan No Paket"
            disabled></select>
        @error('nopaket')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group">
        <label for="agenda">Agenda: </label><br>
        <textarea name="agenda" id="agenda" class="form-control" rows="10" placeholder="Masukkan Agenda Anda" required></textarea>
        @error('agenda')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group">
        <label for="keterangan">Penggunaan: </label><br>
        <input type="text" name="keterangan" id="keterangan" class="form-control"
            placeholder="Masukkan Keterangan Kegiatan" required>
        @error('keterangan')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group">
        <label for="biaya">Biaya: </label>
        <input type="number" min="0" step="1000" value="0" name="biaya" class="form-control"
            id="biaya" placeholder="Masukkan Nominal Biaya">
        @error('biaya')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <br>
    <button id="addDetail" class="btn btn-info btn-block">Tambahkan</button><br>
    <form method="POST" action="{{ route('bon.update', $bon->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="table-responsive" style="overflow: scroll">
            <table id="myTable" class="table table-hover">
                <thead>
                    <tr>
                        <th>Mulai Tanggal</th>
                        <th>Akhir Tanggal</th>
                        <th>Asal Kota</th>
                        <th>Tujuan</th>
                        <th>Sales</th>
                        <th>No PPC</th>
                        <th>No Paket/SO/SQ</th>
                        <th>Agenda</th>
                        <th>Penggunaan</th>
                        <th>Biaya</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="table-container">

                </tbody>
            </table>
        </div>
        <div class="form-group">
            <label for="saldo">Total Biaya Perjalanan: </label>
            <input type="text" min="0" value="Rp 0" name="biayaPerjalananDisplay" class="form-control"
                id="biayaPerjalananDisplay" readonly>
            <input type="number" min="0" value="{{ $bon->total }}" name="biayaPerjalanan"
                class="form-control" id="biayaPerjalanan" readonly style="display: none;">
            @error('debit')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="sadaw">Surat (Jika Ada):</label>
            <input type="file" name="filenames[]" id="files" class="form-control" multiple>
            <small>Types: .doc, .docx, .pdf, .xlx, .csv</small>
        </div>
        <button type="submit" id="submit" disabled class="btn btn-primary">Kirim</button>
        <a class="btn btn-danger" href="/">Batal Kirim</a>
    </form>
@endsection
@section('javascript')
    <script>
        const bid = {!! $bon->id !!}
        const biayaPerjalanan = 0;
        const level1 = {!! $level1 ? 'true' : 'false' !!}
        const adminsss = {!! Auth::user()->jabatan_id == 9 ? 'true' : 'false' !!}
        const appendDate = (option, id) => {
            var date = $(id).data("DateTimePicker").date()
            switch (option) {
                case "day":
                    date.add(1, "days")
                    break;
                case "week":
                    date.add(1, "weeks")
                    break;
                case "month":
                    date.add(1, "months")
                    break;
                default:
                    console.log("Error! Error! Abort Ship!");
                    break;
            }
            $(id).data("DateTimePicker").date(date)
        }
        const initDTP = (id, date) => {
            $(id).datetimepicker({
                format: 'dddd, DD-MM-yyyy',
                ignoreReadonly: true,
                locale: 'id'
            }).data("DateTimePicker").date(moment(date))
        }
        $(document).ready(function() {
            let biayaPerjalananDisplay = parseInt($("#biayaPerjalanan").val());
            let formattedBiayaPerjalanan = biayaPerjalananDisplay.toLocaleString('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            });
            $("#biayaPerjalananDisplay").val(formattedBiayaPerjalanan);

            var today = new Date();
            initDTP("#tglMulai", today)
            initDTP("#tglAkhir", today)

            $("#select-ppc").select2({
                placeholder: 'Tidak ada ID Opti',
                allowClear: true,
                ajax: {
                    url: '{{ route('loadPPC') }}',
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        return {
                            results: $.map(data.data, function(item) {
                                return {
                                    text: item.namaOpti,
                                    id: item.id,
                                    noPaket: item.noPaket
                                }
                            })
                        };
                    },
                    cache: true
                }
            }).on("change", function(e) {
                var selectedData = $(this).select2('data');
                $('#nopaket').val(selectedData[0].noPaket);
            }).on('select2:unselect', function(e) {
                $('#nopaket').val('');
            });

            $("#addDetail").on("click", function(e) {
                // Validation
                const asal = $("#asalKota").val();
                const tujuan = $("#tujuan").val();
                const agenda = $("#agenda").val()
                const keter = $("#keterangan").val()
                const tglMulai = $("#tglMulai").val()
                const tglAkhir = $("#tglAkhir").val();
                const nopaket = $("#nopaket").val()
                const sales = $("#select-sales").val()
                const proj = $("#select-ppc").val()

                const regex = /^(?!.*\s\s)[a-zA-Z0-9\s\W]{3,}$/;
                var biaya = parseInt($("#biaya").val());
                let formatter = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0
                });
                let formatted_biaya = formatter.format(biaya);
                if (!regex.test(asal)) {
                    alert("Pastikan asal kota tidak kosong dan format pengisian benar");
                    $("#asalKotaError").remove();
                    $("#tujuanError").remove();
                    $("#agendaError").remove();
                    $("#keteranganError").remove();
                    $("#asalKota").after(
                        '<span id="asalKotaError" style="color: red;">Pastikan asal kota tidak kosong dan format pengisian benar</span>'
                    );
                    $("#asalKota").focus();
                    return;
                } else if (!regex.test(tujuan)) {
                    alert(
                        "Pastikan kota tujuan tidak kosong dan format pengisian benar");
                    $("#asalKotaError").remove();
                    $("#tujuanError").remove();
                    $("#agendaError").remove();
                    $("#keteranganError").remove();
                    $("#tujuan").after(
                        '<span id="tujuanError" style="color: red;">Pastikan kota tujuan tidak kosong dan format pengisian benar</span>'
                    );
                    $("#tujuan").focus();
                    return;
                } else if (!regex.test(agenda)) {
                    alert("Pastikan agenda tidak kosong dan format pengisian benar");
                    $("#asalKotaError").remove();
                    $("#tujuanError").remove();
                    $("#agendaError").remove();
                    $("#keteranganError").remove();
                    $("#agenda").after(
                        '<span id="agendaError" style="color: red;">Pastikan agenda kegiatan tidak kosong dan format pengisian benar</span>'
                    );
                    $("#agenda").focus();
                    return;
                } else if (!regex.test(keter)) {
                    alert("Pastikan penggunaan tidak kosong dan format pengisian benar");
                    $("#asalKotaError").remove();
                    $("#tujuanError").remove();
                    $("#agendaError").remove();
                    $("#keteranganError").remove();
                    $("#keterangan").after(
                        '<span id="keteranganError" style="color: red;">Pastikan penggunaan tidak kosong dan format pengisian benar</span>'
                    );
                    $("#keterangan").focus();
                    return;
                }
                // Add to Table
                $.ajax({
                    type: "POST",
                    url: "{{ route('bon.addNewDetail') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "tglMulai": tglMulai,
                        "tglAkhir": tglAkhir,
                        "asalKota": asal,
                        "tujuan": tujuan,
                        "select-sales": sales,
                        "select-ppc": proj,
                        "nopaket": nopaket,
                        "agenda": agenda,
                        "keterangan": keter,
                        "biaya": biaya,
                        "bid": bid
                    },
                    success: function(response) {
                        const id = response.id
                        const rows = `
                        <tr data-toggle="collapse" href="#collapse${id}" data-id="${id}">
                            <td>${tglMulai}<input type="hidden" name="tglMulai[]" value="${tglMulai}"></td>
                            <td>${tglAkhir}<input type="hidden" name="tglAkhir[]" value="${tglAkhir}"></td>
                            <td>${asal}<input type="hidden" name="asalKota[]" value="${asal}"></td>
                            <td>${tujuan}<input type="hidden" name="tujuan[]" value="${tujuan}"></td>
                            <td>${$("#select-sales option:selected").text()}<input type="hidden" name="select-sales[]" value="${sales}"></td>
                            <td>${$("#select-ppc option:selected").text()}<input type="hidden" name="select-ppc[]" value="${proj}"></td>
                            <td>${nopaket}<input type="hidden" name="nopaket[]" value="${nopaket}"></td>
                            <td>${agenda}<input type="hidden" name="agenda[]" value="${agenda}"></td>
                            <td>${keter}<input type="hidden" name="keterangan[]" value="${keter}"></td>
                            <td>${formatted_biaya}<input type="hidden" name="biaya[]" id="biaya" value="${biaya}"></td>
                            <td><div style="display:flex;"><a class="btn btn-warning revision"><i class="fa fa-pencil"></i></a>&nbsp;<a class="btn btn-danger remove-detail"><i class="fa fa-times-circle"></i></a>
                            </td>
                        </tr>
                        <td colspan="12" class="nopading" >
                            <div id="collapse${id}" class="panel-collapse collapse padding table-responsive">
                                <table id="tableRevise" class="table table-hover">
                                    <tbody id="table-revise-container"></tbody>
                                </table>
                            </div>
                        </td>`
                        $("#table-container").append(rows);
                        let biayaPerjalananDisplay = parseInt($("#biayaPerjalanan").val()) +
                            biaya;
                        let formattedBiayaPerjalanan = biayaPerjalananDisplay.toLocaleString(
                            'id-ID', {
                                style: 'currency',
                                currency: 'IDR',
                                minimumFractionDigits: 0
                            });
                        $("#biayaPerjalananDisplay").val(formattedBiayaPerjalanan);
                        $("#biayaPerjalanan").val(biayaPerjalananDisplay);
                        $("#asalKotaError").remove();
                        $("#tujuanError").remove();
                        $("#agendaError").remove();
                        $("#keteranganError").remove();
                        if (!level1) $("#submit").attr("disabled", false);
                        if (adminsss) $("#submit").attr("disabled", false);
                    },
                    error: function(err) {
                        console.log(err);
                    }
                });
            });


            $(document).on("click", ".revision", function(e) {
                const tr = $(this).parent().parent().parent()
                const table = tr.next().find("#table-revise-container")
                const id = $(tr).attr("data-id");
                if ($(table).parent().parent().hasClass("in")) e.stopPropagation()
                $(table).append(
                    `<tr><td><div class="form-group required">
                        <div class="input-group datepick">
                            <input type="text" class="form-control dateTimePicker" id="tglMulai${id}"
                                placeholder="Masukkan Tanggal Mulai" required readonly style="width:200px;">
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </div>
                        </div>
                        </div> ` +
                    '</td>' +
                    `<td><div class="form-group required">
                        <div class="input-group datepick">
                            <input type="text" class="form-control dateTimePicker" id="tglAkhir${id}"
                                placeholder="Masukkan Tanggal Mulai" required readonly style="width:200px;">
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </div>
                        </div>
                        </div>` +
                    '</td>' +
                    `<td><input type = "text" class="form-control" id="asalKota${id}" style="width:100px;"> ` +
                    '</td>' +
                    `<td><input type = "text" class="form-control" id="tujuan${id}" style="width:100px;"> ` +
                    '</td>' +
                    `<td><input type = "text" class="form-control" id="select-sales${id}" readonly value = "{{ Auth::user()->name }}" style="width:100px;"> ` +
                    '</td>' +
                    `<td><select class="form-control"  id="select-ppc${id}" style="width:150px;"></select> ` +
                    '</td>' +
                    `<td><input type="text"  id="nopaket${id}" class="form-control" placeholder="Masukkan No Paket"
                            disabled style="width:150px;"></select> ` +
                    '</td>' +
                    `<td><textarea class="form-control" row=10 col=10 id="agenda${id}" style="width:150px;"></textarea> ` +
                    '</td>' +
                    `<td><textarea class="form-control" row=10 col=10 id="keterangan${id}" style="width:150px;"></textarea> ` +
                    '</td>' +
                    `<td><input type = "number" min="0" step="1000" value="0" class="form-control" id="biaya${id}" style="width:100px;"> ` +
                    '</td>' +
                    `<td><div style="display:flex;"><a class="btn btn-success add-revision" data-id="${id}"><i class="fa fa-plus-square-o"></i></a> &nbsp;<a class="btn btn-danger remove-revision"><i class="fa fa-times-circle"></i></a></div></td></tr>`
                )
                initDTP("#tglMulai" + id, today)
                initDTP("#tglAkhir" + id, today)
                $("#select-ppc" + id).select2({
                    placeholder: 'Tidak ada ID Opti',
                    allowClear: true,
                    ajax: {
                        url: '{{ route('loadPPC') }}',
                        dataType: 'json',
                        delay: 250,
                        processResults: function(data) {
                            return {
                                results: $.map(data.data, function(item) {
                                    return {
                                        text: item.namaOpti,
                                        id: item.id,
                                        noPaket: item.noPaket
                                    }
                                })
                            };
                        },
                        cache: true
                    }
                }).on("change", function(e) {
                    var selectedData = $(this).select2('data');
                    $('#nopaket' + id).val(selectedData[0].noPaket);
                }).on('select2:unselect', function(e) {
                    $('#nopaket' + id).val('');
                });
            });

            $(document).on("click", ".remove-revision", function() {
                $(this).parent().parent().parent().remove();
            });

            $(document).on("click", ".remove-detail", function(e) {
                e.stopPropagation();
                const tr = $(this).parent().parent().parent()
                const id = tr.attr("data-id")
                const trs = $(tr).next().find("#table-revise-container > tr")
                const par = $(this).parent();
                const biaya = (!$(tr).hasClass("lineStrike") ? $(this).parent().parent().prev().find(
                    "input#biaya").val() : (!$(trs).last().hasClass("lineStrike") && $(trs).is(
                    ":parent") ? $(trs).not(
                    ".lineStrike").find("input#biaya").val() : 0))
                $.ajax({
                    type: "POST",
                    url: "{{ route('bon.destroyDetail') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": id,
                        "bid": bid,
                        "biaya": biaya
                    },
                    success: function(response) {
                        $(tr).addClass("lineStrike")
                        $.each(trs, function(i, val) {
                            $(val).addClass("lineStrike")
                        });
                        let biayaPerjalananDisplay = parseInt($("#biayaPerjalanan").val()) -
                            parseInt(biaya);
                        let formattedBiayaPerjalanan = biayaPerjalananDisplay.toLocaleString(
                            'id-ID', {
                                style: 'currency',
                                currency: 'IDR',
                                minimumFractionDigits: 0
                            });
                        $("#biayaPerjalananDisplay").val(formattedBiayaPerjalanan);
                        $("#biayaPerjalanan").val(biayaPerjalananDisplay);
                        var notDeleted = $("#table-container tr").filter(function(index) {
                            return $(this).children().length > 2 && !$(this).hasClass(
                                "lineStrike")
                        })
                        if (!level1) $("#submit").attr("disabled", !notDeleted.length > 0);
                        if (adminsss) $("#submit").attr("disabled", !notDeleted.length > 0);

                    },
                    error: function(err) {
                        console.log(err);
                    }
                });
            });
            $(document).on("click", ".add-revision", function() {
                const Btn = $(this)
                const id = $(Btn).attr("data-id")
                const asal = $("#asalKota" + id).val();
                const tujuan = $("#tujuan" + id).val();
                const agenda = $("#agenda" + id).val()
                const keter = $("#keterangan" + id).val()
                const tglMulai = $("#tglMulai" + id).val()
                const tglAkhir = $("#tglAkhir" + id).val();
                const nopaket = $("#nopaket" + id).val()
                const sales = {!! Auth::user()->id !!}
                const proj = $("#select-ppc" + id).val()
                var biaya = parseInt($("#biaya" + id).val());
                var biayaDeduct = (!$("tr[data-id='" + id + "']").hasClass("lineStrike") ? $(
                    "tr[data-id='" + id + "']").find("input#biaya").val() : (!$(this).parent()
                    .parent().parent().prev().hasClass("lineStrike") && $(this).parent()
                    .parent().parent().prev().length > 0 ? $(this).parent().parent()
                    .parent().prev().find("input#biaya").val() : 0))
                $.ajax({
                    type: "POST",
                    url: "{{ route('bon.addNewDetailRevision') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "tglMulai": tglMulai,
                        "tglAkhir": tglAkhir,
                        "asalKota": asal,
                        "tujuan": tujuan,
                        "select-sales": sales,
                        "select-ppc": proj,
                        "nopaket": nopaket,
                        "agenda": agenda,
                        "keterangan": keter,
                        "biaya": biaya,
                        "biayaDeduct": biayaDeduct,
                        "id": id,
                        "bid": bid
                    },
                    success: function(response) {
                        const idNew = response.idNew
                        let biayaPerjalananDisplay = parseInt($("#biayaPerjalanan").val()) +
                            parseInt(biaya) - parseInt(biayaDeduct)
                        let formattedBiayaPerjalanan = biayaPerjalananDisplay.toLocaleString(
                            'id-ID', {
                                style: 'currency',
                                currency: 'IDR',
                                minimumFractionDigits: 0
                            });
                        $("#biayaPerjalananDisplay").val(formattedBiayaPerjalanan);
                        $("#biayaPerjalanan").val(biayaPerjalananDisplay);
                        const new_row =
                            `<input type = "hidden" name = "detailbonsId[]" value = "${id}" ><td>${$("#tglMulai"+id).val()}<input type = "hidden" name = "tglMulaiRev[]" value = "${$("#tglMulai"+id).val()}" > ` +
                            '</td>' +
                            `<td>${$("#tglAkhir"+id).val()}<input type = "hidden" name = "tglAkhirRev[]" value = "${$("#tglAkhir"+id).val()}" > ` +
                            '</td>' +
                            `<td>${$("#asalKota"+id).val()}<input type = "hidden" name = "asalKotaRev[]"value = "${$("#asalKota"+id).val()}" > ` +
                            '</td>' +
                            `<td>${$("#tujuan"+id).val()}<input type = "hidden" name = "tujuanRev[]" value = "${$("#tujuan"+id).val()}" > ` +
                            '</td>' +
                            `<td>{{ Auth::user()->name }}<input type = "hidden" name = "select-salesRev[]" value = "{{ Auth::user()->id }}" > ` +
                            '</td>' +
                            `<td>${($("#select-ppc"+id+" option:selected").text()==""?"-":$("#select-ppc"+id+" option:selected").text())}<input type = "hidden" name = "select-ppcRev[]" value = "${$("#select-ppc"+id).val()}" > ` +
                            '</td>' +
                            `<td>${($("#nopaket"+id).val()==""?"-":$("#nopaket"+id).val())}<input type = "hidden" name = "nopaketRev[]" value = "${$("#nopaket"+id).val()}" > ` +
                            '</td>' +
                            `<td>${$("#agenda"+id).val()}<input type = "hidden" name = "agendaRev[]" value = "${$("#agenda"+id).val() }" > ` +
                            '</td>' +
                            `<td>${$("#keterangan"+id).val()}<input type = "hidden" name = "keteranganRev[]" value = "${$("#keterangan"+id).val()}" > ` +
                            '</td>' +
                            `<td>${(parseInt($("#biaya"+id).val()) ? parseInt($("#biaya"+id).val()).toLocaleString(
                                'id-ID', {
                                    style: 'currency',
                                    currency: 'IDR',
                                    minimumFractionDigits: 0
                                }) : '')}<input type = "hidden" name = "biayaRev[]" id = "biaya" value = "${$("#biaya"+id).val()}" > ` +
                            '</td>' +
                            '<td>' +
                            `<div style="display:flex;"><a class="btn btn-warning revision"><i class="fa fa-pencil"></i></a>&nbsp;<a class="btn btn-danger remove-detail"><i class="fa fa-times-circle"></i></a>` +
                            '</td>'
                        const table = $(Btn).parent().parent().parent().parent()
                        const originalDetail = $("tr[data-id='" + id + "']")
                        const cur_tr = $(Btn).parent().parent().parent();
                        $(originalDetail).addClass("lineStrike")
                        $(originalDetail).children().last().remove();
                        $(cur_tr).prev().addClass("lineStrike")
                        $(Btn).parent().parent().parent().remove()
                        $(table).prepend($(originalDetail).clone())
                        $(originalDetail).html(new_row)
                        $(originalDetail).removeClass("lineStrike")
                        $(originalDetail).attr("data-id", idNew);
                        $(originalDetail).attr("href", "#collapse" + idNew);
                        $("div#collapse" + id).attr("id", "collapse" + idNew)
                        if (!level1) $("#submit").attr("disabled", false);
                        if (adminsss) $("#submit").attr("disabled", false);

                    },
                    error: function(err) {
                        console.log(err);
                    }
                });
            });
            $(document).on("click", ".datepick", function() {
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
            $.ajax({
                type: "POST",
                url: "{{ route('bon.loadDetailBon') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": {{ $bon->id }}
                },
                dataType: 'JSON',
                success: function(response) {
                    const data = response.data
                    const dataRevision = response.dataRevision
                    var tbody = $('#table-container'); // Get the tbody element
                    tbody.empty(); // Clear the tbody
                    $.each(data, function(i, item) {
                        var row = '<tr data-toggle="collapse" class="' + (item.deleted_at ?
                                "lineStrike" : "") +
                            '" href="#collapse' +
                            item.id +
                            '" data-id="' + item.id + '"><td>' + (item.tglMulai ? item
                                .tglMulai : '') +
                            `<input type="hidden" name="tglMulai[]" value="${item.tglMulai}">` +
                            '</td>' +
                            '<td>' + (item.tglAkhir ? item.tglAkhir : '') +
                            `<input type="hidden" name="tglAkhir[]" value="${item.tglAkhir}">` +
                            '</td>' +
                            '<td>' + (item.asalKota ? item.asalKota : '') +
                            `<input type="hidden" name="asalKota[]" value="${item.asalKota}">` +
                            '</td>' +
                            '<td>' + (item.tujuan ? item.tujuan : '') +
                            `<input type="hidden" name="tujuan[]" value="${item.tujuan}">` +
                            '</td>' +
                            '<td>' + (item.name ? item.name : '-') +
                            `<input type="hidden" name="select-sales[]" value="{{ Auth::user()->id }}">` +
                            '</td>' +
                            '<td>' + (item.namaOpti ? item.namaOpti : '-') +
                            `<input type="hidden" name="select-ppc[]" value="${item.pid}">` +
                            '</td>' +
                            '<td>' + (item.noPaket ? item.noPaket : '-') +
                            `<input type="hidden" name="nopaket[]" value="${item.noPaket}">` +
                            '</td>' +
                            '<td>' + (item.agenda ? item.agenda : '') +
                            `<input type="hidden" name="agenda[]" value="${item.agenda }">` +
                            '</td>' +
                            '<td>' + (item.penggunaan ? item.penggunaan : '') +
                            `<input type="hidden" name="keterangan[]" value="${item.penggunaan}">` +
                            '</td>' +
                            '<td>' + (item.biaya ? item.biaya.toLocaleString(
                                'id-ID', {
                                    style: 'currency',
                                    currency: 'IDR',
                                    minimumFractionDigits: 0
                                }) : '') +
                            `<input type="hidden" name="biaya[]" id="biaya" value="${item.biaya }">` +
                            '</td>' +
                            '<td>' +
                            `<div style="display:flex;"><a class="btn btn-warning revision"><i class="fa fa-pencil"></i></a>&nbsp;<a class="btn btn-danger remove-detail"><i class="fa fa-times-circle"></i></a>` +
                            '</td></tr>'
                        var row_child = `<td colspan="12" class="nopading" ><div id="collapse${item.id}" class="panel-collapse collapse padding table-responsive salmon">
                                        <table id="tableRevise" class="table table-hover">
                                        <tbody id="table-revise-container">`;
                        if (dataRevision != undefined || dataRevision != null) {
                            for (const iterator of dataRevision) {
                                if (iterator.detailbons_revision_id == item.id) {
                                    row_child +=
                                        `<tr class="${(iterator.deleted_at?"lineStrike":"")}"><input type = "hidden" name = "detailbonsId[]" value = "${item.id}" ><td>${(iterator.tglMulai ? iterator.tglMulai : '-')}<input type = "hidden" name = "tglMulai[]" value = "${iterator.tglMulai}" > ` +
                                        '</td>' +
                                        `<td>${(iterator.tglAkhir ? iterator.tglAkhir : '-')}<input type = "hidden" name = "tglAkhirRev[]" value = "${iterator.tglAkhir}" > ` +
                                        '</td>' +
                                        `<td>${(iterator.asalKota ? iterator.asalKota : '-')}<input type = "hidden" name = "asalKotaRev[]"value = "${iterator.asalKota}" > ` +
                                        '</td>' +
                                        `<td>${(iterator.tujuan ? iterator.tujuan : '-')}<input type = "hidden" name = "tujuanRev[]" value = "${iterator.tujuan}" > ` +
                                        '</td>' +
                                        `<td>${(iterator.name ? iterator.name : '-')}<input type = "hidden" name = "select-salesRev[]" value = "{{ Auth::user()->id }}" > ` +
                                        '</td>' +
                                        `<td>${(iterator.namaOpti ? iterator.namaOpti : '-')}<input type = "hidden" name = "select-ppcRev[]" value = "${iterator.pid}" > ` +
                                        '</td>' +
                                        `<td>${(iterator.noPaket ? iterator.noPaket : '-')}<input type = "hidden" name = "nopaketRev[]" value = "${iterator.noPaket}" > ` +
                                        '</td>' +
                                        `<td>${(iterator.agenda ? iterator.agenda : '-')}<input type = "hidden" name = "agendaRev[]" value = "${iterator.agenda }" > ` +
                                        '</td>' +
                                        `<td>${(iterator.penggunaan ? iterator.penggunaan : '-')}<input type = "hidden" name = "keteranganRev[]" value = "${iterator.penggunaan}" > ` +
                                        '</td>' +
                                        `<td>${(iterator.biaya ? iterator.biaya.toLocaleString(
                                'id-ID', {
                                    style: 'currency',
                                    currency: 'IDR',
                                    minimumFractionDigits: 0
                                }) : '')}<input type = "hidden" name = "biayaRev[]" id = "biaya" value = "${iterator.biaya }" > ` +
                                        '</td></tr>'
                                }
                            }
                        }
                        row_child += `</tbody></table></div></td>`;
                        row += row_child
                        tbody.append(row);
                    });
                    var notDeleted = $("#table-container tr").filter(function(index) {
                        return $(this).children().length > 2 && !$(this).hasClass("lineStrike")
                    })

                    if (!level1 && notDeleted.length > 0) $("#submit").attr("disabled", false);
                    if (adminsss && notDeleted.length > 0) $("#submit").attr("disabled", false);
                }
            });
        })
    </script>
@endsection
