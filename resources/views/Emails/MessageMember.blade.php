@extends('Emails.Layouts.Master')

@section('preheader')
Hi {{$member->full_name}}！您有来自云麓谷的通知哦（使用微信查看邮件可能产生错乱）
@stop

@section('message_content')
<td>
  <p>Hi {{$member->full_name}}</p>

  <p style="padding: 10px; margin:10px; border: 1px solid #f3f3f3;">
      {{nl2br($message_content)}}
  </p>

  <p>
    您可以联系<b>{{{$member->organiser->name}}}</b> at <a href='mailto:{{{$member->organiser->email}}}'>{{{$member->organiser->email}}}</a>, 或直接回复此邮件
  </p>
@stop

@section('footer')


@stop
