@section('pre_header')
    @if(!$event->is_live)
        <style>
            .sidebar {
                top: 43px;
            }
        </style>
        <div class="alert alert-warning top_of_page_alert">
            {{trans('ManageEvent/Partials/TopNav.event_not_visible_to_public')}} <a href="{{route('MakeEventLive', ['event_id' => $event->id])}}">{{trans('ManageEvent/Partials/TopNav.click_to_make_it_live')}}</a> .
        </div>
    @endif
@stop
<ul class="nav navbar-nav navbar-left">
    <!-- Show Side Menu -->
    <li class="navbar-main">
        <a href="javascript:void(0);" class="toggleSidebar" title="Show sidebar">
            <span class="toggleMenuIcon">
                <span class="icon ico-menu"></span>
            </span>
        </a>
    </li>
    <!--/ Show Side Menu -->
    <li class="nav-button">
        <a target="_blank" href="{{$event->event_url}}">
            <span>
                <i class="ico-eye2"></i>&nbsp;{{trans('ManageEvent/Partials/TopNav.event_page')}}
            </span>
        </a>
    </li>
</ul>
