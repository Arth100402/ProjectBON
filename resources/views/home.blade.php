@extends('utama')

@section('title')
    Pengajuan Perjalanan Dinas
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


    <div class="table-responsive" style="overflow: scroll">
        <table id="myTable" class="table table-striped table-bordered" style="table-layout: fixed">
            <thead>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
@endsection
@section('javascript')
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                paging: false,
                scrollCollapse: true,
                scrollY: '445px',
                columns: [{
                        data: "idOpti"
                    },
                    {
                        data: "namaOpti"
                    } {
                        data: "tglRealisasi"
                    },
                    {
                        data: "deadline"
                    }
                ]
            });
        });
    </script>
@endsection
