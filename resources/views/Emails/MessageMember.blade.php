@extends('Emails.Layouts.Master')

@section('preheader')
欢迎注册云麓谷！请打开邮件确认（使用微信查看邮件可能产生错乱）
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
