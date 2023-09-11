@extends('utama')
@section('title')
    Project Calendar
@endsection
@section('css')
    <style>
        .wrap {
            word-wrap: break-word !important;
        }
    </style>
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
    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif
    <div id="calendar"></div>
    <div class="modal fade" id="modalJadwal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
        // Calendar
        var datas = [{
            title: "Project A",
            start: "2023-08-11 10:10:10",
            end: "2023-08-11 13:10:10"
        }];
        var calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
            initialView: 'dayGridMonth',
            headerToolbar: {
                start: 'today prev,next', // will normally be on the left. if RTL, will be on the right
                center: 'title',
                end: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth' // will normally be on the right. if RTL, will be on the left
            },
            events: (info, success, failure) => {
                $.ajax({
                    type: "POST",
                    url: "{{ route('jadwal.loadevent') }}",
                    data: {
                        '_token': '<?php echo csrf_token(); ?>'
                    },
                    success: function(response) {
                        var data = response['data']
                        console.log(data);
                        datas = [];
                        data.forEach(element => {
                            datas.push((element["waktuTiba"] == null ? {
                                title: element["namaAktifitas"],
                                allDay: true,
                                start: element["tglAktifitas"],
                                end: element["tglAktifitas"],
                                backgroundColor: "red",
                                extendedProps: {
                                    user_id: element["users_id"],
                                    padId: element["padId"]
                                }
                            } : (element["waktuSelesai"] == null ? {
                                title: element["namaAktifitas"],
                                start: element["tglAktifitas"] + " " +
                                    element[
                                        "waktuTiba"],
                                end: element["tglAktifitas"] + " 00:00:00",
                                backgroundColor: "orange",
                                extendedProps: {
                                    user_id: element["users_id"],
                                    padId: element["padId"]
                                }
                            } : {
                                title: element["namaAktifitas"],
                                start: element["tglAktifitas"] + " " +
                                    element[
                                        "waktuTiba"],
                                end: element["tglAktifitas"] + " " +
                                    element[
                                        "waktuSelesai"],
                                extendedProps: {
                                    user_id: element["users_id"],
                                    padId: element["padId"]
                                }
                            })));
                        });
                        success(datas)
                    },
                    error: function(err) {
                        console.log(err);
                    }
                });
            },
            eventClick: (info) => {
                const userID = info.event.extendedProps.user_id;
                const padId = info.event.extendedProps.padId;
                $.ajax({
                    type: 'POST',
                    url: '{{ route('jadwal.detailAct') }}',
                    data: {
                        '_token': '<?php echo csrf_token(); ?>',
                        'idUser': userID,
                        'idPad': padId
                    },
                    success: function(response) {
                        $("#modalContainer").html(response.data);
                        $("#modalJadwal").modal();
                    }
                });
            }
        });
        calendar.render();
    </script>
    <script>
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
    </script>
    <script>
        function deleteRow(button) {
            var row = button.parentNode.parentNode;
            row.parentNode.removeChild(row);
        }

        $("#jadwal").addClass("active");
        $("#calendar-page").addClass("active");
    </script>
@endsection
