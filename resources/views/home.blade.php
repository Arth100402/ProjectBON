@extends('utama')

@section('title')
    Bon Sementara
@endsection

@section('isi')
    <style>
        .wrap {
            word-wrap: break-word !important;
        }

        .setAlign {
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
    {{-- Kasir --}}
    @if (Auth::user()->jabatan_id == 8)
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i>Verifikasi Pencairan Bon
                </div>
                <div class="tools">
                    <a href="javascript:;" class="collapse"></a>
                </div>
            </div>
            <div class="portlet-body" style="display: block">
                <div class="table-responsive" style="overflow: scroll">
                    <table id="myTableCair" class="table table-striped table-bordered" style="table-layout: fixed">
                        <thead>
                            <tr>
                                <th>Nama Pengaju</th>
                                <th>Departemen</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Total Biaya Perjalanan</th>
                                <th>Nama Finance Manager</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i>Riwayat Penerimaan dan Penolakan Saya
                </div>
                <div class="tools">
                    <a href="javascript:;" class="collapse"></a>
                </div>
            </div>
            <div class="portlet-body" style="display: block">
                <div class="table-responsive" style="overflow: scroll">
                    <table id="myTableAccDec" class="table table-striped table-bordered" style="table-layout: fixed">
                        <thead>
                            <tr>
                                <th>Tanggal Pengajuan</th>
                                <th>Nama Pengaju</th>
                                <th>Nominal Yang Diajukan</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                                <th>Diterima/Ditolak Pada</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        {{-- FM --}}
    @elseif (Auth::user()->jabatan_id == 3 && Auth::user()->departement_id == 8)
        <div class="topdiv">
            <a href="{{ route('create') }}" class="btn btn-success"><i class="fa fa-plus-square-o"></i></a>
        </div>
        <h3>Pengajuan saya: </h3>
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
            <table id="myTablefm" class="table table-striped table-bordered" style="table-layout: fixed">
                <thead>
                    <tr>
                        <th>Bons ID</th>
                        <th>Nama Pengaju</th>
                        <th>Departemen</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Total Biaya Diajukan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div>
            <h3>Riwayat Penerimaan dan Penolakan Saya</h3>
        </div>
        <div class="table-responsive" style="overflow: scroll">
            <table id="myTableAccDec" class="table table-striped table-bordered" style="table-layout: fixed">
                <thead>
                    <tr>
                        <th>Tanggal Pengajuan</th>
                        <th>Nama Pengaju</th>
                        <th>Nominal Yang Diajukan</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                        <th>Diterima/Ditolak Pada</th>
                    </tr>
                </thead>
            </table>
        </div>
    @else
        <div class="topdiv">
            <a href="{{ route('create') }}" class="btn btn-success"><i class="fa fa-plus-square-o"></i></a>
        </div><br>
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i>Pengajuan saya
                </div>
                <div class="tools">
                    <a href="javascript:;" class="collapse"></a>
                </div>
            </div>
            <div class="portlet-body" style="display: block">
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
            </div>
        </div>

        @if (Auth::user()->jabatan_id != 1)
            <div class="portlet">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i>Terima Tolak Pengajuan
                    </div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse"></a>
                    </div>
                </div>
                <div class="portlet-body" style="display: block">
                    <div class="table-responsive" style="overflow: scroll">
                        <table id="myTable" class="table table-striped table-bordered" style="table-layout: fixed">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Jabatan</th>
                                    <th>Departemen</th>
                                    <th>Tanggal Pengajuan</th>
                                    <th>Total Biaya Perjalanan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <div class="portlet">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i>Riwayat Penerimaan dan Penolakan Saya
                    </div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse"></a>
                    </div>
                </div>
                <div class="portlet-body" style="display: block">
                    <div class="table-responsive" style="overflow: scroll">
                        <table id="myTableAccDec" class="table table-striped table-bordered" style="table-layout: fixed">
                            <thead>
                                <tr>
                                    <th>Tanggal Pengajuan</th>
                                    <th>Nama Pengaju</th>
                                    <th>Nominal Yang Diajukan</th>
                                    <th>Status</th>
                                    <th>Keterangan</th>
                                    <th>Diterima/Ditolak Pada</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    @endif
    {{-- Modals --}}
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
    <div class="modal fade" id="modalEditC" tabindex="-1" role="basic" aria-hidden="true">
        <div class="modal-dialog modal-wide">
            <div class="modal-content">
                <div class="modal-body" id="modalContentC">
                    <form id="kirimTolak" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="nama">Alasan Tolak</label>
                            <input type="text" class="form-control" name="tolak" id="tolak"
                                placeholder="Masukkan Alasan Penolakan">
                        </div>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- End Modals --}}
@endsection

