@extends('utama')

@section('title')
    Bon Sementara
@endsection

@section('isi')
    <style>
        .wrap {
            word-wrap: break-word !important;
        }

        .flex {
            display: flex;
            width: 100%;
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

    <div class="topdiv">
        <a href="{{ route('admin.create') }}" class="btn btn-success"><i class="fa fa-plus-square-o"></i></a>
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

    {{-- Modals --}}
    <div class="modal fade" id="modalEditB" tabindex="-1" role="basic" aria-hidden="true">
        <div class="modal-dialog modal-wide">
            <div class="modal-content">
                <div class="modal-body" id="modalContentB">
                    <!--loading animated gif can put here-->
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
            const departID = {!! Auth::user()->departement_id !!}

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
                            let result = `<a class="btn btn-success" href="#modalEditB" data-toggle="modal" onclick="getDetailSelf(${data.id},${data.users_id})">
                                <i class="fa fa-info-circle"></i>
                                </a>`
                            if (type === 'display' && data.editable == true) {
                                result +=
                                    `<a class="btn btn-success" href="/bon/${data.id}/edit"><i class="fa fa-edit"></i></a>`;
                            }
                            return result;
                        },
                        width: "10%"
                    }
                ]
            });

            $.ajax({
                type: "GET",
                dataType: "json",
                async: false,
                url: "{{ route('admin.index') }}",
                success: function(data) {
                    tableSelf.clear().draw()
                    tableSelf.rows.add(data["data"]).draw()
                    console.log(data);
                },
                error: function(error) {
                    console.log("Error: ");
                    console.log(error);
                }
            });
        });

        function getDetailSelf(id,users_id) {
            $.ajax({
                type: "POST",
                url: "{{ route('bon.getDetailAdmin') }}",
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'id': id,
                    'users_id' : users_id
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
