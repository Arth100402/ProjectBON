@extends('utama')
@section('title')
    Service Kendaraan
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
    <form method="POST" action="{{ route('vehicle.serviceMaintenance') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="exampleInputEmail1">Teknisi</label><br>
            <input type="text" class="form-control" value="{{ Auth::user()->name }}" disabled>
            <input type="hidden" name="userid" class="form-control" id="userId" value="{{ Auth::user()->id }}">
        </div>

        <div class="form-group required" style="min-width:25%; max-width:30%">
            <label for="tglserviceVeh">Tanggal Service</label><br>
            <div class="input-group datepick">
                <input type="text" class="form-control dateTimePicker" name="tglserviceVeh" id="tglserviceVeh"
                    placeholder="Masukkan Tanggal Service" required readonly>
                <div class="input-group-addon btn">
                    <span class="glyphicon glyphicon-calendar"></span>
                </div>
            </div>
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-default btn-info" onclick="appendDate('day','#tglserviceVeh')">+1
                    Hari</button>
                <button type="button" class="btn btn-default btn-primary" onclick="appendDate('3day','#tglserviceVeh')">+3
                    Hari</button>
                <button type="button" class="btn btn-default btn-info" onclick="appendDate('week','#tglserviceVeh')">+1
                    Minggu</button>
            </div>
        </div>
        <div class="form-group">
            <label for="exampleForm">Pilih Kendaraan</label>
            <select class="form-control" name="vehicleid" id="vehicleId">
            </select>
            @error('vehicleid')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Keluhan Kendaraan</label><br>
            <input type="text" name="keluhanveh" class="form-control" id="keluhanVeh" aria-describedby="nameHelp"
                placeholder="Masukkan Keluhan Kendaraan. Contoh: Mesin mati total" value="{{ old('keluhanveh') }}">
                @error('keluhanveh')
                <span class="text-danger">{{ $message }}</span>
                @enderror
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Harga Jasa Service</label><br>
            <input type="number" min="0" name="serveh" class="form-control" id="serVeh" aria-describedby="nameHelp"
                placeholder="Masukkan Harga Jasa Service. Contoh: 500000" value="{{ old('serveh') }}">
                @error('serveh')
                <span class="text-danger">{{ $message }}</span>
                @enderror
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">KM</label><br>
            <input type="number" min="1" name="kmveh" class="form-control" id="kmVeh"
                aria-describedby="nameHelp" placeholder="Masukkan KM Kendaraan Ketika Service. Contoh: 20022408"
                value="{{ old('kmveh') }}">
                @error('kmveh')
                <span class="text-danger">{{ $message }}</span>
                @enderror
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Total Biaya</label><br>
            <input type="number" min="0" name="totalbiaya" class="form-control" id="totalBiaya" aria-describedby="nameHelp"
                readonly placeholder="Total biaya otomatis terisi dari harga service + spare part"
                value="{{ old('totalbiaya') }}">
        </div>
        <div class="form-group">
            <label for="anggotaProj">Bengkel Service</label><br>
            <select class="cariCB form-control p-3 bengkel" name="bengkel" id="bengkel"></select>
            @error('bengkel')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="anggotaProj">Sparepart yang Diganti</label><br>
            <select class="cariCB form-control p-3 sparePart" name="sparepart" id="sparePart"></select>
            @error('sparepart')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Harga Sparepart</label><br>
            <input type="number" min="0" name="hargasparepart" class="form-control" id="hargasparePart" aria-describedby="nameHelp"
                placeholder="Masukkan Harga Sparepart. Contoh: 150000"><br>
            <button type="button" class="btn btn-primary addSparepart">Tambah Sparepart</button>
            @error('hargasparepart')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <table id="myTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Sparepart</th>
                    <th>Harga</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="table-container">

            </tbody>
        </table>
        <div class="form-group">
            <label for="sadaw">Masukkan Gambar Nota</label>
            <input type="file" name="images[]" id="images" class="form-control" multiple>
        </div>
        <div class="form-group">
            <div id="preview-container"></div>
        </div>
        <button type="submit" class="btn btn-success">Submit</button>
        <a class="btn btn-danger" href="/customvehicle/techService">Batal</a>
    </form>
@endsection

