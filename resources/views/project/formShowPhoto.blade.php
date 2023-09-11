<div class="panel card-background-color">
    <div class="panel-heading">
        <h3>Foto Pekerjaan</h3>
    </div>
</div>
<div class="panel card-background-color">
    @foreach ($data as $row)
        <div class="panel-heading">
            <h5>{{ $row['name'] }}</h5>
        </div>
        <div class="panel-body row">
            <div class="left col-md-6">
                <div id="myCarousel-{{ $row['users_id'] }}" class="carousel slide" data-ride="carousel"
                    data-interval="false">
                    @php
                        $images = explode(',', $row['image']);
                        $lats = explode(',', $row['latitude']);
                        $longs = explode(',', $row['longitude']);
                    @endphp
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        @for ($i = 0; $i < count($images); $i++)
                            @if ($i == 0)
                                <li id="data-{{ $row['users_id'] }}" data-target="#myCarousel"
                                    data-slide-to="{{ $i }}" class="active"
                                    data-latlong="{{ $lats[$i] }},{{ $longs[$i] }}">
                                </li>
                            @else
                                <li id="data-{{ $row['users_id'] }}" data-target="#myCarousel"
                                    data-slide-to="{{ $i }}"
                                    data-latlong="{{ $lats[$i] }},{{ $longs[$i] }}"></li>
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
                    <a class="left carousel-control carousel-change-btn" href="#myCarousel-{{ $row['users_id'] }}"
                        data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control carousel-change-btn" href="#myCarousel-{{ $row['users_id'] }}"
                        data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
            <div class="right col-md-6">
                <div id="map-{{ $row['users_id'] }}" class="geomap"></div>
            </div>
        </div>
    @endforeach
</div>
<div class="setAlign">
    <button type="button" class="btn btn-danger" id="btnClose" data-dismiss="modal">Tutup</button>
</div>
