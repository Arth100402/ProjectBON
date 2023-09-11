<div id="myCarousel" class="carousel slide" data-ride="carousel">
    @php
        $images = explode(',', $data['imagekmawalakhir']);
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
