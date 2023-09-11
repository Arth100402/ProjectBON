@extends('utama')
@section('title')
    Dashboard Teknisi, Welcome {{ Auth::user()->name }}
@endsection
@section('isi')
    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif
    <select name="project" id="Project" placeholder="Pilih Project">
        <option value="" disabled selected>Pilih Project</option>
        @foreach ($data as $d)
            <option value="{{ $d->id }},{{ $d->padid }}">{{ $d->namaOpti }} - {{ $d->padnama }}</option>
        @endforeach
    </select>

    <div id="data-container">
        <div class="container" style="width: 100%">
            <div class="row">
                <div class="col-md-3">
                    <div class="icon">
                        <i class="fa fa-clock-o"></i>
                        <p>Check In</p>
                        <button class="btn btn-primary" disabled>Check In</button>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="icon">
                        <i class="fa fa-book"></i>
                        <p>Laporan Tertulis</p>
                        <button class="btn btn-primary" disabled>Laporan Tulis</button>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="icon">
                        <i class="fa fa-camera"></i>
                        <p>Laporan Foto</p>
                        <a href="webcam" class="btn btn-primary" disabled>Laporan Foto</a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="icon">
                        <i class="fa fa-home"></i>
                        <p>Check Out</p>
                        <button class="btn btn-primary" disabled>Check Out</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalJadwal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="modalContainer">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title" id="modalTitle"></h4>
                </div>
                <div class="panel-body" id="modalContent"></div>
                <div class="modal-footer" id="modalFooter">
                    <button type="button" class="btn btn-danger" id="btnClose" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script>
        $(document).ready(function() {
            $("#Project").change(function() {
                var selectedValue = $(this).val();

                $.ajax({
                    url: '{{ route('user.selectedProject') }}',
                    type: 'POST',
                    data: {
                        '_token': '<?php echo csrf_token(); ?>',
                        'id': selectedValue
                    },
                    success: function(response) {
                        $('#data-container').html(response.data);
                    }
                });
            });
            $(document).on('click', "#checkin", function() {
                var selectedValue = $(this).val();
                $.ajax({
                    url: '{{ route('user.checkin') }}',
                    type: 'POST',
                    data: {
                        '_token': '<?php echo csrf_token(); ?>',
                        'id': selectedValue
                    },
                    success: function(response) {
                        $('#data-container').html(response.data);
                    }
                });
            });
            $(document).on('click', "#checkout", function() {
                var selectedValue = $(this).val();
                $.ajax({
                    url: '{{ route('user.checkout') }}',
                    type: 'POST',
                    data: {
                        '_token': '<?php echo csrf_token(); ?>',
                        'id': selectedValue
                    },
                    success: function(response) {
                        $('#data-container').html(response.data);
                    }
                });
            });
        });

        function loadFormCreate($pad) {
            $.ajax({
                type: "POST",
                url: '{{ route('jadwal.ubah') }}',
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'pad': $pad
                },
                success: function(response) {
                    const data = response.value
                    $("#modalContainer").html(`
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title" id="modalTitle">Edit Aktifitas Hari Ini</h4>
                        </div>
                        <form action="/calendar/event/insert/${data.pad}" method="POST" id="formActivityCreate">
                            @csrf
                            <div class="panel-body" id="modalContent">

                                ` + response.data + `
                            </div>
                            <div class="modal-footer" id="modalFooter">
                                <button type="submit" class="btn btn-primary">Perbarui</button>
                                <a class="btn btn-danger" data-dismiss="modal">Batal</a>
                            </div>
                        </form
                    `);
                }
            });
        }

        $("#modalJadwal").on("shown.bs.modal", function(e) {
            $("#modalJadwal #deviceSelect").select2({
                placeholder: 'Pilih Device',
                dropdownParent: $("#modalJadwal"),
                allowClear: true,
                ajax: {
                    url: '{{ route('cariDevice') }}',
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    text: item.nama,
                                    id: item.id,
                                    jenis: item.jenis,
                                    merk: item.merk,
                                    tipe: item.tipe
                                }
                            })
                        };
                    },
                    cache: true
                }
            })
        });

        $(document).on("click", "#addDevice", function(e) {
            console.log("test");
            data = $('#deviceSelect').select2('data')[0];
            var selectedName = $('#deviceSelect:selected').text();
            $('#table-container').append(`
                    <tr>
                        <td>${data.text}<input type="text" name="iddevice[]" value=${data.id} hidden></td>
                        <td>${data.jenis}</td>
                        <td>${data.tipe}</td>
                        <td>${$('#status').val()} <input type="text" name="statuss[]" value=${$('#status').val()} hidden></td>
                        <td><input type="button" class="btn btn-primary" value="Delete Row" onclick="deleteRow(this)"></td>
                    </tr>
                `)
            $("#deviceSelect").empty();
        });

        function deleteRow(button) {
            var row = button.parentNode.parentNode;
            row.parentNode.removeChild(row);
        }
    </script>
    @if (Auth::user()->jabatan_id == 3)
        <script>
            $("#project").addClass("active");
            $("#dashboardTeknisi").addClass("active");
        </script>
    @else
        <script>
            $("#dashboardTeknisi").addClass("active");
        </script>
    @endif
@endsection
