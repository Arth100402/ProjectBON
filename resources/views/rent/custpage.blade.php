@extends('utama')
@section('title')
    Riwayat Peminjaman Kendaraan
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
<a href="{{ route('vehicle.rent') }}" class="btn btn-success">Pinjam Kendaraan</a>
<style>
    .setAlign {
        text-align: right;
    }
</style>
<p>
<table id="myTable" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>Kendaraan</th>
            <th>Tanggal Sewa</th>
            <th>Tanggal Selesai</th>
            <th>Tujuan</th>
            <th>Biaya Sewa</th>
            <th>KM Awal</th>
            <th>KM Akhir</th>
            <th>Total Liter</th>
            <th>Lokasi Pengisian</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $d)
        <tr>
            <td>{{ $d->kendaraan}}</td>
            <td>{{ $d->tglSewa }}</td>
            <td>{{ $d->tglSelesai }}</td>
            <td>{{ $d->tujuan }}</td>
            <td>{{ sprintf('Rp %s', number_format($d->biayaSewa, 0, ',', '.')) }}</td>
            <td>{{ $d->kmAwal }}</td>
            <td>{{ $d->kmAkhir }}</td>
            <td>{{ $d->totalLiter }}</td>
            <td>{{ $d->lokasiPengisian }}</td>
            <td>
                @if($d->acc == 'Diterima' )
                <a class="btn btn-primary" href="{{ route('vehicle.finishRent', $d->id) }}">Selesaikan</a>
                @elseif($d->acc == 'Selesai')
                <p>Selesai</p>
                @elseif($d->acc == 'Ditolak')
                <p>Ditolak Karena {{$d->keteranganTolak}}</p>
                @else
                <p>{{$d->acc}}</p>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
@section('javascript')
    <script>
        $("#vehicle").addClass("active");
        $("#peminjamanKendaraan").addClass("active");
    </script>
    <script>
        $('#myTable').DataTable();
    </script>
@endsection
