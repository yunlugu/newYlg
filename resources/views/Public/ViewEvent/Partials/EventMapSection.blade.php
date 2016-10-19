<section id="location" class="container p0">
    <div class="row">
        <div class="col-md-12">
            <div class="google-maps content">
                @if($event->location_is_manual)
                <iframe frameborder="0" style="border:0;" src="http://m.amap.com/navi/?dest=112.935457,28.158706&destName=二食堂4楼409（猜的）&hideRouteIcon=1&key=02d2735755ffafa30dd2e2ea125b5ed7"></iframe>
                @else
                <iframe frameborder="0" style="border:0;" src="http://m.amap.com/navi/?dest={{$event->location_coordinate}}&destName={{$event->location_name}}&hideRouteIcon=1&key=02d2735755ffafa30dd2e2ea125b5ed7"></iframe>
                @endif
            </div>
        </div>
    </div>
</section>
