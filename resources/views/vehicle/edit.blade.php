@extends('utama')
@section('isi')
    <style>
        .cariCB {
            width: 100% !important;
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
    <h1>Ubah Data Kendaraan {{ $data['noPol'] }}</h1>
    <form action="{{ route('vehicle.update', $data['id']) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="inputNoPol">Plat Nomor Kendaraan</label>
            <input type="text" style="text-transform:uppercase" class="form-control" name="inputNoPol" id="inputNoPol"
                placeholder="Masukkan plat nomor kendaraan. Contoh: B 1234 AB" value="{{ $data['noPol'] }}">
            @error('noPol')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="lokasi">Lokasi Kendaraan</label><br>
            <select class="cariCB form-control p-3 lokasi" name="lokasi" id="lokasi">
                <option value="{{ $data['location_id'] }}" selected>{{ $data['nama'] }}</option>
            </select>
            @error('lokasi')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="warna">Warna Kendaraan</label>
            <input type="text" class="form-control" name="warna" id="warna"
                placeholder="Masukkan Warna Kendaraan. Contoh: Hitam" value="{{ $data['warna'] }}">
            @error('warna')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="jenis">Jenis Kendaraan</label><br>
            <select name="jenis" id="jenis" class="selectpicker form-control border-0 mb-1 px-4 py-4 rounded shadow">
                <option value="{{ $data['jenis'] }}" selected hidden>{{ $data['jenis'] }}</option>
                <option value="Mobil Penumpang">Mobil Penumpang</option>
                <option value="Mobil Barang">Mobil Barang</option>
                <option value="Sepeda Motor">Sepeda Motor</option>
            </select>
            @error('jenis')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group required" style="min-width:25%; max-width:30%">
            <label for="tglBayarPajak">Tanggal Bayar Pajak Tahunan Kendaraan</label><br>
            <div class="input-group datepick">
                <input type="text" class="form-control dateTimePicker" name="tglBayarPajak" id="tglBayarPajak"
                    placeholder="Masukkan Tanggal Bayar Pajak Tahunan Kendaraan" required readonly>
                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </div>
            </div>
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-default btn-info" onclick="appendDate('day','#tglBayarPajak')">+1
                    Hari</button>
                <button type="button" class="btn btn-default btn-primary" onclick="appendDate('month','#tglBayarPajak')">+1
                    Bulan</button>
                <button type="button" class="btn btn-default btn-info" onclick="appendDate('year','#tglBayarPajak')">+1
                    Tahun</button>
            </div>
            @error('tglBayarPajak')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>


        <div class="form-group required" style="min-width:25%; max-width:30%">
            <label for="masaBerlakuSTNK">Masa Berlaku STNK</label><br>
            <div class="input-group datepick">
                <input type="text" class="form-control dateTimePicker" name="masaBerlakuSTNK" id="masaBerlakuSTNK"
                    placeholder="Masukkan Tanggal Bayar Pajak Tahunan Kendaraan" required readonly>
                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </div>
            </div>
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-default btn-info" onclick="appendDate('day','#masaBerlakuSTNK')">+1
                    Hari</button>
                <button type="button" class="btn btn-default btn-primary"
                    onclick="appendDate('month','#masaBerlakuSTNK')">+1
                    Bulan</button>
                <button type="button" class="btn btn-default btn-info" onclick="appendDate('year','#masaBerlakuSTNK')">+1
                    Tahun</button>
            </div>
            @error('masaBerlakuSTNK')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="inputAtasNamaSTNK">Atas Nama STNK Kendaraan</label>
            <input type="text" class="form-control" name="inputAtasNamaSTNK" id="inputAtasNamaSTNK"
                placeholder="Masukkan Atas Nama STNK Kendaraan. Contoh: John Doe" value="{{ $data['atasNamaSTNK'] }}">
            @error('inputAtasNamaSTNK')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="posisiBPKB">Posisi BPKB Kendaraan</label>
            <input type="text" class="form-control" name="inputPosisiBPKB" id="inputPosisiBPKB"
                placeholder="Masukkan Posisi BPKB Kendaraan. Contoh: John Doe" value="{{ $data['posisiBPKB'] }}">
            @error('inputPosisiBPKB')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group required" style="min-width:25%; max-width:30%">
            <label for="tanggalKIR">Tanggal KIR</label><br>
            <div class="input-group datepick">
                <input type="text" class="form-control dateTimePicker" name="tanggalKIR" id="tanggalKIR"
                    placeholder="Masukkan Tanggal Bayar Pajak Tahunan Kendaraan" required readonly>
                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </div>
            </div>
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-default btn-info" onclick="appendDate('day','#tanggalKIR')">+1
                    Hari</button>
                <button type="button" class="btn btn-default btn-primary" onclick="appendDate('month','#tanggalKIR')">+1
                    Bulan</button>
                <button type="button" class="btn btn-default btn-info" onclick="appendDate('year','#tanggalKIR')">+1
                    Tahun</button>
            </div>
            @error('tanggalKIR')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="kodeGPS">Kode GPS Kendaraan</label>
            <input type="text" class="form-control" name="kodeGPS" id="kodeGPS"
                placeholder="Masukkan Kode GPS Kendaraan. Contoh: GPS18273" value="{{ $data['kodeGPS'] }}">
            @error('kodeGPS')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="namaGPS">Nama GPS Kendaraan</label>
            <input type="text" class="form-control" name="namaGPS" id="namaGPS"
                placeholder="Masukkan Nama GPS Kendaraan. Contoh: GPSInnova" value="{{ $data['namaGPS'] }}">
            @error('namaGPS')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group required" style="min-width:25%; max-width:30%">
            <label for="tglBayarGPS">Tanggal Bayar GPS</label><br>
            <div class="input-group datepick">
                <input type="text" class="form-control dateTimePicker" name="tglBayarGPS" id="tglBayarGPS"
                    placeholder="Masukkan Tanggal Bayar Pajak Tahunan Kendaraan" required readonly>
                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </div>
            </div>
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-default btn-info" onclick="appendDate('day','#tglBayarGPS')">+1
                    Hari</button>
                <button type="button" class="btn btn-default btn-primary"
                    onclick="appendDate('month','#tglBayarGPS')">+1
                    Bulan</button>
                <button type="button" class="btn btn-default btn-info" onclick="appendDate('year','#tglBayarGPS')">+1
                    Tahun</button>
            </div>
            @error('tglBayarGPS')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="kodeBarcode">Kode Barcode Kendaraan</label>
            <input type="text" class="form-control" name="kodeBarcode" id="kodeBarcode"
                placeholder="Masukkan Kode Barcode Kendaraan. Contoh: BC18273" value="{{ $data['kodeBarcode'] }}">
            @error('kodeBarcode')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="kodeBarcode">Gambar Saat Ini</label><br>
            @foreach (explode(',', $data['image']) as $item)
                <img src="{{ asset('images/' . $item) }}" style="max-height: 200px">
            @endforeach
            <br><br>
            <label for="sdad">Ubah Gambar</label>
            <input type="file" name="images[]" id="images" class="form-control" multiple>
            <input type="hidden" name="oldimage" value="{{ $data['image'] }}">
            @error('images[]')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            @error('oldimage')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="sdada">Gambar Baru</label>
            <div id="preview-container"></div>
        </div>
        <button type="submit" class="btn btn-primary">Ubah</button>
        <a class="btn btn-danger" href="/vehicle">Batal Ubah</a>
    </form>
@endsection
@section('javascript')
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
                    date.add(1, "day")
                    break;
                case "month":
                    date.add(1, "month")
                    break;
                case "year":
                    date.add(1, "year")
                    break;
                default:
                    console.log("Error! Error! Abort Ship!");
                    break;
            }
            $(id).data("DateTimePicker").date(date)
        }
        $(document).ready(function() {
            var data = {!! json_encode($data->toArray()) !!};
            initDTP("#tglBayarPajak", data["tanggalBayarPajakTahunan"]);
            initDTP("#masaBerlakuSTNK", data["masaBerlakuSTNK"]);
            initDTP("#tanggalKIR", data["tanggalKIR"]);
            initDTP("#tglBayarGPS", data["tglBayarGPS"]);

            $(".datepick").on("click", function() {
                $(this).find(".dateTimePicker").focus()
            });

            $('.lokasi').select2({
                placeholder: 'Pilih Lokasi',
                ajax: {
                    url: '{{ route('vehicleCari') }}',
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
            $("#vehicle").addClass("active");
            $("#dataKendaraan").addClass("active");
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
