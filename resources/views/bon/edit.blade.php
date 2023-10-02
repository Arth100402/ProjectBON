@extends('utama')
@section('title')
    Form Ubah Pengajuan Perjalanan Dinas
@endsection
@section('isi')
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
        {{-- <div class="btn-group" role="group" aria-label="...">
            <button type="button" class="btn btn-default btn-info" onclick="appendDate('day','#tglMulai')">+1
                Hari</button>
            <button type="button" class="btn btn-default btn-primary" onclick="appendDate('week','#tglMulai')">+1
                Minggu</button>
            <button type="button" class="btn btn-default btn-info" onclick="appendDate('month','#tglMulai')">+1
                Bulan</button>
        </div> --}}
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
    <div class="form-group">
        <label for="sales">Pilih Sales: </label>
        <select class="form-control" name="sales" id="select-sales" disabled>
            <option value="{{ Auth::user()->id }}">{{ Auth::user()->name }}</option>
        </select>
        @error('sales')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
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
    <form method="POST" action="{{ route('bon.update',$bon->id) }}" enctype="multipart/form-data">
        @csrf
        @method("PUT")
        <div class="table-responsive" style="overflow: scroll">
            <table id="myTable" class="table table-striped table-bordered">
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
            <input type="number" min="0" value="{{$bon->total}}" name="biayaPerjalanan" class="form-control"
                id="biayaPerjalanan" readonly>
            @error('debit')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="sadaw">Surat (Jika Ada):</label>
            <input type="file" name="filenames[]" id="files" class="form-control" multiple>
            <small>Types: .doc, .docx, .pdf, .xlx, .csv</small>
        </div>
        <button type="submit" id="submit" disabled class="btn btn-primary">Ubah</button>
        <a class="btn btn-danger" href="/">Batal Ubah</a>
    </form>
@endsection
@section('javascript')
    <script>
        const biayaPerjalanan = 0;
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

                if (!asal || !tujuan || !agenda || !keter || asal == '' || tujuan == '' || agenda == '' ||
                    keter == '') {
                    alert("Terdapat bagian yang belum terisi!")
                    return
                }
                // Add to Table
                $("#submit").attr("disabled", false);
                var rows = `
                    <tr>
                        <td>${$("#tglMulai").val()}<input type="hidden" name="tglMulai[]" value="${$("#tglMulai").val()}"></td>
                        <td>${$("#tglAkhir").val()}<input type="hidden" name="tglAkhir[]" value="${$("#tglAkhir").val()}"></td>
                        <td>${asal}<input type="hidden" name="asalKota[]" value="${asal}"></td>
                        <td>${tujuan}<input type="hidden" name="tujuan[]" value="${tujuan}"></td>
                        <td>${$("#select-sales option:selected").text()}<input type="hidden" name="select-sales[]" value="${$("#select-sales").val()}"></td>
                        <td>${$("#select-ppc option:selected").text()}<input type="hidden" name="select-ppc[]" value="${$("#select-ppc").val()}"></td>
                        <td>${$("#nopaket").val()}<input type="hidden" name="nopaket[]" value="${$("#nopaket").val()}"></td>
                        <td>${agenda}<input type="hidden" name="agenda[]" value="${agenda}"></td>
                        <td>${keter}<input type="hidden" name="keterangan[]" value="${keter}"></td>
                        <td>${$("#biaya").val()}<input type="hidden" name="biaya[]" id="biaya" value="${$("#biaya").val()}"></td>
                        <td><a class="btn btn-danger btn-block" id="deleteRow"><i class="fa fa-trash-o"></i></a></td>
                    </tr>`
                $("#table-container").append(rows);
                $("#biayaPerjalanan").val(parseInt($("#biayaPerjalanan").val()) + parseInt($("#biaya")
                    .val()));
            });
            $(document).on("click", "#deleteRow", function() {
                const totalPengeluaran = $(this).parent().parent().find("#biaya").val()
                $("#biayaPerjalanan").val(parseInt($("#biayaPerjalanan").val()) - parseInt(
                    totalPengeluaran));
                console.log($(this).parent().parent().find("#biaya"));
                $(this).parent().parent().remove()
                if ($("#table-container tr").length < 1) {
                    $("#submit").attr("disabled", true);
                }
                else{
                    $("#submit").attr("disabled", false);
                }
            });
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
            $.ajax({
                type: "POST",
                url: "{{ route('bon.loadDetailBon') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": {{ $bon->id }}
                },
                dataType: 'JSON',
                success: function(data) {
                    console.log("TEST");
                    console.log(data);
                    var tbody = $('#table-container'); // Get the tbody element
                    tbody.empty(); // Clear the tbody

                    $.each(data, function(i, item) {
                        console.log(i, item);
                        var row = '<tr><td>' + (item.tglMulai ? item.tglMulai : '')+`<input type="hidden" name="tglMulai[]" value="${item.tglMulai}">`+'</td>'+
                            '<td>' + (item.tglAkhir ? item.tglAkhir : '') +`<input type="hidden" name="tglAkhir[]" value="${item.tglAkhir}">`+'</td>'+
                            '<td>' + (item.asalKota ? item.asalKota : '') +`<input type="hidden" name="asalKota[]" value="${item.asalKota}">`+'</td>'+
                            '<td>' + (item.tujuan ? item.tujuan : '')+`<input type="hidden" name="tujuan[]" value="${item.tujuan}">`+'</td>'+
                            '<td>' + (item.name ? item.name : '') + `<input type="hidden" name="select-sales[]" value="{{Auth::user()->id}}">`+'</td>'+
                            '<td>' + (item.namaOpti ? item.namaOpti : '')+ `<input type="hidden" name="select-ppc[]" value="${item.pid}">` + '</td>'+
                            '<td>' + (item.noPaket ? item.noPaket : '')+`<input type="hidden" name="nopaket[]" value="${item.noPaket}">` + '</td>'+
                            '<td>' + (item.agenda ? item.agenda : '') +`<input type="hidden" name="agenda[]" value="${item.agenda }">`+ '</td>'+
                            '<td>' + (item.penggunaan ? item.penggunaan : '') +`<input type="hidden" name="keterangan[]" value="${item.penggunaan}">`+ '</td>'+
                            '<td>' + (item.biaya ? item.biaya : '')+ `<input type="hidden" name="biaya[]" id="biaya" value="${item.biaya }">`+ '</td>'+
                            '<td>' + `<a class="btn btn-danger btn-block" id="deleteRow"><i class="fa fa-trash-o"></i></a>` + '</td></tr>';
                        tbody.append(row);
                    });
                }
            });
        });
    </script>
@endsection
