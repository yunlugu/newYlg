@extends('Shared.Layouts.Master')

@section('title')
@parent
Event Attendees
@stop


@section('page_title')
<i class="ico-users"></i>
Attendees
@stop

@section('top_nav')
@include('ManageEvent.Partials.TopNav')
@stop

@section('menu')
@include('ManageEvent.Partials.Sidebar')
@stop


@section('head')

@stop

@section('page_header')

<div class="col-md-9">
    <div class="btn-toolbar" role="toolbar">
        <!-- <div class="btn-group btn-group-responsive">
            <button data-modal-id="InviteAttendee" href="javascript:void(0);"  data-href="{{route('showInviteAttendee', ['event_id'=>$event->id])}}" class="loadModal btn btn-success" type="button"><i class="ico-user-plus"></i> Invite Attendee</button>
        </div>

        <div class="btn-group btn-group-responsive">
            <button data-modal-id="ImportAttendees" href="javascript:void(0);"  data-href="{{route('showImportAttendee', ['event_id'=>$event->id])}}" class="loadModal btn btn-success" type="button"><i class="ico-file"></i> Invite Attendees</button>
        </div> -->

        <div class="btn-group btn-group-responsive">
            <a class="btn btn-success" href="{{route('showPrintAttendees', ['event_id'=>$event->id])}}" target="_blank" ><i class="ico-print"></i> 打印签到列表</a>
        </div>
        <div class="btn-group btn-group-responsive">
            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                <i class="ico-users"></i> 导出 <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li><a href="{{route('showExportAttendees', ['event_id'=>$event->id,'export_as'=>'xlsx'])}}">Excel (XLSX)</a></li>
                <li><a href="{{route('showExportAttendees', ['event_id'=>$event->id,'export_as'=>'xls'])}}">Excel (XLS)</a></li>
                <li><a href="{{route('showExportAttendees', ['event_id'=>$event->id,'export_as'=>'csv'])}}">CSV</a></li>
                <li><a href="{{route('showExportAttendees', ['event_id'=>$event->id,'export_as'=>'html'])}}">HTML</a></li>
            </ul>
        </div>
        <div class="btn-group btn-group-responsive">
            <button data-modal-id="MessageAttendees" href="javascript:void(0);" data-href="{{route('showMessageAttendees', ['event_id'=>$event->id])}}" class="loadModal btn btn-success" type="button"><i class="ico-envelope"></i> 发邮件</button>
        </div>
    </div>
</div>
<div class="col-md-3">
   {!! Form::open(array('url' => route('showEventAttendees', ['event_id'=>$event->id,'sort_by'=>$sort_by]), 'method' => 'get')) !!}
    <div class="input-group">
        <input name="q" value="{{$q or ''}}" placeholder="搜索签到人员" type="text" class="form-control" />
        <span class="input-group-btn">
            <button class="btn btn-default" type="submit"><i class="ico-search"></i></button>
        </span>
    </div>
   {!! Form::close() !!}
</div>
@stop


@section('content')

<!--Start Attendees table-->
<div class="row">
    <div class="col-md-12">
        @if($attendees->count())
        <div class="panel">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>
                               {!!Html::sortable_link('姓名', $sort_by, 'full_name', $sort_order, ['q' => $q , 'page' => $attendees->currentPage()])!!}
                            </th>
                            <th>
                               {!!Html::sortable_link('Email', $sort_by, 'email', $sort_order, ['q' => $q , 'page' => $attendees->currentPage()])!!}
                            </th>
                            <th>
                               {!!Html::sortable_link('签到时间', $sort_by, 'created_at', $sort_order, ['q' => $q , 'page' => $attendees->currentPage()])!!}
                            </th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attendees as $attendee)
                        <tr class="attendee_{{$attendee->id}} {{$attendee->is_cancelled ? 'danger' : ''}}">
                            <td>{{{$attendee->member->full_name}}}</td>
                            <td>
                                <a data-modal-id="MessageAttendee" href="javascript:void(0);" class="loadModal"
                                    data-href="{{route('showMessageAttendee', ['attendee_id'=>$attendee->id])}}"
                                    > {{$attendee->email}}</a>
                            </td>
                            <td>{{$attendee->created_at}}</td>

                            <td class="text-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-xs btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">操作 <span class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                        @if($attendee->email)
                                        <li><a
                                            data-modal-id="MessageAttendee"
                                            href="javascript:void(0);"
                                            data-href="{{route('showMessageAttendee', ['attendee_id'=>$attendee->id])}}"
                                            class="loadModal"
                                            > 邮件</a></li>
                                        @endif
                                        <!-- <li><a
                                            data-modal-id="ResendTicketToAttendee"
                                            href="javascript:void(0);"
                                            data-href="{{route('showResendTicketToAttendee', ['attendee_id'=>$attendee->id])}}"
                                            class="loadModal"
                                            > Resend Ticket</a></li> -->
                                        <!-- <li><a
                                            href="{{route('showExportTicket', ['event_id'=>$event->id, 'attendee_id'=>$attendee->id])}}"
                                            >Download PDF Ticket</a></li> -->
                                    </ul>
                                </div>

                                <!-- <a
                                    data-modal-id="EditAttendee"
                                    href="javascript:void(0);"
                                    data-href="{{route('showEditAttendee', ['event_id'=>$event->id, 'attendee_id'=>$attendee->id])}}"
                                    class="loadModal btn btn-xs btn-primary"
                                    > 编辑</a> -->

                                <a
                                    data-modal-id="CancelAttendee"
                                    href="javascript:void(0);"
                                    data-href="{{route('showCancelAttendee', ['event_id'=>$event->id, 'attendee_id'=>$attendee->id])}}"
                                    class="loadModal btn btn-xs btn-danger"
                                    > 取消</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @else

        @if(!empty($q))
        @include('Shared.Partials.NoSearchResults')
        @else
        @include('ManageEvent.Partials.AttendeesBlankSlate')
        @endif

        @endif
    </div>
    <div class="col-md-12">
        {!!$attendees->appends(['sort_by' => $sort_by, 'sort_order' => $sort_order, 'q' => $q])->render()!!}
    </div>
</div>    <!--/End attendees table-->

@stop
