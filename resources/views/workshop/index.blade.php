@extends('utama')
@section('title')
    Data Bengkel
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
    </style>
    <div class="topdiv">
        <a href="{{ route('workshop.create') }}" class="btn btn-success"><i class="fa fa-plus-square-o"></i></a>
    </div>
    <p>
    <div class="table-responsive" style="overflow: scroll">
        <table id="myTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Nama Bengkel</th>
                    <th>Alamat Bengkel</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $d)
                    <tr>
                        <td>{{ $d->nama }}</td>
                        <td>{{ $d->alamat }}</td>
                        <td>
                            <a class="btn btn-primary" href="{{ route('workshop.edit', $d->id) }}"><i
                                    class="fa fa-edit"></i></a>
                            <form method="POST" action="{{ route('workshop.destroy', $d->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" value="Hapus" class="btn btn-danger"
                                    onclick="return confirm('Apakah anda yakin ingin menghapus Bengkel {{ $d->nama }} yang beralamat di {{ $d->alamat }} ?');">
                                    <i class="fa fa-trash-o"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
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
        $("#vehicle").addClass("active");
        $("#dataBengkel").addClass("active");
        $('#myTable').DataTable({
            paging: false,
            scrollCollapse: true,
            scrollY: '445px'
        });
    </script>
@endsection
