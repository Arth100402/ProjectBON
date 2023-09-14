@extends('utama')

@section('title')
    Pengajuan Perjalanan Dinas
@endsection

@section('isi')
    <style>
        .wrap {
            word-wrap: break-word !important;
        }
        .setAlign{
            text-align: right;
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
    <div>
        <h3>Pengajuan saya</h3>
    </div>
    <div class="table-responsive" style="overflow: scroll">
        <table id="myTableSelf" class="table table-striped table-bordered" style="table-layout: fixed">
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
    <div>
        <h3>Terima Tolak Pengajuan</h3>
    </div>
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
                <div class="modal-body" id="modalContentA">
                    <!--loading animated gif can put here-->
                </div>
            </div>
        </div>
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
@endsection
@section('javascript')
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
                    $('#modalContentA').html(data.msg);
                },
                error: function(err) {
                    console.log(err);
                }
            });
        }
        function getDetailSelf() {
            $.ajax({
                type: "GET",
                dataType: "json",
                async: false,
                url: "{{ route('bon.getDetailSelf') }}",
                success: function(data) {
                    $('#modalContentB').html(data.msg);
                },
                error: function(error) {
                    console.log("Error: ");
                    console.log(error);
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
                info:false,
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
                            return `<a class="btn btn-info" href="#modalEditA" data-toggle="modal"
                                onclick="getDetail(${data.id})"><i class="fa fa-info-circle"></i></a>
                                <br>
                                <a class="btn btn-success" href=""><i class="fa fa-check-circle"></i></a>
                                <br>
                                <a class="btn btn-danger" href="#modalEditC" data-toggle="modal" onclick=""><i class="fa fa-times"></i></a>`;
                        },
                        width: "5%"
                    }
                ]
            });
            $.ajax({
                type: "GET",
                dataType: "json",
                async: false,
                url: "{{ route('bon.jsonShowIndexAdmin') }}",
                success: function(data) {
                    table.clear().draw()
                    table.rows.add(data["data"]).draw()
                },
                error: function(error) {
                    console.log("Error: ");
                    console.log(error);
                }
            });

            var table = $('#myTableSelf').DataTable({
                info:false,
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
                            return `<a class="btn btn-success" href="#modalEditB" data-toggle="modal" onclick="getDetailSelf()">
                                <i class="fa fa-info-circle"></i>
                                </a>
                                <br>`;
                        },
                        width: "5%"
                    }
                ]
            });
            $.ajax({
                type: "GET",
                dataType: "json",
                async: false,
                url: "{{ route('bon.jsonShowIndexSelf') }}",
                success: function(data) {
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
@endsection
