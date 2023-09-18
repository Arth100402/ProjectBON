@extends('utama')

@section('title')
    Pengaturan Hirarki Acc Pengajuan BS
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

    {{-- FORM --}}
    <!-- BEGIN FORM-->
    <form action="#" class="form-horizontal form-bordered form-row-stripped">
        <div class="form-body">
            <div class="form-group">
                <label class="control-label col-md-3">Departments: </label>
                <div class="col-md-4">
                    <select class="form-control input-xlarge select2me" data-placeholder="-- Pilih department --"
                        id="select-department">
                        <option value=""></option>
                        @foreach ($data as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                    <span class="help-block">
                        Pilih department! </span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Jabatans: </label>
                <div class="col-md-4">
                    <select class="form-control input-xlarge" id="select-jabatan" disabled></select>
                    <span class="help-block">
                        Pilih Jabatan! </span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Hirarki Tahapan Acc: </label>
                <div class="col-md-4"></div>
            </div>
            <div class="form-group">
                <div class="col-md-4">
                    <table id="myTable" class="table table-striped table-bordered"></table>
                </div>
            </div>
        </div>
    </form>
    <!-- END FORM-->
@endsection
@section('javascript')
    <script>
        $(document).ready(function() {
            // Event Listener
            $("#select-department").on("change", function() {
                $("#select-jabatan").attr("disabled", false);
            });

            $("#select-jabatan").on("change", function() {
                const table = $("#myTable");
                const jabatanID = $(this).val();
                let header = `<thead><tr>`
                let body = `<tbody><tr>`
                $.ajax({
                    type: "POST",
                    url: "{{ route('setting.populateTable') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "idDepart": $("#select-department").val(),
                        "idJabatan": jabatanID
                    },
                    success: function(response) {
                        const jabatans = response.jabatans
                        const status = response.status

                        parent:
                            for (const iterator of jabatans) {
                                if (iterator.id <= jabatanID) continue;
                                header +=
                                    `
                            <th>${iterator.name}</th>
                            `
                                for (const row of status) {
                                    if (row.jabatanAcc == iterator.id && row.status ==
                                        "enable") {
                                        body += `
                                        <td><input id="switch-${iterator.id}" type="checkbox" class="make-switch" checked data-on-color="primary" data-off-color="info" data-value="${jabatanID}-${iterator.id}"></td>    
                                    `
                                        temp = true
                                        continue parent;
                                    }
                                }
                                body += `
                                <td><input id="switch-${iterator.id}" type="checkbox" class="make-switch" data-on-color="primary" data-off-color="info" data-value="${jabatanID}-${iterator.id}"></td>    
                            `
                            }
                        header += `</tr></thead>`
                        body += `</tr></tbody>`
                        table.html(header + body);
                        $(".make-switch").bootstrapSwitch();
                        reDisable()
                    },
                    error: function(err) {
                        console.log(err);
                    }
                });

            });

            $("#myTable").on("switchChange.bootstrapSwitch", ".make-switch", function(e) {
                const ch = $(this);
                const d = $("#select-department").val()
                const [aj, ac] = $(this).attr("data-value").split("-")
                const st = ($(this).is(":checked") ? "true" : "false")
                $.ajax({
                    type: "POST",
                    url: "{{ route('setting.checked') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "depart": d,
                        "aju": aj,
                        "acc": ac,
                        "stat": st
                    },
                    success: function(response) {
                        reDisable();
                        const id = $(ch).attr("id").split('-')
                        if (st == "true" && !$("#switch-" + (parseInt(id[1]) + 1)).is(
                                ":checked")) {
                            $("#switch-" + (parseInt(id[1]) + 1)).bootstrapSwitch("disabled",
                                false);
                        }
                        if (st == "false" && $("#switch-" + (parseInt(id[1]) - 1)).attr(
                                "disabled")) {
                            console.log($("#switch-" + (parseInt(id[1]) - 1)));
                            $("#switch-" + (parseInt(id[1]) - 1)).bootstrapSwitch("disabled",
                                false);
                        }
                    }
                });

            });

            // Initialize
            $('#select-jabatan').select2({
                placeholder: '-- Pilih Jabatan  --',
                ajax: {
                    url: '{{ route('setting.loadJabatan') }}',
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    text: item.name,
                                    id: item.id
                                }
                            })
                        };
                    },
                    cache: true
                }
            });
            $("#setting").addClass("active");
            $("#hierarchy").addClass("active");

            const reDisable = () => {
                for (const el of $(".make-switch:not(:checked)").slice(1)) {
                    $(el).bootstrapSwitch("disabled", true);
                }
                for (const el of $(".make-switch:checked").slice(0, $(".make-switch:checked").length - 1)) {
                    $(el).bootstrapSwitch("disabled", true);
                }
            }
        });
    </script>
@endsection
