@extends('utama')

@section('title')
    Pengajuan Perjalanan Dinas
@endsection

@section('isi')
    <style>
        .wrap {
            word-wrap: break-word !important;
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
    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif
    @if (Auth::user()->jabatan_id == 1)
        {{-- Staff --}}
        <div class="table-responsive" style="overflow: scroll">
            <table id="myTableStaff" class="table table-striped table-bordered" style="table-layout: fixed">
                <thead>
                    <tr>
                        <th>Tanggal Pengajuan</th>
                        <th>Pengaju</th>
                        <th>Project</th>
                        <th>Total Nominal</th>
                        <th>Status Kasir</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="modal fade" id="modalEditB" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog modal-wide">
                <div class="modal-content">
                    <div class="modal-body" id="modalContentB">
                        <!--loading animated gif can put here-->
                    </div>
                </div>
            </div>
        </div>
    @elseif(Auth::user()->jabatan_id != 1)
        <div class="table-responsive" style="overflow: scroll">
            <table id="myTable" class="table table-striped table-bordered" style="table-layout: fixed">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Departemen</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Total Biaya Perjalanan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="modal fade" id="modalEditA" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog modal-wide">
                <div class="modal-content">
                    <div class="modal-body" id="modalContent">
                        <!--loading animated gif can put here-->
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
@section('javascript')
    @if (Auth::user()->jabatan_id == 1)
        <script>
            function getDetail(id) {
                $.ajax({
                    type: 'POST',
                    url: '{{ route('home.getDetail') }}',
                    data: {
                        '_token': '<?php echo csrf_token(); ?>',
                        'id': id
                    },
                    success: function(data) {
                        $('#modalContentB').html(data.msg)
                    }
                });
            }
            $(document).ready(function() {
                var table = $('#myTableStaff').DataTable({
                    paging: false,
                    scrollCollapse: true,
                    scrollY: '445px',
                    columns: [{
                            data: "tglPengajuan"
                        },
                        {
                            data: "uname"
                        },
                        {
                            data: "pidOpti"
                        },
                        {
                            data: "total",
                            render: function(data, type, row, meta) {
                                // Format "total" as Rupiah
                                const rupiah = new Intl.NumberFormat('id-ID', {
                                    style: 'currency',
                                    currency: 'IDR'
                                }).format(data);
                                return rupiah;
                            }
                        },
                        {
                            data: "status"
                        },
                        {
                            data: null,
                            render: (data, type, row, meta) => {
                                return `<a class="btn btn-success" href="#modalEditB" data-toggle="modal"
                                onclick="getDetail(${data.id})"><i class="fa fa-info-circle"></i></a>`
                            }
                        },
                    ]
                });
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    async: false,
                    url: "{{ route('index') }}",
                    success: function(data) {
                        table.clear().draw()
                        table.rows.add(data["data"]).draw()
                    }
                });
            });
        </script>
    @elseif(Auth::user()->jabatan_id != 1)
        <script>
            function getDetail(id) {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('bon.getDetail') }}",
                    data: {
                        '_token': '<?php echo csrf_token(); ?>',
                        'id': id
                    },
                    success: function(data) {
                        $('#modalContent').html(data.msg)
                    }
                });
            }
            $(document).ready(function() {
                $.fn.dataTable.ext.type.order['status-order-pre'] = function(d) {
                    switch (d) {
                        case 'Menunggu':
                            return 1;
                        case 'Diterima':
                            return 2;
                        case 'Ditolak':
                            return 3;
                        default:
                            return 4;
                    }
                };
                var table = $('#myTable').DataTable({
                    paging: false,
                    scrollCollapse: true,
                    scrollY: '445px',
                    order: [
                        [4, 'asc'],
                        [1, 'desc']
                    ],
                    columnDefs: [{
                            searchable: true,
                            targets: [0, 1, 2, 3, 4]
                        },
                        {
                            className: "wrap",
                            targets: [0, 1, 2, 3, 4]
                        },
                        {
                            type: 'status-order',
                            targets: 4
                        },
                    ],
                    columns: [{
                            data: "name"

                        },
                        {
                            data: "dname",
                            width: "10%"
                        },
                        {
                            data: "tglPengajuan",
                            render: function(data, type, row) {
                                if (data !== null) {
                                    var date = new Date(data);
                                    var options = {
                                        weekday: 'long',
                                        year: 'numeric',
                                        month: 'long',
                                        day: 'numeric'
                                    };
                                    return date.toLocaleDateString('id-ID', options);
                                } else {
                                    return "Data tidak tersedia";
                                }
                            }
                        },
                        {
                            data: "total",
                            render: function(data, type, row) {
                                if (data !== null) {
                                    return new Intl.NumberFormat('id-ID', {
                                        style: 'currency',
                                        currency: 'IDR'
                                    }).format(data);
                                } else {
                                    return "Data tidak tersedia";
                                }
                            }
                        },
                        {
                            data: "status",
                            defaultContent: '<p>Menunggu</p>',
                            width: "5%"
                        },
                        {
                            data: null,
                            render: (data, type, row, meta) => {
                                return `<a class="btn btn-success" href="#modalEditA" data-toggle="modal"
                                onclick="getDetail(${data.id})"><i class="fa fa-info-circle"></i></a><br>`;
                            },
                            width: "4%"
                        },
                    ]
                });
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    async: false,
                    url: "{{ route('bon.jsonShowIndexAdmin') }}",
                    success: function(data) {
                        console.log(data);
                        table.clear().draw()
                        table.rows.add(data["data"]).draw()
                    },
                    error: function(error) {
                        console.log("Error: ");
                        console.log(error);
                    }
                });
            });
        </script>
    @endif
@endsection
