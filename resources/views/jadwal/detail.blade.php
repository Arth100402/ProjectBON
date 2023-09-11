<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title" id="modalTitle">{{ $data['namaAktifitas'] }}</h4>
</div>
<form action="{{ route('jadwal.createActivity') }}" method="POST" id="formActivityCreate">
    @csrf
    <div class="panel-body" id="modalContent">
        <b>Nama Teknisi : </b><br>
        <p>{{ $data['name'] }}</p>
        <b>Nama Project : </b><br>
        <p class="wrap">{{ $data['namaOpti'] }}</p>
        <b>Deadline Project: </b><br>
        <p>{{ $data['deadline'] }}</p>
        <b>Status Project: </b><br>
        <p>{{ $data['status'] }}</p>
        <b>Keterangan: </b><br>
        <p>{{ $data['keterangan'] }}</p>
        <b>Waktu Tiba: </b><br>
        <p>{{ $data['waktuTiba'] }}</p>
        <b>Waktu Selesai: </b><br>
        <p>{{ $data['waktuSelesai'] }}</p>
        <b>Tgl Garansi: </b><br>
        <p>{{ $data['tglGaransi'] }}</p><br>
        <b>Daftar Device:</b>
        <div class="detailDevice">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Nama Device</th>
                        <th>Jenis Device</th>
                        <th>Tipe Device</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($devices as $item)
                        <tr>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->jenis }}</td>
                            <td>{{ $item->tipe }}</td>
                            <td>{{ $item->status }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
        @php
            $images = explode(',', $data['image']);
        @endphp
        <!-- Indicators -->
        <ol class="carousel-indicators">
            @for ($i = 0; $i < count($images); $i++)
                @if ($i == 0)
                    <li data-target="#myCarousel" data-slide-to="{{ $i }}" class="active">
                    </li>
                @else
                    <li data-target="#myCarousel" data-slide-to="{{ $i }}"></li>
                @endif
            @endfor
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner" style="background-color: rgb(40, 40, 40)">
            @for ($i = 0; $i < count($images); $i++)
                @if ($i == 0)
                    <div class="item active"
                        style="height: 50vh; background-size:cover;background-position: center center;
                    background-repeat: no-repeat;">
                        <img src="{{ asset('images/' . $images[$i]) }}" alt="Los Angeles"
                            style="width:100%;height:100%; object-fit:contain;object-position:center">
                    </div>
                @else
                    <div class="item"
                        style="height: 50vh;background-size:cover;background-position: center center;
                    background-repeat: no-repeat;">
                        <img src="{{ asset('images/' . $images[$i]) }}" alt="Los Angeles"
                            style="width:100%;height:100%; object-fit:contain;object-position:center">
                    </div>
                @endif
            @endfor
        </div>

        <!-- Left and right controls -->
        <a class="left carousel-control" href="#myCarousel" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#myCarousel" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    <div class="modal-footer" id="modalFooter">
        <a class="btn btn-danger" data-dismiss="modal">Close</a>
    </div>
</form
