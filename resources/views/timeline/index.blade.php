@extends('utama')
@section('title')
    Timeline Pekerjaan
@endsection
@section('css')
    <style>
        .menunggu g rect {
            fill: #6C757D !important;
        }

        .proses g rect {
            fill: #1CE8C9 !important;
        }

        .ditunda g rect {
            fill: #E80404 !important;
        }

        .selesai g rect {

            fill: #63E81C !important;
        }
    </style>
@endsection
@section('isi')
    <div id="timeline" class="card" style="overflow: scroll; height:50vh"></div>
    <div class="mx-auto mt-3 btn-group" role="group">
        <button type="button" onclick="changeView('Quarter Day')" class="btn btn-sm btn-light">Quarter Day</button>
        <button type="button" onclick="changeView('Half Day')" class="btn btn-sm btn-light">Half Day</button>
        <button type="button" class="btn btn-sm btn-light" onclick="changeView('Day')">Day</button>
        <button type="button" class="btn btn-sm btn-light active" onclick="changeView('Week')">Week</button>
        <button type="button" class="btn btn-sm btn-light" onclick="changeView('Month')">Month</button>
        <button type="button" class="btn btn-sm btn-light" onclick="changeView('Year')">Year</button>
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
        var options = {
            header_height: 50,
            column_width: 30,
            step: 25,
            view_modes: ['Quarter Day', 'Half Day', 'Day', 'Week', 'Month'],
            bar_height: 20,
            bar_corner_radius: 3,
            arrow_curve: 5,
            padding: 18,
            view_mode: 'Week',
            date_format: 'YYYY-MM-DD',
            language: 'en', // or 'es', 'it', 'ru', 'ptBr', 'fr', 'tr', 'zh', 'de', 'hu'
            custom_popup_html: null
        }


        async function loadGanttChart() {
            var response = await $.ajax({
                type: "POST",
                url: "{{ route('timeline.load') }}",
                data: {
                    '_token': '<?php echo csrf_token(); ?>'
                },
            });
            var data = response.timeline
            console.log(data);
            var allData = [];
            data.forEach(element => {
                var temp = {
                    id: element["id"],
                    name: element["namaOpti"],
                    start: element["tglRealisasi"],
                    end: element["deadline"],
                    progress: 100,
                    custom_class: element["status"].toLowerCase(),
                }
                allData.push(temp)
            });
            return new Gantt("#timeline", allData, options)
        }

        loadGanttChart()

        async function changeView(type) {
            var gantt = await loadGanttChart()
            gantt.change_view_mode(type)
        }

        $("#jadwal").addClass("active");
        $("#timeline-chart").addClass("active");
    </script>
@endsection