@section('javascript')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.sparePart').select2();
            $('.addSparepart').prop('disabled', true);
            $('.sparePart').on('change', function() {
                if ($(this).val()) {
                    $('.addSparepart').prop('disabled', false);
                } else {
                    $('.addSparepart').prop('disabled', true);
                }
            });
        });
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

        function deleteRow(button) {
            var row = button.parentNode.parentNode;
            row.parentNode.removeChild(row);
            if ($('#serVeh').val()) {
                var hargaServis = parseInt($('#serVeh').val());
                var hargaTotalSparePart = 0;
                var tableElem = window.document.getElementById('myTable');
                var tableBody = tableElem.getElementsByTagName("tbody").item(0);
                var rows = tableBody.rows;
                for (var i = 0; i < rows.length; i++) {
                    var cell = rows[i].cells[1];
                    var cellParse = parseInt(cell.textContent);
                    hargaTotalSparePart += cellParse;
                }
                console.log(hargaTotalSparePart);
                console.log(hargaServis);
                document.getElementById("totalBiaya").value = hargaTotalSparePart + hargaServis;
            } else {
                var hargaServis = parseInt($('#serVeh').val());
                var hargaTotalSparePart = 0;
                var tableElem = window.document.getElementById('myTable');
                var tableBody = tableElem.getElementsByTagName("tbody").item(0);
                var rows = tableBody.rows;
                for (var i = 0; i < rows.length; i++) {
                    var cell = rows[i].cells[1];
                    var cellParse = parseInt(cell.textContent);
                    hargaTotalSparePart += cellParse;
                }
                console.log(hargaTotalSparePart);
                console.log(hargaServis);
                document.getElementById("totalBiaya").value = hargaTotalSparePart;
            }
        }


        $(document).ready(function() {
            $("#vehicle").addClass("active");
            $("#serviceTeknisi").addClass("active");

            var today = new Date()
            initDTP("#tglserviceVeh", today)

            $(".datepick").on("click", function() {
                $(this).find(".dateTimePicker").focus()
            });
            $('.sparePart').select2({
                placeholder: 'Pilih Sparepart',
                ajax: {
                    url: '{{ route('vehicle.cariSparepart') }}',
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        var datas = data.data
                        console.log(datas);
                        return {
                            results: $.map(datas, function(item) {
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
            $('.bengkel').select2({
                placeholder: 'Pilih Bengkel',
                ajax: {
                    url: '{{ route('vehicle.cariBengkel') }}',
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        var datas = data.data
                        console.log(datas);
                        return {
                            results: $.map(datas, function(item) {
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
        $(document).on("click", ".addSparepart", function(e) {
            data = $('#sparePart').select2('data')[0];
            var selectedName = $('#sparePart:selected').text();
            var price = $('#hargasparePart').val();
            if (price != null && price != '') {
                $('#table-container').append(`
                    <tr>
                        <td>${data.text}<input type="text" name="idsparepart[]" value=${data.id} hidden><input type="number" name="price[]" value=${price} hidden></td>
                        <td>${price}</td>
                        <td><input type="button" class="btn btn-primary" value="Delete Row" onclick="deleteRow(this)"></td>
                    </tr>
                `)
                $("#sparePart").empty();
                $('.addSparepart').prop('disabled', true);
                document.getElementById("hargasparePart").value = "";
            } else {
                alert("Harga sparepart belum terisi");
            }
            if ($('#serVeh').val()) {
                var hargaServis = parseInt($('#serVeh').val());
                var hargaTotalSparePart = 0;
                var tableElem = window.document.getElementById('myTable');
                var tableBody = tableElem.getElementsByTagName("tbody").item(0);
                var rows = tableBody.rows;
                for (var i = 0; i < rows.length; i++) {
                    var cell = rows[i].cells[1];
                    var cellParse = parseInt(cell.textContent);
                    hargaTotalSparePart += cellParse;
                }
                console.log(hargaTotalSparePart);
                console.log(hargaServis);
                document.getElementById("totalBiaya").value = hargaTotalSparePart + hargaServis;
            } else {
                var hargaServis = parseInt($('#serVeh').val());
                var hargaTotalSparePart = 0;
                var tableElem = window.document.getElementById('myTable');
                var tableBody = tableElem.getElementsByTagName("tbody").item(0);
                var rows = tableBody.rows;
                for (var i = 0; i < rows.length; i++) {
                    var cell = rows[i].cells[1];
                    var cellParse = parseInt(cell.textContent);
                    hargaTotalSparePart += cellParse;
                }
                console.log(hargaTotalSparePart);
                console.log(hargaServis);
                document.getElementById("totalBiaya").value = hargaTotalSparePart;
            }
        });

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
