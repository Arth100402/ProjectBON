@extends('utama')
@section('title')
    Tambahkan Kendaraan Baru
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
    <form method="POST" action="{{ route('vehicle.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="exampleInputEmail1">Jenis Kendaraan</label>
            <select name="jenisveh" id="jenisVeh" class="selectpicker form-control border-0 mb-1 px-4 py-4 rounded shadow">
              @if (old('jenisveh') != null)
                <option value="{{ old('jenisveh') }}" selected hidden>{{ old('jenisveh') }}</option>
              @else
                <option value="" selected disabled hidden>Pilih Jenis Kendaraan</option>
              @endif
              <option value="Mobil Penumpang">Mobil Penumpang</option>
              <option value="Mobil Barang">Mobil Barang</option>
              <option value="Sepeda Motor">Sepeda Motor</option>
            </select>
            @error('jenisveh')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>

        <div class="form-group">
            <label for="exampleInputEmail1">Merk Kendaraan</label>
            <input type="text" name="merkveh" class="form-control" id="merkVeh" aria-describedby="nameHelp"
                placeholder="Masukkan Merk Kendaraan. Contoh: Kijang Innova Zenix" value="{{ old('merkveh') }}">
            @error('merkveh')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Tipe Kendaraan</label>
            <input type="text" name="tipeveh" class="form-control" id="tipeVeh" aria-describedby="nameHelp"
                placeholder="Masukkan Tipe Kendaraan. Contoh: V Gasoline Type" value="{{ old('tipeveh') }}">
                @error('tipeveh')
                <span class="text-danger">{{ $message }}</span>
                @enderror
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Warna Kendaraan</label>
            <input type="text" name="warnaveh" class="form-control" id="warnaveh" aria-describedby="nameHelp"
                placeholder="Masukkan Warna Kendaraan. Contoh: Hitam" value="{{ old('warnaveh') }}">
                @error('warnaveh')
                <span class="text-danger">{{ $message }}</span>
                @enderror
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Tahun Kendaraan</label>
            <input type="number" min="1900" max="3000" step="1" name="tahunveh" class="form-control"
                id="tahunVeh" aria-describedby="nameHelp" placeholder="Masukkan Tahun Kendaraan. Contoh: 2022"
                value="{{ old('tahunveh') }}">
                @error('tahunveh')
                <span class="text-danger">{{ $message }}</span>
                @enderror
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">Nomor Mesin Kendaraan</label>
            <input type="text" style="text-transform:uppercase" name="nomesinveh" class="form-control" id="nomesinVeh"
                aria-describedby="nameHelp" placeholder="Masukkan Nomor Mesin Kendaraan. Contoh: B1235689"
                value="{{ old('nomesinveh') }}">
                @error('nomesinveh')
                <span class="text-danger">{{ $message }}</span>
                @enderror
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Nomor Kerangka Kendaraan</label>
            <input type="text" style="text-transform:uppercase" name="nokerangkaveh" class="form-control"
                id="nokerangkaVeh" aria-describedby="nameHelp" placeholder="Masukkan Nomor Kerangka Kendaraan. Contoh: BX1234567"
                value="{{ old('nokerangkaveh') }}">
                @error('nokerangkaveh')
                <span class="text-danger">{{ $message }}</span>
                @enderror
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Plat Nomor Kendaraan</label>
            <input type="text" style="text-transform:uppercase" name="nopolveh" class="form-control" id="nopolVeh"
                aria-describedby="nameHelp" placeholder="Masukkan plat nomor kendaraan. Contoh: B 1234 AB"
                value="{{ old('nopolveh') }}">
                @error('nopolveh')
                <span class="text-danger">{{ $message }}</span>
                @enderror
        </div>
        <div class="form-group">
            <label for="lokasi">Lokasi Kendaraan</label><br>
            <select class="cariCB form-control p-3 lokasi" name="lokasi" id="lokasi"></select>
            @error('lokasi')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group required" style="min-width:25%; max-width:30%">
            <label for="tglpajakthnVeh">Tanggal Bayar Pajak Tahunan Kendaraan</label><br>
            <div class="input-group datepick">
                <input type="text" class="form-control dateTimePicker" name="tglpajakthnVeh" id="tglpajakthnVeh"
                    placeholder="Masukkan Tanggal Bayar Pajak Tahunan Kendaraan" required readonly>
                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </div>
            </div>
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-default btn-info" onclick="appendDate('day','#tglpajakthnVeh')">+1
                    Hari</button>
                <button type="button" class="btn btn-default btn-primary"
                    onclick="appendDate('month','#tglpajakthnVeh')">+1
                    Bulan</button>
                <button type="button" class="btn btn-default btn-info" onclick="appendDate('year','#tglpajakthnVeh')">+1
                    Tahun</button>
            </div>
            @error('tglpajakthnVeh')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group required" style="min-width:25%; max-width:30%">
            <label for="masastnkVeh">Masa Berlaku STNK Kendaraan</label><br>
            <div class="input-group datepick">
                <input type="text" class="form-control dateTimePicker" name="masastnkVeh" id="masastnkVeh"
                    placeholder="Masukkan Masa Berlaku STNK Kendaraan" required readonly>
                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </div>
            </div>
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-default btn-info" onclick="appendDate('day','#masastnkVeh')">+1
                    Hari</button>
                <button type="button" class="btn btn-default btn-primary"
                    onclick="appendDate('month','#masastnkVeh')">+1
                    Bulan</button>
                <button type="button" class="btn btn-default btn-info" onclick="appendDate('year','#masastnkVeh')">+1
                    Tahun</button>
            </div>
            @error('masastnkVeh')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">Atas Nama STNK Kendaraan</label>
            <input type="text" name="namastnkveh" class="form-control" id="namastnkVeh" aria-describedby="nameHelp"
                placeholder="Masukkan Atas Nama STNK Kendaraan. Contoh: John Doe"
                value="{{ old('namastnkveh') }}">
                @error('namastnkveh')
                <span class="text-danger">{{ $message }}</span>
                @enderror
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Posisi BPKB Kendaraan</label>
            <input type="text" name="posbpkbveh" class="form-control" id="posbpkbVeh" aria-describedby="nameHelp"
                placeholder="Masukkan Posisi BPKB Kendaraan. Contoh: John Doe"
                value="{{ old('posbpkbveh') }}">
                @error('posbpkbveh')
                <span class="text-danger">{{ $message }}</span>
                @enderror
        </div>

        <div class="form-group required" style="min-width:25%; max-width:30%">
            <label for="tglkirVeh">Tanggal KIR Kendaraan</label><br>
            <div class="input-group datepick">
                <input type="text" class="form-control dateTimePicker" name="tglkirVeh" id="tglkirVeh"
                    placeholder="Masukkan Tanggal KIR Kendaraan" required readonly>
                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </div>
            </div>

            <div class="btn-group" role="group">
                <button type="button" class="btn btn-default btn-info" onclick="appendDate('day','#tglkirVeh')">+1
                    Hari</button>
                <button type="button" class="btn btn-default btn-primary" onclick="appendDate('month','#tglkirVeh')">+1
                    Bulan</button>
                <button type="button" class="btn btn-default btn-info" onclick="appendDate('year','#tglkirVeh')">+1
                    Tahun</button>
            </div>
            @error('tglkirVeh')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>


        <div class="form-group">
            <label for="exampleInputEmail1">Kode GPS Kendaraan</label>
            <input type="text" name="kodegpsveh" class="form-control" id="kodegpsVeh" aria-describedby="nameHelp"
                placeholder="Masukkan Kode GPS Kendaraan. Contoh: GPS18273" value="{{ old('kodegpsveh') }}">
                @error('kodegpsveh')
                <span class="text-danger">{{ $message }}</span>
                @enderror
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Nama GPS Kendaraan</label>
            <input type="text" name="namagpsveh" class="form-control" id="namagpsVeh" aria-describedby="nameHelp"
                placeholder="Masukkan Nama GPS Kendaraan. Contoh: GPSInnova" value="{{ old('namagpsveh') }}">
                @error('namagpsveh')
                <span class="text-danger">{{ $message }}</span>
                @enderror
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Kode Barcode Kendaraan</label>
            <input type="text" name="kodebarcodeveh" class="form-control" id="kodebarcodeVeh"
                aria-describedby="nameHelp" placeholder="Masukkan Kode Barcode Kendaraan. Contoh: BC18273"
                value="{{ old('kodebarcodeveh') }}">
                @error('kodebarcodeveh')
                <span class="text-danger">{{ $message }}</span>
                @enderror
        </div>

        <div class="form-group required" style="min-width:25%; max-width:30%">
            <label for="tglgpsVeh">Tanggal Bayar GPS Kendaraan</label><br>
            <div class="input-group datepick">
                <input type="text" class="form-control dateTimePicker" name="tglgpsVeh" id="tglgpsVeh"
                    placeholder="Masukkan Tanggal Bayar GPS Kendaraan" required readonly>
                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </div>
            </div>
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-default btn-info" onclick="appendDate('day','#tglgpsVeh')">+1
                    Hari</button>
                <button type="button" class="btn btn-default btn-primary" onclick="appendDate('month','#tglgpsVeh')">+1
                    Bulan</button>
                <button type="button" class="btn btn-default btn-info" onclick="appendDate('year','#tglgpsVeh')">+1
                    Tahun</button>
            </div>
            @error('tglgpsVeh')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="file">Masukkan Gambar Kendaraan</label>
            <input type="file" name="images[]" id="images" class="form-control" multiple
            value="{{ old('images[]') }}">
            @error('images[]')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <div id="preview-container"></div>
        </div>

        <button type="submit" class="btn btn-success">Tambahkan</button>
        <a class="btn btn-danger" href="/vehicle">Batal Tambah</a>
    </form>
@endsection

@section('javascript')
    <script>
        $("#vehicle").addClass("active");
        $("#dataKendaraan").addClass("active");
    </script>
    <script type="text/javascript">
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
                    date.add(1, "days")
                    break;
                case "month":
                    date.add(1, "months")
                    break;
                case "year":
                    date.add(1, "years")
                    break;
                default:
                    console.log("Error! Error! Abort Ship!");
                    break;
            }
            $(id).data("DateTimePicker").date(date)
        }
        $(document).ready(function() {
            $('#lokasi').select2({
                placeholder: 'Pilih Lokasi',
                ajax: {
                    url: '/cariDropDown',
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        console.log("ISI: " + data);
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    text: item.nama,
                                    id: item.lid
                                }
                            })
                        };
                    },
                    cache: true
                }
            });

            $(".datepick").on("click", function() {
                $(this).find(".dateTimePicker").focus()
            });

            var today = new Date();
            initDTP("#tglpajakthnVeh", today)
            initDTP("#masastnkVeh", today)
            initDTP("#tglkirVeh", today)
            initDTP("#tglgpsVeh", today)
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
