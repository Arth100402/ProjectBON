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
    @if (Auth::user()->jabatan_id == 1)
        {{-- Staff --}}
        <p>s</p>
    @elseif(Auth::user()->jabatan_id != 1)
        {{-- Selain Staff --}}
        <p>a</p>
    @endif
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
