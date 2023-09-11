@extends('utama')
@section('title')
    Tambahkan Project Baru
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
    <form method="POST" action="{{ route('project.store') }}">
        @csrf
        <div class="form-group">
            <label for="namaoptipro">Nama Project</label><br>
            <input type="text" name="namaoptipro" id="namaoptipro" class="form-control"
                placeholder="Masukkan Nama Project. Contoh: Pemasangan CCTV di Performa Optima Komputindo" value="{{ old('namaoptipro') }}">
            @error('namaoptipro')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="exampleForm">Pilih Pelanggan</label>
            <select class="form-control" name="customerid" id="customerId"></select>
            @error('customerid')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="lokasipro">Lokasi Project</label><br>
            <input type="text" name="lokasipro" id="lokasipro" class="form-control"
                placeholder="Masukkan Lokasi Project. Contoh: Jl. Sidosermo Airdas No.Kav A9, Sidosermo, Kec. Wonocolo, Surabaya, Jawa Timur 60239" value="{{ old('lokasipro') }}">
            @error('customerid')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group required" style="min-width:25%; max-width:30%">
            <label for="deadline">Tanggal Mulai Pengerjaan</label><br>
            <div class="input-group datepick">
                <input type="text" class="form-control dateTimePicker" name="tglmulaipro" id="tglmulaipro"
                    placeholder="Masukkan Tanggal Pembuatan" required readonly>
                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </div>
            </div>
        </div>
        <div class="form-group required" style="min-width:25%; max-width:30%">
            <label for="deadline">Deadline</label><br>
            <div class="input-group datepick">
                <input type="text" class="form-control dateTimePicker" name="deadlinePro" id="deadlinePro"
                    placeholder="Masukkan Tanggal Pembuatan " required readonly>
                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </div>
            </div>
            <div class="btn-group" role="group" aria-label="...">
                <button type="button" class="btn btn-default btn-info" onclick="appendDate('day')">+1 Hari</button>
                <button type="button" class="btn btn-default btn-primary" onclick="appendDate('week')">+1 Minggu</button>
                <button type="button" class="btn btn-default btn-info" onclick="appendDate('month')">+1 Bulan</button>
            </div>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Status</label>
            <select name="statuspro" id="statusPro"
                class="selectpicker form-control border-0 mb-1 px-4 py-4 rounded shadow">
                <option value="" selected disabled hidden>Pilih Jenis Status Anda</option>
                <option value="Menunggu">Menunggu</option>
                <option value="Proses">Proses</option>
                <option value="Ditunda">Ditunda</option>
                <option value="Selesai">Selesai</option>
            </select>
            @error('statuspro')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Tambahkan</button>
        <a class="btn btn-danger" href="/project">Batal Tambah</a>
    </form>
@endsection

@section('javascript')
    <script type="text/javascript">
        $("#project").addClass("active");
        $("#dataProject").addClass("active");
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            var today = new Date();
            $('#tglmulaipro').datetimepicker({
                format: 'dddd, DD-MM-yyyy',
                ignoreReadonly: true,
                locale: 'id'
            }).data("DateTimePicker").date(moment(today))

            $('#deadlinePro').datetimepicker({
                format: 'dddd, DD-MM-yyyy',
                ignoreReadonly: true,
                locale: 'id'
            }).data("DateTimePicker").date(moment(today))

            $(".datepick").on("click", function() {
                $(this).find(".dateTimePicker").focus()
            });

            $(".dateTimePicker").on("dp.change", function() {
                let mulai = $('#tglmulaipro').data("DateTimePicker").date()
                let deadline = $('#deadlinePro').data("DateTimePicker").date()
                if ($(this).attr("id") == "tglmulaipro") {
                    if (deadline.isBefore(mulai)) {
                        $('#deadlinePro').data("DateTimePicker").date(mulai)
                    } else return
                } else {
                    if (deadline.isBefore(mulai)) {
                        $('#tglmulaipro').data("DateTimePicker").date(deadline)
                    } else return
                }
            });
            $('#customerId').select2({
                placeholder: 'Pilih Pelanggan',
                ajax: {
                    url: '{{ route('cariCustomer') }}',
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    text: item.nama,
                                    id: item.id
                                }
                            })
                        };
                    },
                    cache: true
                }
            });
        });

        const appendDate = (option) => {
            var date = $('#deadlinePro').data("DateTimePicker").date()
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
            $('#deadlinePro').data("DateTimePicker").date(date)
        }
    </script>
@endsection
