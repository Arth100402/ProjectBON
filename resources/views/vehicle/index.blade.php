@extends('utama')
@section('title')
    Data Kendaraan
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
        <a href="{{ route('vehicle.create') }}" class="btn btn-success"><i class="fa fa-plus-square-o"></i></a>
        <button type="button" value="0" class="btn btn-primary btnShowTrash"><i class="fa fa-eye-slash"></i> Kendaraan
            Terhapus </button>
    </div>
    <style>
        .setAlign {
            text-align: right;
        }
    </style>
    <p>
    <table id="myTable" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>No Pol</th>
                <th>Jenis</th>
                <th>Merk</th>
                <th>Tipe</th>
                <th>Warna</th>
                <th>Lokasi</th>
                <th>Atas Nama STNK</th>
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
@endsection
@section('javascript')
    <script>
        function getDetail(id) {
            $.ajax({
                type: 'POST',
                url: '{{ route('vehicle.getDetail') }}',
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

            $("#vehicle").addClass("active");
            $("#dataKendaraan").addClass("active");
            var table = $('#myTable').DataTable({
                paging: false,
                scrollCollapse: true,
                scrollY: '445px',
                columns: [{
                        data: 'noPol'
                    },
                    {
                        data: 'jenis'
                    },
                    {
                        data: 'merk'
                    },
                    {
                        data: 'tipe'
                    },
                    {
                        data: 'warna'
                    },
                    {
                        data: 'nama'
                    },
                    {
                        data: 'atasNamaSTNK'
                    },
                    {
                        data: null,
                        render: (data, type, row, meta) => {
                            return data.deleted_at == null ? `<a class="btn btn-success" href="#modalEditA" data-toggle="modal"
                                onclick="getDetail(${data.id})"><i class="fa fa-info-circle"></i></a></br>
                                <a class="btn btn-primary" href="/vehicle/${data.id}/edit"><i
                                class="fa fa-edit"></i></a>
                                <form method="POST" action="/vehicle/${data.id}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" value="Hapus" class="btn btn-danger"
                                onclick="return confirm('Do you agree to delete with ${data.id} - ${data.jenis} - ${data.noPol} ?');">
                                <i class="fa fa-trash-o"></i></button>
                                </form>` : `<button class="btn btn-primary btn-restore" id="btn-restore-${data.id}" data-id="${data.id}"><i class="fa fa-undo"></i></button>`;
                        }
                    },
                ],
                order: [
                    [2, 'asc'],
                    [1, 'asc']
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
                url: "{{ route('vehicle.vehJsonIndex') }}",
                success: function(data) {
                    table.clear().draw()
                    table.rows.add(data["data"]).draw()
                }
            });


            $("#myTable").on("click", ".btn-restore", function() {
                const id = $(this).attr("data-id")
                $.ajax({
                    type: "POST",
                    url: "{{ route('vehicle.restore') }}",
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
                                onclick="getDetail(${data.id})"><i class="fa fa-info-circle"></i></a></br>
                                <a class="btn btn-primary" href="/vehicle/${data.id}/edit"><i
                                class="fa fa-edit"></i></a>
                                <form method="POST" action="/vehicle/${data.id}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" value="Hapus" class="btn btn-danger"
                                onclick="return confirm('Do you agree to delete with ${data.id} - ${data.jenis} - ${data.noPol} ?');">
                                <i class="fa fa-trash-o"></i></button>
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
                        url: "{{ route('vehicle.vehJsonTrashIndex') }}",
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
                        url: "{{ route('vehicle.vehJsonIndex') }}",
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
