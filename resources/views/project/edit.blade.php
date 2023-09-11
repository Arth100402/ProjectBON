@extends('utama')
@section('isi')
    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <style>
        .cariCB {
            width: 100% !important;
        }
    </style>
    <h1>Ubah Data Project {{ $data['namaOpti'] }}</h1>
    <form action="{{ route('project.update', $data['id']) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="namaOpti">Nama Project</label>
            <input type="text" style="text-transform:uppercase" class="form-control" name="namaOpti" id="namaOpti"
                placeholder="Masukkan Nama Project. Contoh: Pemasangan CCTV di Performa Optima Komputindo" value="{{ $data['namaOpti'] }}">
        </div>
        <div class="form-group">
            <label for="posisi">Lokasi Project</label>
            <input type="text" style="text-transform:uppercase" class="form-control" name="posisi" id="posisi"
                placeholder="Masukkan Lokasi Project. Contoh: Jl. Sidosermo Airdas No.Kav A9, Sidosermo, Kec. Wonocolo, Surabaya, Jawa Timur 60239" value="{{ $data['posisi'] }}">
        </div>
        <div class="form-group">
            <label for="status">Status Project</label><br>
            <select name="status" id="status" class="selectpicker form-control border-0 mb-1 px-4 py-4 rounded shadow">
                <option value="{{ $data['status'] }}" selected hidden>{{ $data['status'] }}</option>
                <option value="Batal">Batal</option>
                <option value="Menunggu">Menunggu</option>
                <option value="Proses">Proses</option>
                <option value="Ditunda">Ditunda</option>
                <option value="Selesai">Selesai</option>
            </select>
        </div>


        <div class="form-group required" style="min-width:25%; max-width:30%">
            <label for="deadline">Deadline Project</label><br>
            <div class="input-group datepick">
                <input type="text" class="form-control dateTimePicker" name="deadline" id="deadline" required readonly>
                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </div>
            </div>
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-default btn-info" onclick="appendDate('day','#deadline')">+1
                    Hari</button>
                <button type="button" class="btn btn-default btn-primary" onclick="appendDate('week','#deadline')">+1
                    Minggu</button>
                <button type="button" class="btn btn-default btn-info" onclick="appendDate('month','#deadline')">+1
                    Bulan</button>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Ubah</button>
        <a class="btn btn-danger" href="/project">Batal Ubah</a>
    </form>
@endsection
@section('javascript')
    <script type="text/javascript">
        $(document).ready(function() {
            var val = {!! json_encode($data->toArray()) !!};
            $('#deadline').datetimepicker({
                format: 'dddd, DD-MM-yyyy',
                ignoreReadonly: true,
                locale: 'id'
            }).data("DateTimePicker").date(moment(val.deadline))

            $(".datepick").on("click", function() {
                $(this).find(".dateTimePicker").focus()
            });
        });

        const appendDate = (option, id) => {
            var date = $(id).data("DateTimePicker").date()
            switch (option) {
                case "day":
                    date.add(1, "day")
                    break;
                case "month":
                    date.add(1, "month")
                    break;
                case "week":
                    date.add(1, "week")
                    break;
                default:
                    console.log("Error! Error! Abort Ship!");
                    break;
            }
            $(id).data("DateTimePicker").date(date)
        }
    </script>
    <script>
        $("#project").addClass("active");
        $("#dataProject").addClass("active");
        $('#myTable').DataTable();
    </script>
@endsection
