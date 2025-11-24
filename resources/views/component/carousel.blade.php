<div id="carouselExampleControls" class="carousel slide my-1" data-ride="carousel">
    <div class="carousel-inner">
        @if($carouselItems->isEmpty())
            <div class="carousel-item active">
                <span class="text-center">
                    <b>No hay texto disponible</b>
                </span>
            </div>
        @else
            @foreach($carouselItems as $key => $item)
                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                    <span class="text-center">
                        <span style="font-size: 1.4rem; font-weight:700;">{{ $item->text1 }}</span>
                        @if($item->text2)
                            <br>{{ $item->text2 }}
                        @endif
                        @if($item->link_text && $item->link_url)
                            <br>
                            <a href="{{ $item->link_url }}">
                                <span>{{ $item->link_text }}</span>
                            </a>
                        @endif
                    </span>
                </div>
            @endforeach
        @endif
    </div>
    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>
