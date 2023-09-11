@extends('utama')
@section('title')
    Data Project
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
    <style>
        .setAlign {
            text-align: right;
        }

        .wrap {
            word-wrap: break-word !important;
        }
    </style>
    <div class="topdiv">
        <a href="{{ route('project.create') }}" class="btn btn-success"><i class="fa fa-plus-square-o"></i></a>
        <button type="button" value="0" class="btn btn-primary btnShowTrash"><i class="fa fa-eye-slash"></i> Project
            Terhapus </button>
    </div>
    <p>
    <div class="table-responsive" style="overflow: scroll">
        <table id="myTable" class="table table-striped table-bordered" style="table-layout: fixed">
            <thead>
                <tr>
                    <th>ID Opti</th>
                    <th>Nama Opti</th>
                    <th>Nama Pelanggan</th>
                    <th>Tanggal Realisasi</th>
                    <th>Tenggat Waktu</th>
                    <th>Status Project</th>
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
@endsection
@section('javascript')
    <script>
        function getDetail(id) {
            $.ajax({
                type: 'POST',
                url: '{{ route('project.getDetail') }}',
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'id': id
                },
                success: function(data) {
                    $('#modalContent').html(data.msg)
                }
            });
        }

        function getCust(id) {
            $.ajax({
                type: 'POST',
                url: '{{ route('project.getCust') }}',
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
        $(document).ready(function() {
            $("#project").addClass("active");
            $("#dataProject").addClass("active");

            $("#modalEditA").on("click", ".linkwa", function() {
                const number = $(this).val();
                const parts = number.split('');
                if (parts[0] === '0') parts[0] = '62';
                const newnowa = parts.join('');
                const url = `https://web.whatsapp.com/send?phone=`;
                const wa = url.concat('', newnowa);
                window.open(wa, '_blank');
            });


            var table = $('#myTable').DataTable({
                paging: false,
                scrollCollapse: true,
                scrollY: '445px',
                columnDefs: [{
                    className: "wrap",
                    target: [1, 2]
                }],
                columns: [{
                        data: "idOpti"
                    },
                    {
                        data: "namaOpti"
                    },
                    {
                        data: null,
                        render: (data, type, row, meta) => {
                            return `<a href="#modalEditA" data-toggle="modal" onclick="getCust(${data.cid})">${data.cnama}</a><br>`;
                        }
                    },
                    {
                        data: "tglRealisasi"
                    },
                    {
                        data: "deadline"
                    },
                    {
                        data: "status"
                    },
                    {
                        data: null,
                        render: (data, type, row, meta) => {
                            return data.deleted_at == null ? `<a class="btn btn-success" href="#modalEditA" data-toggle="modal"
                                onclick="getDetail(${data.id})"><i class="fa fa-info-circle"></i></a><br>
                            <a class="btn btn-primary" href="/project/${data.id}/edit"><i class="fa fa-edit"></i></a>
                            <form method="POST" action="/project/${data.id}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Do you agree to delete with  ${data.id}  -  ${data.idOpti}  -  ${data.namaOpti}  ?');"><i class="fa fa-trash-o"></i></button>
                            </form>` :
                                `<button class="btn btn-primary btn-restore" id="btn-restore-${data.id}" data-id="${data.id}"><i class="fa fa-undo"></i></button>`;
                        }
                    },
                ],
                createdRow: function(row, data, index) {
                    if (data.deleted_at != null) $(row).addClass('danger')
                },
            });
            $.ajax({
                type: "GET",
                dataType: "json",
                async: false,
                url: "{{ route('project.backToIndex') }}",
                success: function(data) {
                    table.clear().draw()
                    table.rows.add(data["data"]).draw()
                }
            });
            $("#myTable").on("click", ".btn-restore", function() {
                const id = $(this).attr("data-id")
                $.ajax({
                    type: "POST",
                    url: "{{ route('project.restore') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": id
                    },
                    success: function(response) {
                        const data = response.data[0]
                        console.log(data);
                        const tr = $("#btn-restore-" + id).parent().parent()
                        tr.removeClass('danger')
                        $(tr).find(':last-child').html(`
                        <a class="btn btn-success" href="#modalEditA" data-toggle="modal"
                                onclick="getDetail(${data.id})"><i class="fa fa-info-circle"></i></a><br>
                            <a class="btn btn-primary" href="/project/${data.id}/edit"><i class="fa fa-edit"></i></a>
                            <form method="POST" action="/project/${data.id}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Do you agree to delete with  ${data.id}  -  ${data.idOpti}  -  ${data.namaOpti}  ?');"><i class="fa fa-trash-o"></i></button>
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
                    console.log($(this).attr('value'));
                    $.ajax({
                        type: "GET",
                        url: "{{ route('project.trashIndex') }}",
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
                    console.log($(this).attr('value'));
                    $.ajax({
                        type: "GET",
                        url: "{{ route('project.backToIndex') }}",
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
