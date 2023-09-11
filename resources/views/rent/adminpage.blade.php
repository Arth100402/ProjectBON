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
    <style>
        .setAlign {
            text-align: right;
        }
    </style>
    <p>
    <div class="table-responsive" style="overflow: scroll">
        <table id="myTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Peminjam</th>
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
                        <td>{{ $d->peminjam }}</td>
                        <td>{{ $d->kendaraan }}</td>
                        <td>{{ $d->tglSewa }}</td>
                        <td>{{ $d->tglSelesai }}</td>
                        <td>{{ $d->tujuan }}</td>
                        <td>{{ sprintf('Rp %s', number_format($d->biayaSewa, 0, ',', '.')) }}</td>
                        <td>{{ $d->kmAwal }}</td>
                        <td>{{ $d->kmAkhir }}</td>
                        <td>{{ $d->totalLiter }}</td>
                        <td>{{ $d->lokasiPengisian }}</td>
                        <td>
                            @if ($d->acc == 'Diproses')
                                <a class="btn btn-primary" href="#modalEditA" data-toggle="modal"
                                    onclick="getJaminan({{ $d->id }})"><i class="fa fa-image"></i></a><br>
                                <a class="btn btn-success" href="{{ route('vehicle.accRent', $d->id) }}"><i
                                        class="fa fa-check-circle"></i></a>
                                <a class="btn btn-danger" href="#modalEditC" data-toggle="modal"
                                onclick="tolak({{ $d->id }})"><i class="fa fa-times"></i></a>
                            @elseif($d->acc == 'Selesai')
                                <p>Selesai</p>
                                <a class="btn btn-primary" href="#modalEditB" data-toggle="modal"
                                    onclick="getBukti({{ $d->id }})">Bukti</a>
                            @elseif($d->acc == 'Diterima')
                                <p>Sedang Dipinjam</p>
                            @else
                                <p>Ditolak</p>
                            @endif
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
    <div class="modal fade" id="modalEditB" tabindex="-1" role="basic" aria-hidden="true">
        <div class="modal-dialog modal-wide">
            <div class="modal-content">
                <div class="modal-body" id="modalContentB">
                    <!--loading animated gif can put here-->
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalEditC" tabindex="-1" role="basic" aria-hidden="true">
        <div class="modal-dialog modal-wide">
            <div class="modal-content">
                <div class="modal-body" id="modalContentC">
                    <form id="kirimTolak" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="nama">Alasan Tolak</label>
                            <input type="text" class="form-control" name="tolak" id="tolak"
                                placeholder="Masukkan Alasan Penolakan">
                        </div>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script>
        function getJaminan(id) {
            $.ajax({
                type: 'POST',
                url: '{{ route('vehicle.jaminan') }}',
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

        function tolak(id)
        {
            $("#kirimTolak").attr("action", "/customvehicle/decRent/"+id);
        }

        function getBukti(id) {
            $.ajax({
                type: 'POST',
                url: '{{ route('vehicle.bukti') }}',
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'id': id
                },
                success: function(data) {
                    console.log(data.msg);
                    $('#modalContentB').html(data.msg)
                }
            });
        }
        $("#vehicle").addClass("active");
        $("#historyPeminjaman").addClass("active");
    </script>
    <script>
        $('#myTable').DataTable();
    </script>
@endsection
