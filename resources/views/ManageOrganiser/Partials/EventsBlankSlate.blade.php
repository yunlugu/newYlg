@extends('Shared.Layouts.BlankSlate')

@section('blankslate-icon-class')
    ico-ticket
@stop

@section('blankslate-title')
    {{trans('ManageOrganiser/Partials/EventsBlankSlate.no_events_yet')}}
@stop

@section('blankslate-text')
    {{trans('ManageOrganiser/Partials/EventsBlankSlate.have_yet_to_create')}}
@stop

@section('blankslate-body')
<button data-invoke="modal" data-modal-id="CreateEvent" data-href="{{route('showCreateEvent', ['organiser_id' => $organiser->id])}}" href='javascript:void(0);'  class="btn btn-success mt5 btn-lg" type="button">
    <i class="ico-ticket"></i>
    {{trans('ManageOrganiser/Partials/EventsBlankSlate.create_event')}}
</button>
@stop
