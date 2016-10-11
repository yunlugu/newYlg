@extends('Shared.Layouts.Master')

@section('title')
    @parent
    Organiser Events
    {{trans('ManageOrganiser/Events.organiser_events')}}
@stop

@section('page_title')
    {{$organiser->name}} 培训
@stop

@section('top_nav')
    @include('ManageOrganiser.Partials.TopNav')
@stop

@section('head')
    {!!HTML::script('https://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places')!!}
    {!! HTML::script('vendor/geocomplete/jquery.geocomplete.min.js')!!}
@stop

@section('menu')
    @include('ManageOrganiser.Partials.Sidebar')
@stop

@section('page_header')
    <div class="col-md-9">
        <div class="btn-toolbar">
            <div class="btn-group btn-group-responsive">
                <a href="#" data-modal-id="CreateEvent" data-href="{{route('showCreateEvent', ['organiser_id' => @$organiser->id])}}" class="btn btn-success loadModal"><i class="ico-plus"></i> {{trans('ManageOrganiser/Events.create_event')}}</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        {!! Form::open(array('url' => route('showOrganiserEvents', ['organiser_id'=>$organiser->id]), 'method' => 'get')) !!}
        <div class="input-group">
            <input name="q" value="{{$search['q'] or ''}}" placeholder="{{trans('ManageOrganiser/Events.search_events')}}" type="text" class="form-control">
        <span class="input-group-btn">
            <button class="btn btn-default" type="submit"><i class="ico-search"></i></button>
        </span>
        </div>
        <input type="hidden" name='sort_by' value="{{$search['sort_by']}}"/>
        {!! Form::close() !!}
    </div>
@stop

@section('content')

    @if($events->count())
        <div class="row">
            <div class="col-md-3 col-xs-6">
                <div class="order_options">
                    <span class="event_count">
                        {{$organiser->events->count()}} 次培训
                    </span>
                </div>
            </div>
            <div class="col-md-2 col-xs-6 col-md-offset-7">
                <div class="order_options">
                    {!!Form::select('sort_by_select', [
                        'start_date' => trans('ManageOrganiser/Events.start_date'),
                        'created_at' => trans('ManageOrganiser/Events.created'),
                        'title' => trans('ManageOrganiser/Events.event_title')

                        ], $search['sort_by'], ['class' => 'form-control pull right'])!!}
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        @if($events->count())
            @foreach($events as $event)
                <div class="col-md-6 col-sm-6 col-xs-12">
                    @include('ManageOrganiser.Partials.EventPanel')
                </div>
            @endforeach
        @else
            @if($search['q'])
                @include('Shared.Partials.NoSearchResults')
            @else
                @include('ManageOrganiser.Partials.EventsBlankSlate')
            @endif
        @endif
    </div>
    <div class="row">
        <div class="col-md-12">
            {!! $events->appends(['q' =>$search['q'], 'past' => $search['showPast']])->render() !!}
        </div>
    </div>
@stop