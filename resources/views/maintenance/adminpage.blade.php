@extends('utama')
@section('title')
    Riwayat Service Kendaraan
@endsection
@section('isi')
    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif
    <style>
        .setAlign {
            text-align: right;
        }
    </style>
    <p>
    <table id="myTable" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Teknisi</th>
                <th>Tanggal Service</th>
                <th>Kendaraan</th>
                <th>Keluhan</th>
                <th>Total Biaya</th>
                <th>KM</th>
                <th>Biaya Jasa Service</th>
                <th>Nama Bengkel</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $d)
                <tr>
                    <td>{{ $d->user->name }}</td>
                    <td>{{ $d->tglMaintenance }}</td>
                    <td>{{ $d->vehicle->jenis }} {{ $d->vehicle->merk }} {{ $d->vehicle->noPol }}</td>
                    <td>{{ $d->keluhan }}</td>
                    <td>{{ sprintf('Rp %s', number_format($d->totalBiaya, 0, ',', '.')) }}</td>
                    <td>{{ $d->km }}</td>
                    <td>{{ sprintf('Rp %s', number_format($d->hargaService, 0, ',', '.')) }}</td>
                    <td>{{ $d->workshop->nama }}</td>
                    <td>
                        <a class="btn btn-success" href="#modalEditA" data-toggle="modal"
                            onclick="getDetail({{ $d->id }})"><i class="fa fa-fax"></i></a><br>
                        <a class="btn btn-primary" href="#modalEditB" data-toggle="modal"
                            onclick="getImage({{ $d->id }})"><i class="fa fa-image"></i></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
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
    <div class="modal fade" id="modalEditB" tabindex="-1" role="basic" aria-hidden="true">
        <div class="modal-dialog modal-wide">
            <div class="modal-content">
                <div class="modal-body" id="modalContentB">
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
                url: '{{ route('vehicle.sparepart') }}',
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

        function getImage(id) {
            $.ajax({
                type: 'POST',
                url: '{{ route('vehicle.imagenota') }}',
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'id': id
                },
                success: function(data) {
                    console.log(data);
                    $('#modalContentB').html(data.msg)
                }
            });
        }
    </script>
    <script>
        $("#vehicle").addClass("active");
        $("#service").addClass("active");
    </script>
    <script>
        $('#myTable').DataTable();
    </script>
@endsection
