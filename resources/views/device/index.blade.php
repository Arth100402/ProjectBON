@extends('utama')
@section('title')
    Data Barang
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
    <div class="topdiv">
        <a href="{{ route('device.create') }}" class="btn btn-success"><i class="fa fa-plus-square-o"></i></a>
        <button type="button" value="0" class="btn btn-primary btnShowTrash"><i class="fa fa-eye-slash"></i> Barang
            Terhapus </button>
    </div>
    <style>
        .setAlign {
            text-align: right;
        }
    </style>
    <p>
    <div class="table-responsive">
        <table id="myTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Kategori Barang</th>
                    <th>Tipe Barang</th>
                    <th>Merk Barang</th>
                    <th>Serial Number</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
        <div class="modal fade" id="modalEditA" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog modal-wide">
                <div class="modal-content">
                    <div class="modal-body" id="modalContent">
                        <!--loading animated gif can put here-->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script>
        function getImage(id) {
            $.ajax({
                type: 'POST',
                url: '{{ route('vehicle.imagedev') }}',
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'id': id
                },
                success: function(data) {
                    console.log(data);
                    $('#modalContent').html(data.msg)
                }
            });
        }

        function format(d) {
            return (
                '<dl>' +
                '<dt>IP Address:</dt>' +
                '<dd>' +
                d.ipaddress +
                '</dd>' +
                '<dt>Port:</dt>' +
                '<dd>' +
                d.port +
                '</dd>' +
                '<dt>Username:</dt>' +
                '<dd>' +
                d.username +
                '</dd>' +
                '<dt>Password:</dt>' +
                '<dd>' +
                d.password +
                '</dd>' +
                '</dl>'
            );
        };

        $(document).ready(function() {
            $("#project").addClass("active");
            $("#dataDevice").addClass("active");

            var table = $('#myTable').DataTable({
                paging: false,
                scrollCollapse: true,
                scrollY: '445px',
                columns: [{
                        className: 'dt-control',
                        orderable: false,
                        data: null,
                        defaultContent: '',
                        data: 'nama'
                    },
                    {
                        data: 'dcnama'
                    },
                    {
                        data: 'tipe'
                    },
                    {
                        data: 'merk'
                    },
                    {
                        data: 'serialnumber'
                    },
                    {
                        data: null,
                        render: (data, type, row, meta) => {
                            return data.deleted_at == null ? `<a class="btn btn-success" href="#modalEditA" data-toggle="modal"
                                onclick="getImage(${data.id})"><i class="fa fa-image"></i></a></br>
                                <a class="btn btn-primary" href="/device/${data.id}/edit"><i class="fa fa-edit"></i></a></br>
                                <form method="POST" action="/device/${data.id}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                onclick="return confirm('Apakah anda setuju menghapus ${data.nama} kategori  ${data.dcnama}  ?');"><i class="fa fa-trash-o"></i></button>
                                </form>` : `<button class="btn btn-primary btn-restore" id="btn-restore-${data.id}" data-id="${data.id}"><i class="fa fa-undo"></i></button>`;
                        }
                    },
                ],
                order: [
                    [2, 'asc']
                ],
                createdRow: function(row, data) {
                    if (data.deleted_at != null) $(row).addClass('danger')
                }
            });

            var table = $('#myTable').DataTable()
            $.ajax({
                type: "GET",
                dataType: "json",
                async: false,
                url: "{{ route('device.jsonIndex') }}",
                success: function(data) {
                    table.clear().draw()
                    table.rows.add(data["data"]).draw()
                }
            });

            table.on('requestChild.dt', function(e, row) {
                row.child(format(row.data())).show();
            });
            $('#myTable tbody').on('click', 'td.dt-control', function() {
                var tr = $(this).closest('tr');
                var row = table.row(tr);
                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                } else {
                    // Open this row
                    row.child(format(row.data())).show();
                }
            });

            $("#myTable").on("click", ".btn-restore", function() {
                const id = $(this).attr("data-id")
                $.ajax({
                    type: "POST",
                    url: "{{ route('device.restore') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": id
                    },
                    success: function(response) {
                        const data = response.data
                        const tr = $("#btn-restore-" + id).parent().parent()
                        tr.removeClass('danger')
                        $(tr).find(':last-child').html(`
                    <a class="btn btn-success" href="#modalEditA" data-toggle="modal"
                            onclick="getImage(${data.id})"><i class="fa fa-image"></i></a>
                            <a class="btn btn-primary" href="/device/${data.id}/edit"><i class="fa fa-edit"></i></a></br>
                            <form method="POST" action="/device/${data.id}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"
                            onclick="return confirm('Apakah anda setuju menghapus ${data.nama} kategori  ${data.dcnama}  ?');"><i class="fa fa-trash-o"></i></button>
                            </form>
                    `)
                    }
                });
            });
            $(".btnShowTrash").click(function() {
                var dt = $('#myTable').DataTable()
                if ($(this).attr('value') == 0) {
                    $(this).addClass("btn-warning");
                    $(this).removeClass("btn-primary");
                    $(this).html('<i class="fa fa-eye"></i> Project Terhapus');
                    $(this).attr('value', '1');
                    $.ajax({
                        type: "GET",
                        url: "{{ route('device.jsonTrashIndex') }}",
                        success: function(data) {
                            dt.clear().draw()
                            dt.rows.add(data["data"]).draw()
                        },
                        error: function(error) {
                            console.log("Error: ");
                            console.log(error);
                        }
                    });
                } else {
                    $(this).addClass("btn-primary");
                    $(this).removeClass("btn-warning");
                    $(this).html('<i class="fa fa-eye-slash"></i> Project Terhapus');
                    $(this).attr('value', '0');
                    $.ajax({
                        type: "GET",
                        url: "{{ route('device.jsonIndex') }}",
                        success: function(data) {
                            dt.clear().draw()
                            dt.rows.add(data["data"]).draw()

                        },
                        error: function(error) {
                            console.log("Error: ");
                            console.log(error);
                        }
                    });
                }
            });
        });
    </script>
@endsection
