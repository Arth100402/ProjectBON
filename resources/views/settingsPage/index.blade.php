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
                let header = `<thead><tr>`
                let body = `<tbody>`
                $.ajax({
                    type: "POST",
                    url: "{{ route('setting.populateTable') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "idDepart": $("#select-department").val(),
                        "idJabatan": $(this).val()
                    },
                    success: function(response) {
                        const jabatans = response.jabatans
                        console.log(jabatans);
                        for (const iterator of jabatans) {
                            header +=
                                `
                            <th>${iterator.name}</th>
                            `
                        }
                        header += `</tr></thead>`
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
        });
    </script>
@endsection
