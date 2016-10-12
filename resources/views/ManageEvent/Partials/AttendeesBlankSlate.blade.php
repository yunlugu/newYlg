@extends('Shared.Layouts.BlankSlate')


@section('blankslate-icon-class')
    ico-users
@stop

@section('blankslate-title')
    No Members Yet
@stop

@section('blankslate-text')
    成员注册后会显示在这里，目前没有成员
@stop

@section('blankslate-body')
<button data-modal-id="InviteAttendee" href="javascript:void(0);"  data-href="{{route('showAddMember', ['organiser_id'=>$organiser->id])}}" class="loadModal btn btn-success" type="button"><i class="ico-user-plus"></i>
    添加成员
</button>
@stop
