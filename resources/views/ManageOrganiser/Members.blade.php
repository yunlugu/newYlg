@extends('Shared.Layouts.Master')

@section('title')
@parent
 人员管理
@stop


@section('page_title')
<i class="ico-users"></i>
员工列表
@stop

@section('top_nav')
@include('ManageOrganiser.Partials.TopNav')
@stop

@section('menu')
@include('ManageOrganiser.Partials.Sidebar')
@stop


@section('head')

@stop

@section('page_header')

<div class="col-md-9">
    <div class="btn-toolbar" role="toolbar">
        <div class="btn-group btn-group-responsive">
            <button data-modal-id="InviteAttendee" href="javascript:void(0);"  data-href="{{route('showAddMember', ['organiser_id'=>$organiser->id])}}" class="loadModal btn btn-success" type="button"><i class="ico-user-plus"></i>添加用户</button>
        </div>

        <div class="btn-group btn-group-responsive">
            <button data-modal-id="ImportAttendees" href="javascript:void(0);"  data-href="#" class="loadModal btn btn-success" type="button"><i class="ico-file"></i> 批量导入</button>
        </div>

        <div class="btn-group btn-group-responsive">
            <a class="btn btn-success" href="#" target="_blank" ><i class="ico-print"></i> 打印</a>
        </div>
        <div class="btn-group btn-group-responsive">
            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                <i class="ico-users"></i> 导出 <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li><a href="#">Excel (XLSX)</a></li>
                <li><a href="#">Excel (XLS)</a></li>
                <li><a href="#">CSV</a></li>
                <li><a href="#">HTML</a></li>
            </ul>
        </div>
        <div class="btn-group btn-group-responsive">
            <button data-modal-id="MessageAttendees" href="javascript:void(0);" data-href="#" class="loadModal btn btn-success" type="button"><i class="ico-envelope"></i> 发邮件</button>
        </div>
    </div>
</div>
<div class="col-md-3">
   {!! Form::open(array('url' => route('showOrganiserMembers', ['organiser_id'=>$organiser->id,'sort_by'=>$sort_by]), 'method' => 'get')) !!}
    <div class="input-group">
        <input name="q" value="{{$q or ''}}" placeholder="搜索成员" type="text" class="form-control" />
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
        @if($members->count())
        <div class="panel">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th width="25%">
                               {!!Html::sortable_link('姓名', $sort_by, 'full_name', $sort_order, ['q' => $q , 'page' => $members->currentPage()])!!}
                            </th>
                            <th width="25%">
                               {!!Html::sortable_link('Email', $sort_by, 'email', $sort_order, ['q' => $q , 'page' => $members->currentPage()])!!}
                            </th>
                            <th width="20%">
                               {!!Html::sortable_link('加入时间', $sort_by, 'created_at', $sort_order, ['q' => $q , 'page' => $members->currentPage()])!!}
                            </th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($members as $member)
                        <tr class="attendee_{{$member->id}} {{$member->is_cancelled ? 'danger' : ''}}">
                            <td>{{{$member->full_name}}}</td>
                            <td>
                                <a data-modal-id="MessageAttendee" href="javascript:void(0);" class="loadModal"
                                    data-href=""
                                    > {{$member->email}}</a>
                            </td>
                            <td>
                                {{{$member->created_at}}}
                            </td>
                            <td>
                                <a href="javascript:void(0);" data-modal-id="view-order-" data-href="" title="View Order #" class="loadModal">

                                </a>
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-xs btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">操作 <span class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                        @if($member->email)
                                        <li><a
                                            data-modal-id="MessageAttendee"
                                            href="javascript:void(0);"
                                            data-href=""
                                            class="loadModal"
                                            > 发送邮件</a></li>
                                        @endif
                                        <li><a
                                            data-modal-id="ResendTicketToAttendee"
                                            href="javascript:void(0);"
                                            data-href=""
                                            class="loadModal"
                                            > Resend Ticket</a></li>
                                        <li><a
                                            href="#"
                                            >Download PDF Ticket</a></li>
                                    </ul>
                                </div>

                                <a
                                    data-modal-id="EditAttendee"
                                    href="javascript:void(0);"
                                    data-href="{{route('showEditMember', ['organiser_id'=>$organiser->id, 'member_id'=>$member->id])}}"
                                    class="loadModal btn btn-xs btn-primary"
                                    > 编辑</a>

                                <a
                                    data-modal-id="CancelAttendee"
                                    href="javascript:void(0);"
                                    data-href="{{route('showDeleteMember', ['organiser_id'=>$organiser->id, 'member_id'=>$member->id])}}"
                                    class="loadModal btn btn-xs btn-danger"
                                    > 删除</a>
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

    </div>
</div>    <!--/End attendees table-->

@stop
