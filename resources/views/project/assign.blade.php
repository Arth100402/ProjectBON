@extends('utama')
@section('title')
    Project Assignment
@endsection
@section('css')
    <style>
        .parpel,
        .parpel:visited,
        .parpel:focus {
            background-color: rgb(126, 0, 222);
            color: white
        }

        .parpel:hover,
        .parpel:active {
            background-color: rgb(83, 0, 146);
            color: white
        }

        .text-wrap {
            word-wrap: break-word !important;
            word-break: break-all !important;
        }

        .geomap {
            height: 300px;
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
    <div class="btn-group">
        <button type="button" class="btn btn-info" disabled id="ahay">K3</button>
        <button type="button" class="btn btn-primary" disabled>Survey</button>
        <button type="button" class="btn btn-danger" disabled>Helpdesk</button>
        <button type="button" class="btn btn-warning" disabled>Teknisi</button>
        <button type="button" class="btn btn-success" disabled>Leader</button>
    </div> <br> <br><br>

    <div class="table-responsive" style="overflow: scroll">
        <button class="btn btn-secondary btn-block" id="resetOrderOption">Default Option</button>
        <br>
        <table id="myTable" class="table table-striped table-bordered" style="table-layout: fixed">
        </table>
    </div>

    <div class="modal fade" id="modalShowPhoto" tabindex="-1" role="basic" aria-hidden="true">
        <div class="modal-dialog modal-wide">
            <div class="modal-content">
                <div class="modal-body" id="modalContent">
                    <!--loading animated gif can put here-->
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script>
        $("#project").addClass("active");
        $("#projectAssign").addClass("active");
        $(document).ready(function() {
            $("#myTable").popover({
                selector: '[data-toggle="popover"]',
                trigger: 'manual',
            });
            const role = ["btn-link", "btn-info", "btn-primary", "btn-danger", "btn-warning", "btn-success"]
            $("#myTable").on("click", ".btnTampilFoto", function() {
                const x = $(this).attr("data-x")
                $.ajax({
                    type: "POST",
                    url: "{{ route('showPhoto') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "padId": x
                    },
                    success: function(response) {
                        $("#modalContent").html(response.content);
                        const data = response.data
                        if (navigator.geolocation) {
                            data.forEach(e => {
                                var latitude = e.latitude.split(",")[0];
                                var longitude = e.longitude.split(",")[0];
                                var container = L.DomUtil.get('map-' + e.users_id);
                                if (container != null) {
                                    container._leaflet_id = null;
                                }
                                var map = L.map('map-' + e.users_id).setView([latitude,
                                        longitude
                                    ],
                                    18);
                                L.tileLayer(
                                    'https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                        maxZoom: 20,
                                        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                                    }).addTo(map);
                                var marker = L.marker([latitude, longitude]).addTo(map);
                            });
                        } else {
                            console.log('Geolocation is not supported by this browser.');
                        }
                    },
                    error: function(err) {
                        console.log(err);
                    }
                });
            });

            $("#modalContent").on("click", ".carousel-change-btn", function() {
                const userId = $(this).attr("href").split("-")[1]
                setTimeout(() => {
                    const [lat, long] = $(this).parent().find("li.active").attr("data-latlong")
                        .split(",")
                    var container = L.DomUtil.get('map-' + userId);
                    if (container != null) {
                        container._leaflet_id = null;
                    }
                    var map = L.map('map-' + userId).setView([lat,
                            long
                        ],
                        18);
                    L.tileLayer(
                        'https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            maxZoom: 20,
                            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                        }).addTo(map);
                    var marker = L.marker([lat, long]).addTo(map);
                }, 1);
                console.log("Loading...");
            });

            // Initialized Data Table
            $.ajax({
                type: "POST",
                url: "{{ route('project.loadAssign') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: function(response) {
                    const {
                        karyawan,
                        data,
                        roles
                    } = response
                    const headerTop = `
                        <thead>
                            <tr>
                                <th>Tanggal Aktifitas</th>
                                <th style="min-width:200px">Nama Opti</th>
                                <th>Posisi</th>
                                <th>Status Projek</th>
                                <th>Action</th>`
                    let headerContent = karyawan.reduce((acc, e) => {
                        return acc +
                            `<th class="rotated-text"><div><span>${e.name}</span></div></th>`
                    }, '')
                    const headerBottom = `</tr></thead>`
                    $("#myTable").html(headerTop + headerContent + headerBottom);

                    let allRow = data
                        .filter(e => moment(e.tglAktifitas, "YYYY-MM-DD").isSameOrAfter(moment(),
                            "day"))
                        .map((e, index) => {
                            let s = Object.entries(e)
                            s[0] = ["tglAktifitas", moment(e.tglAktifitas).format(
                                "YYYY-MM-DD, dddd")]
                            let array = Object.values(Object.fromEntries(s)).slice(0, -1)
                            let temp = roles[e.namaOpti]
                            let rolesPerElement = temp ? temp[e.tglAktifitas] : null
                            let kar = karyawan.map(person => {
                                let temp2 = null
                                if (rolesPerElement) {
                                    rolesPerElement.forEach(item => {
                                        if (item.users_id == person.id) {
                                            temp2 = {
                                                "padId": item.padId,
                                                "id": person.id,
                                                "name": person.name,
                                                "roles_id": item.roles_id
                                            }
                                            return
                                        }
                                    })
                                }
                                let btnId = temp2 ?
                                    `${temp2.padId}-${temp2.id}-${temp2.roles_id}` :
                                    `${e.padId}-${person.id}-a`
                                let btnClass = temp2 ?
                                    `btn ${role[temp2.roles_id]} btn-block` :
                                    `btn btn-link btn-block`
                                return `<button id='${btnId}' class="${btnClass}" data-toggle="popover" data-html="true">${person.name[0]}</button>`
                            })
                            const actionBtn =
                                `<a class="btn btn-block parpel btnTampilFoto" data-toggle="modal" href="#modalShowPhoto" data-x="${e.padId}"><i class="fa fa-image"></i></a>`
                            return [...array, actionBtn, ...kar]
                        })
                    let dttbl = $("#myTable").DataTable({
                        paging: false,
                        scrollCollapse: true,
                        scrollY: '445px',
                        scrollX: '445px',
                        rowGroup: {
                            dataSrc: 0
                        },
                        columnDefs: [{
                                visible: false,
                                targets: 0
                            },
                            {
                                className: "text-wrap",
                                targets: [1]
                            }
                        ]
                    }).columns.adjust();
                    allRow.forEach(e => dttbl.row.add(e))
                    dttbl.draw()
                }
            });

            // Refreshing
            // setInterval(() => {
            //     $(".btn-block").click();
            // }, 0);

            $("#myTable").on({
                click: function() {
                    let [padId, userId, roleId] = $(this).attr("id").split("-")
                    const lgth = $(this).parent().parent().find("button.btn-success").length
                    if (roleId == role.length - 1 || (lgth == 1 && roleId == role.length - 2)) {
                        $(this).removeClass(role[roleId])
                        roleId = 0
                        $(this).addClass(role[roleId])
                        $(this).attr("id", padId + "-" + userId + "-a")
                    } else if (isNaN(roleId)) {
                        $(this).removeClass(role[0])
                        roleId = 1
                        $(this).addClass(role[roleId])
                        $(this).attr("id", padId + "-" + userId + "-" + roleId)
                    } else {
                        $(this).removeClass(role[roleId])
                        roleId = (Number(roleId) + 1).toString()
                        $(this).attr("id", padId + "-" + userId + "-" + roleId)
                        $(this).addClass(role[roleId])
                    }
                    changeRole(padId, userId, roleId)
                },
                mouseenter: function() {
                    let [padId, userId, roleId] = $(this).attr("id").split("-")
                    const button = $(this)
                    $.ajax({
                        type: "POST",
                        url: "{{ route('showWaktuHover') }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "padId": padId,
                            "userId": userId,
                            "roleId": roleId
                        },
                        async: false,
                        success: function(response) {
                            const data = response.data
                            if (response.status != "OK") return
                            $(button).attr("title", "Jam Kerja")
                            $(button).attr("data-placement", "bottom")
                            if (button.parent().parent().is(":last-child")) $(button)
                                .attr(
                                    "data-placement", "top")
                            $(button).attr("data-content",
                                `Waktu Tiba: ${(data["waktuTiba"])?data["waktuTiba"]:"--:--:--"}<br> Waktu Selesai: ${(data["waktuSelesai"])?data["waktuSelesai"]:"--:--:--"}`
                            )
                            $(button).popover('show')
                        },
                        error: function(err) {
                            console.log("ERR: ");
                            console.log(err);
                        }
                    });
                },
                mouseleave: function() {
                    $(this).popover('hide')
                }
            }, "button[data-toggle='popover']");
            $("#resetOrderOption").on("click", function() {
                let dttbl = $("#myTable").DataTable()
                dttbl.order([
                    [0, "asc"]
                ]).draw()
            });
        });
        const changeRole = (padId, userId, newRoleId) => {
            $.ajax({
                type: "POST",
                url: "{{ route('changeRole') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "padId": padId,
                    "userId": userId,
                    "roleId": newRoleId
                }
            });
        }
    </script>
@endsection
