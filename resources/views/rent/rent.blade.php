@extends('utama')
@section('title')
    Pinjam Kendaraan
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
    <form method="POST" action="{{ route('vehicle.sewaKendaraan') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="exampleForm">Pilih Kendaraan</label>
            <select class="form-control" name="vehicleid" id="vehicleId"></select>
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
            <div class="input-group datepick">
                <input type="text" class="form-control dateTimePicker" name="tglsewaVeh" id="tglsewaVeh"
                    placeholder="Masukkan Tanggal Sewa" required readonly>
                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </div>
            </div>
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-default btn-info" onclick="appendDate('day','#tglsewaVeh')">+1
                    Hari</button>
                <button type="button" class="btn btn-default btn-primary" onclick="appendDate('3day','#tglsewaVeh')">+3
                    Hari</button>
                <button type="button" class="btn btn-default btn-info" onclick="appendDate('week','#tglsewaVeh')">+1
                    Minggu</button>
            </div>
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
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">Tujuan Peminjaman</label><br>
            <input type="text" name="tujuanpeminjaman" class="form-control" id="tujuanPeminjaman"
                aria-describedby="nameHelp" placeholder="Masukkan Tujuan Peminjaman. Contoh: Pengiriman barang ke Jakarta untuk Project Pemasangan CCTV PLN" value="{{ old('tujuanpeminjaman') }}">
                @error('tujuanpeminjaman')
                <span class="text-danger">{{ $message }}</span>
                @enderror
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Status</label>
            <select name="statusrentveh" id="statusrentVeh"
                class="selectpicker form-control border-0 mb-1 px-4 py-4 rounded shadow">
                @if (old('statusrentveh') != null)
                    <option value="{{ old('statusrentveh') }}" selected hidden>{{ old('statusrentveh') }}</option>
                @else
                    <option value="" selected disabled hidden>Pilih Jenis Status Anda</option>
                @endif
                <option value="Internal">Internal</option>
                <option value="External">External</option>
            </select>
            @error('statusrentveh')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="file">Masukkan Gambar Jaminan</label>
            <input type="file" name="images[]" id="images" class="form-control" multiple>
        </div>
        <div class="form-group">
            <div id="preview-container"></div>
        </div>
        <button type="submit" class="btn btn-success">Sewa</button>
        <a class="btn btn-danger" href="/customvehicle/historyRentCust">Batal Sewa</a>
    </form>
@endsection

@section('javascript')
    <script>
        $("#vehicle").addClass("active");
        $("#peminjamanKendaraan").addClass("active");
        const initDTP = (id, date) => {
            $(id).datetimepicker({
                format: 'dddd, DD-MM-yyyy',
                ignoreReadonly: true,
                locale: 'id'
            }).data("DateTimePicker").date(moment(date))
        }
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
            var today = new Date()
            initDTP("#tglsewaVeh", today)
            initDTP("#tglselesaiVeh", today)

            $(".datepick").on("click", function() {
                $(this).find(".dateTimePicker").focus()
            });

            $(".dateTimePicker").on("dp.change", function() {
                let mulai = $('#tglsewaVeh').data("DateTimePicker").date()
                let deadline = $('#tglselesaiVeh').data("DateTimePicker").date()
                if ($(this).attr("id") == "tglsewaVeh") {
                    if (deadline.isBefore(mulai)) {
                        $('#tglselesaiVeh').data("DateTimePicker").date(mulai)
                    } else return
                } else {
                    if (deadline.isBefore(mulai)) {
                        $('#tglsewaVeh').data("DateTimePicker").date(deadline)
                    } else return
                }
            });


            $('#vehicleId').select2({
                placeholder: 'Pilih Kendaraan',
                ajax: {
                    url: '{{ route('cariVehicle') }}',
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        console.log("ISI: " + data);
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    text: item.jenis + " - " + item.merk + " - " + item.noPol,
                                    id: item.id
                                }
                            })
                        };
                    },
                    cache: true
                }
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
