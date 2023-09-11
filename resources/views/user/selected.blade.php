<div class="container">
    <div class="row">
        <div class="col-md-3">
            @if ($data->waktuTiba == null)
                <div class="icon">
                    <i class="fa fa-clock-o"></i>
                    <p>Check In</p>
                    <button class="btn btn-primary" id="checkin" value="{{ Auth::user()->id }},{{ $data->projectactivitydetail_id }}">Check In</button>
                </div>
            @else
                <div class="icon">
                    <i class="fa fa-clock-o"></i>
                    <p>{{ $data->waktuTiba }}</p>
                </div>
            @endif
        </div>
        <div class="col-md-3">
            <div class="icon">
                <i class="fa fa-book"></i>
                <p>Laporan Tertulis</p>
                <a href="#modalJadwal" onclick="loadFormCreate({{ $data->projectactivitydetail_id }})" class="btn btn-primary" data-toggle="modal">Laporan Tulis</a>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="icon">
                <i class="fa fa-camera"></i>
                <p>Laporan Foto</p>
                <a href="webcam/{{ Auth::user()->id }}/{{ $data->projectactivitydetail_id }}" class="btn btn-primary" id="webcam">Laporan Foto</a>
            </div>
        </div>
        <div class="col-md-3">
            @if ($data->waktuSelesai == null)
                <div class="icon">
                    <i class="fa fa-home"></i>
                    <p>Check Out</p>
                    <button class="btn btn-primary" id="checkout" value="{{ Auth::user()->id }},{{ $data->projectactivitydetail_id }}">Check Out</button>
                </div>
            @else
                <div class="icon">
                    <i class="fa fa-home"></i>
                    <p>{{ $data->waktuSelesai }}</p>
                </div>
            @endif
        </div>
    </div>
</div>
