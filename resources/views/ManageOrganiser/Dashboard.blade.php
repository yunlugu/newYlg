@extends('Shared.Layouts.Master')

@section('title')
    @parent
    {{trans('ManageOrganiser/Dashboard.dashboard')}}
@stop

@section('top_nav')
    @include('ManageOrganiser.Partials.TopNav')
@stop
@section('page_title')
    {{ $organiser->name }} {{trans('ManageOrganiser/Dashboard.dashboard')}}
@stop

@section('menu')
    @include('ManageOrganiser.Partials.Sidebar')
@stop

@section('head')

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

    {!! HTML::script('https://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places') !!}
    {!! HTML::script('vendor/geocomplete/jquery.geocomplete.min.js')!!}
    {!! HTML::script('vendor/moment/moment.js')!!}
    {!! HTML::script('vendor/fullcalendar/dist/fullcalendar.min.js')!!}
    {!! HTML::style('vendor/fullcalendar/dist/fullcalendar.css')!!}

    <script>
        $(function() {
           $('#calendar').fullCalendar({
               events: {!! $calendar_events !!},
            header: {
                left:   'prev,',
                center: 'title',
                right:  'next'
            },
            dayClick: function(date, jsEvent, view) {

               }
           });
        });
    </script>
@stop

@section('content')
    <div class="row">
        <div class="col-sm-4">
            <div class="stat-box">
                <h3>
                    {{$organiser->events->count()}}
                </h3>
            <span>
                {{trans('ManageOrganiser/Dashboard.events')}}
            </span>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="stat-box">
                <h3>
                    {{$organiser->members->count()}}
                </h3>
            <span>
                成员
            </span>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="stat-box">
                <h3>
                    {{ $organiser->departments->count() }}
                </h3>
            <span>
                部门
            </span>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-md-8">

            <h4 style="margin-bottom: 25px;margin-top: 20px;">{{trans('ManageOrganiser/Dashboard.event_calender')}}</h4>
                    <div id="calendar"></div>

        </div>
        <div class="col-md-4">
            <h4 style="margin-bottom: 25px;margin-top: 20px;">{{trans('ManageOrganiser/Dashboard.upcoming_event')}}</h4>
            @if($upcoming_events->count())
                @foreach($upcoming_events as $event)
                    @include('ManageOrganiser.Partials.EventPanel')
                @endforeach
            @else
                <div class="alert alert-success alert-lg">
                    {{trans('ManageOrganiser/Dashboard.no_event_coming_up')}} <a href="#"
                                                     data-href="{{route('showCreateEvent', ['organiser_id' => $organiser->id])}}"
                                                     class=" loadModal">{{trans('ManageOrganiser/Dashboard.click_to_create_an_event')}}</a>
                </div>
            @endif

        </div>

    </div>
@stop
