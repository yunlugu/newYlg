<footer id="footer" class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                @include('Shared.Partials.PoweredBy')

                @if(Utils::userOwns($event))
                &bull;
                <a class="adminLink " href="{{route('showEventDashboard' , ['event_id' => $event->id])}}">培训面板</a>
                &bull;
                <a class="adminLink "
                   href="{{route('showOrganiserDashboard' , ['organiser_id' => $event->organiser->id])}}">管理员面板</a>
                @endif
            </div>
        </div>
    </div>
</footer>
{{--Admin Links--}}
