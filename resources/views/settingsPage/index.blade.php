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
                <label class="control-label col-md-3">Karyawan: </label>
                <div class="col-md-4">
                    <select class="form-control input-xlarge" id="select-karyawan" disabled></select>
                    <span class="help-block">
                        Pilih Karyawan! </span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Hirarki Tahapan Acc: </label>
                <div class="col-md-4"></div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <table id="myTable" class="table table-bordered table-striped table-condensed flip-content"></table>
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
                $("#select-karyawan").attr("disabled", false);
                $("#select-karyawan").empty()
                $("#myTable").html("");
            });
            $("#myTable").on("change", ".threshold-input", function() {
                const thres = $(this).val();
                const idAcc = $(this).siblings("div").find(".select-acc");
                const level = parseInt($(idAcc).attr("id").split('-')[1])
                const karyawanID = $("#select-karyawan").val();
                const departID = $("#select-department").val();
                $.ajax({
                    type: "POST",
                    url: "{{ route('setting.thr') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "idAcc": idAcc.val(),
                        "thres": thres,
                        "level": level,
                        "idPart": departID,
                        "idKar": karyawanID
                    },
                    success: function(response) {
                        console.log(response);
                    },
                    error: function(err) {
                        console.log(err);
                    }
                });
            });
            $("#myTable").on("change", ".select-acc", function() {
                const idAcc = $(this).val();
                const thres = $(this).parent().siblings(".threshold-input");
                const level = parseInt($(this).attr("id").split('-')[1])
                const karyawanID = $("#select-karyawan").val();
                const departID = $("#select-department").val();
                const st = ($(this).is(":has(option:selected[value!=''])") ? "true" : "false")
                const ch = $(this);
                thres.attr("disabled", idAcc ? false : true)
                if (!idAcc) thres.val("0")
                $.ajax({
                    type: "POST",
                    url: "{{ route('setting.changeAcc') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "idAcc": idAcc,
                        "thres": thres.val(),
                        "level": level,
                        "idPart": departID,
                        "idKar": karyawanID
                    },
                    success: function(response) {
                        reDisable();
                        const id = $(ch).attr("id").split('-')
                        if (st == "true" && !$("#level-" + (parseInt(id[1]) + 1)).is(
                                ":has(option:selected)")) {
                            $("#level-" + (parseInt(id[1]) + 1)).attr("disabled",
                                false);
                        }
                        if (st == "false" && $("#level-" + (parseInt(id[1]) - 1)).attr(
                                "disabled")) {
                            console.log($("#level-" + (parseInt(id[1]) - 1)));
                            $("#level-" + (parseInt(id[1]) - 1)).attr("disabled",
                                false);
                        }
                    },
                    error: function(err) {
                        console.log(err);
                    }
                });
            });

            $("#select-karyawan").on("change", function() {
                const table = $("#myTable");
                const karyawanID = $(this).val();
                const departID = $("#select-department").val();
                let header = `<thead><tr>`
                let body = `<tbody><tr>`
                $.ajax({
                    type: "POST",
                    url: "{{ route('setting.populateTable') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "idKar": karyawanID,
                        "idPart": departID
                    },
                    success: function(response) {
                        const status = response.status
                        for (let level = 1; level <= 5; level++) {
                            header +=
                                `<th scope="col">Level ${level}</th>`
                            body += `
                                    <td>
                                        <div>
                                        <select class="form-control select-acc" id="level-${level}" style="100%">
                                            ${status[level-1]?`<option value="${status[level-1].idAcc}" selected="selected">${status[level-1].name}</option>`:``}
                                        </select></div>
                                        <label>Threshold: </label>
                                        <input type="number" class="form-control threshold-input" min="0" step="any" value="${status[level-1] ? status[level-1].threshold:0}" ${!status[level-1]?"disabled":""}>
                                    </td>`
                        }
                        header += `</tr></thead>`
                        body += `</tr></tbody>`
                        table.html(header + body);
                        reDisable()
                        $('.select-acc').select2({
                            placeholder: '-- Pilih Atasan  --',
                            allowClear: true,
                            width: "element",
                            cache: true,
                            ajax: {
                                url: '{{ route('setting.loadAcc') }}',
                                dataType: 'json',
                                delay: 250,
                                data: function(q) {
                                    return {
                                        q: q.term,
                                        idDepart: $("#select-department").val(),
                                        idKar: $("#select-karyawan").val()
                                    }
                                },
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
                            }
                        });
                    },
                    error: function(err) {
                        console.log(err);
                    }
                });
            });

            // Initialize
            $('#select-karyawan').select2({
                placeholder: '-- Pilih Karyawan  --',
                ajax: {
                    url: '{{ route('setting.loadKaryawan') }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(q) {
                        return {
                            q: q.term,
                            idDepart: $("#select-department").val()
                        }
                    },
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
                for (const el of $(".select-acc:not(:has(option:selected[value!='']))").slice(1)) {
                    $(el).attr("disabled", true);
                }
                for (const el of $(".select-acc:has(option:selected)").slice(0, $(
                            ".select-acc:has(option:selected)")
                        .length -
                        1)) {
                    $(el).attr("disabled", true);
                }
            }
        });
    </script>
@endsection