@section('javascript')
    <script>
        $(document).ready(function() {
            const jabatanID = {!! Auth::user()->jabatan_id !!}

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

            // Tables
            var table = $('#myTable').DataTable({
                info: false,
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
                        data: "uname"

                    },
                    {
                        data: "jname"
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
                                <a class="btn btn-success" href="/accBont/${data.id}"><i class="fa fa-check-circle"></i></a>
                                <a class="btn btn-danger" href="#modalEditC" data-toggle="modal" onclick="tolak(${data.id})"><i class="fa fa-times"></i></a>`;
                        },
                        width: "5%"
                    }
                ]
            });
            var tableSelf = $('#myTableSelf').DataTable({
                info: false,
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
                            return `<a class="btn btn-success" href="#modalEditB" data-toggle="modal" onclick="getDetailSelf(${data.id})">
                                <i class="fa fa-info-circle"></i>
                                </a>`;
                        },
                        width: "5%"
                    }
                ]
            });
            var table3 = $('#myTableAccDec').DataTable({
                info: false,
                paging: false,
                scrollCollapse: true,
                scrollY: '445px',
                order: [
                    [5, 'asc']
                ],
                columnDefs: [{
                        searchable: true,
                        targets: [0, 1, 2, 3, 4, 5]
                    },
                    {
                        className: "wrap",
                        targets: [0, 1, 2, 3, 4, 5]
                    },
                ],
                columns: [{
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
                        data: "name",
                        width: "10%"
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
                        width: "5%"
                    },
                    {
                        data: "keteranganTolak",
                        defaultContent: '<p>-</p>',
                    },
                    {
                        data: "created_at",
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
                ]
            });
            var tablefm = $('#myTablefm').DataTable({
                info: false,
                paging: false,
                scrollCollapse: true,
                scrollY: '445px',
                order: [
                    [5, 'asc']
                ],
                columnDefs: [{
                        searchable: true,
                        targets: [0, 1, 2, 3, 4, 5]
                    },
                    {
                        className: "wrap",
                        targets: [0, 1, 2, 3, 4, 5]
                    },
                ],
                columns: [{
                        data: "id",
                        width: "10%"
                    },
                    {
                        data: "pengaju",
                        width: "10%"
                    },
                    {
                        data: "department",
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
                        data: null,
                        render: (data, type, row, meta) => {
                            return `<a class="btn btn-info" href="#modalEditA" data-toggle="modal"
                                onclick="getDetail(${data.id})"><i class="fa fa-info-circle"></i></a>
                                <a class="btn btn-success" href="/accBont/${data.id}"><i class="fa fa-check-circle"></i></a>
                                <a class="btn btn-danger" href="#modalEditC" data-toggle="modal" onclick="tolak(${data.id})"><i class="fa fa-times"></i></a>`;
                        },
                        width: "5%"
                    }
                ]
            });
            // End Table

            // Ajaxs
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

            $.ajax({
                type: "GET",
                dataType: "json",
                async: false,
                url: "{{ route('bon.jsonShowIndexSelf') }}",
                success: function(data) {
                    tableSelf.clear().draw()
                    tableSelf.rows.add(data["data"]).draw()
                },
                error: function(error) {
                    console.log("Error: ");
                    console.log(error);
                }
            });

            $.ajax({
                type: "GET",
                dataType: "json",
                async: false,
                url: "{{ route('bon.HistoryAcc') }}",
                success: function(data) {
                    table3.clear().draw()
                    table3.rows.add(data["data"]).draw()
                },
                error: function(error) {
                    console.log("Error: ");
                    console.log(error);
                }
            });
            $.ajax({
                type: "GET",
                dataType: "json",
                async: false,
                url: "{{ route('fmindex') }}",
                success: function(data) {
                    tablefm.clear().draw()
                    tablefm.rows.add(data["data"]).draw()
                },
                error: function(error) {
                    console.log("Error: ");
                    console.log(error);
                }
            });
            // End Ajax

            if (jabatanID == 8) {
                var tableCair = $("#myTableCair").DataTable({
                    info: false,
                    paging: false,
                    scrollCollapse: true,
                    scrollY: '445px',
                    columns: [{
                            data: "uname",
                            width: "10%"
                        }, {
                            data: "dname",
                            width: "10%"
                        }, {
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
                            data: "ACC",
                            width: "10%"
                        },
                        {
                            data: "status",
                            defaultContent: "Menunggu",
                            width: "5%"
                        },
                        {
                            data: null,
                            render: (data, type, row, meta) => {
                                return `<a class="btn btn-info" href="#modalEditB" data-toggle="modal" onclick="getDetailKasir(${data.id})">
                                <i class="fa fa-info-circle"></i>
                                </a>
                                <a class="btn btn-success" href="/accKasir/${data.id}"><i class="fa fa-check-circle"></i></a>`
                            },
                            width: "5%"
                        }
                    ]
                })
                $.ajax({
                    type: "GET",
                    url: "{{ route('kasirIndex') }}",
                    success: function(response) {
                        tableCair.clear().draw()
                        tableCair.rows.add(response).draw()
                    }
                });
            }
        });

        // Functions
        const tolakKasir = (id) => {
            $("#kirimTolak").attr("action", "/decKasir/" + id);
        }
        const getDetailKasir = (id) => {
            $.ajax({
                type: "POST",
                url: "{{ route('detailKasir') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id
                },
                success: function(response) {
                    $('#modalContentB').html(response.msg);
                },
                error: function(err) {
                    console.log(err);
                }
            });
        }

        function tolak(id) {
            $("#kirimTolak").attr("action", "/decBon/" + id);
        }

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

        function getDetailSelf(id) {
            $.ajax({
                type: "POST",
                url: "{{ route('bon.getDetailSelf') }}",
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'id': id
                },
                success: function(data) {
                    $('#modalContentB').html(data.msg);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }
        // End function
    </script>
@endsection
