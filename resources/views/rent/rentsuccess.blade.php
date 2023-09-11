@extends('utama')
@section('title')
    Selesaikan Persewaan Kendaraan
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
    <form method="POST" action="{{ route('vehicle.sewaKendaraanFinish', $data->id) }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="exampleForm">Pilih Kendaraan</label>
            <select class="form-control" name="vehicleid" id="vehicleId">
                <option value="{{ $data->vehicles_id }}">{{ $data->kendaraan }}</option>
            </select>
            @error('vehicleid')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Penyewa</label><br>
            <input type="text" class="form-control" value="{{ Auth::user()->name }}" disabled>
            <input type="hidden" name="userid" class="form-control" id="userId" value="{{ Auth::user()->id }}">
        </div>
        <div class="form-group required" style="min-width:25%; max-width:30%">
            <label for="tglsewaVeh">Tanggal Sewa</label><br>
            <div class="input-group">
                <input type="text" class="form-control" name="tglsewaVeh" id="tglsewaVeh"
                    placeholder="Masukkan Tanggal Sewa" required readonly>
                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </div>
            </div>
            &nbsp;<small>Tidak bisa diubah!</small>
        </div>

        <div class="form-group required" style="min-width:25%; max-width:30%">
            <label for="tglselesaiVeh">Tanggal Selesai</label><br>
            <div class="input-group datepick">
                <input type="text" class="form-control dateTimePicker" name="tglselesaiVeh" id="tglselesaiVeh"
                    placeholder="Masukkan Tanggal Sewa" required readonly>
                <div class="input-group-addon btn">
                    <span class="glyphicon glyphicon-calendar"></span>
                </div>
            </div>
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-default btn-info" onclick="appendDate('day','#tglselesaiVeh')">+1
                    Hari</button>
                <button type="button" class="btn btn-default btn-primary" onclick="appendDate('3day','#tglselesaiVeh')">+3
                    Hari</button>
                <button type="button" class="btn btn-default btn-info" onclick="appendDate('week','#tglselesaiVeh')">+1
                    Minggu</button>
            </div>
            @error('tglselesaiVeh')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">Tujuan Peminjaman</label><br>
            <input type="text" name="tujuanpeminjaman" class="form-control" id="tujuanPeminjaman"
                aria-describedby="nameHelp" placeholder="Masukkan Tujuan Peminjaman" value="{{ $data->tujuan }}">
            @error('tujuanpeminjaman')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group" @if ($data->status == 'Internal') style="display: none;" @endif>
            <label for="exampleInputEmail1">Biaya Sewa</label><br>
            <input type="number" min="0" max="1000000000" name="biayasewa" class="form-control" id="biayaSewa"
                aria-describedby="nameHelp" placeholder="Masukkan Biaya Sewa"
                @if ($data->status == 'Internal') value="0" @else value="{{ $data->biayaSewa }}" @endif>
            @error('biayasewa')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Km Awal</label><br>
            <input type="number" min="1" max="1000000000" name="kmawal" class="form-control" id="kmAwal"
                aria-describedby="nameHelp" placeholder="Masukkan Km Awal" value="{{ $data->kmAwal }}">
            @error('kmawal')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Km Akhir</label><br>
            <input type="number" min="1" max="1000000000" name="kmakhir" class="form-control" id="kmAkhir"
                aria-describedby="nameHelp" placeholder="Masukkan Km Akhir" value="{{ $data->kmAkhir }}">
            @error('kmakhir')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Total Liter</label><br>
            <input type="number" min="1" max="1000000000" name="totalliter" class="form-control"
                id="totalLiter" aria-describedby="nameHelp" placeholder="Masukkan Total Liter"
                value="{{ $data->totalLiter }}">
            @error('totalliter')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Lokasi Pengisian</label><br>
            <input type="text" name="lokasipengisian" class="form-control" id="lokasiPengisian"
                aria-describedby="nameHelp" placeholder="Masukkan Lokasi Pengisian"
                value="{{ $data->lokasiPengisian }}">
            @error('lokasipengisian')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Status</label>
            <select name="statusrentveh" id="statusrentVeh"
                class="selectpicker form-control border-0 mb-1 px-4 py-4 rounded shadow" disabled>
                <option value="{{ $data->status }}">{{ $data->status }}</option>
            </select>
            <input type="hidden" name="statusrentveh" class="form-control" id="statusrentVeh"
                value="{{ $data->status }}">
        </div>
        <div class="form-group">
            <label for="file">Masukkan Gambar KM Awal dan Akhir</label>
            <input type="file" name="images[]" id="images" class="form-control" multiple>
        </div>
        <div class="form-group">
            <div id="preview-container"></div>
        </div>
        <button type="submit" class="btn btn-success">Selesaikan</button>
        <a class="btn btn-danger" href="/vehicle">Batal</a>
    </form>
@endsection

@section('javascript')
    <script>
        const appendDate = (option, id) => {
            var date = $(id).data("DateTimePicker").date()
            switch (option) {
                case "day":
                    date.add(1, "day")
                    break;
                case "3day":
                    date.add(3, "day")
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
        $(document).ready(function() {
            $("#vehicle").addClass("active");
            $("#peminjamanKendaraan").addClass("active");
            var date = {!! json_encode($data->toArray()) !!}
            $("#tglsewaVeh").datetimepicker({
                format: 'dddd, DD-MM-yyyy',
                ignoreReadonly: false,
                locale: 'id'
            }).data("DateTimePicker").date(moment(date.tglSewa))
            $("#tglselesaiVeh").datetimepicker({
                format: 'dddd, DD-MM-yyyy',
                ignoreReadonly: true,
                locale: 'id',
                minDate: moment(date.tglSewa)
            }).data("DateTimePicker").date(moment(date.tglSelesai))
            $(".datepick").on("click", function() {
                $(this).find(".dateTimePicker").focus()
            });
        });
    </script>
    <script>
        document.getElementById('images').addEventListener('change', function(e) {
            var files = e.target.files;
            var previewContainer = document.getElementById('preview-container');

            previewContainer.innerHTML = '';

            for (var i = 0; i < files.length; i++) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    var image = document.createElement('img');
                    image.src = e.target.result;
                    image.style.maxHeight = '200px';

                    previewContainer.appendChild(image);
                }

                reader.readAsDataURL(files[i]);
            }
        });
    </script>
@endsection
