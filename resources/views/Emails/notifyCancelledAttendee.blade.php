@extends('Emails.Layouts.Master')

@section('preheader')
签到记录取消通知，请打开邮件确认（使用微信查看邮件可能产生错乱）
@stop

@section('message_content')

<td>
  <p>Hi {{$attendee->member->full_name}}</p>
  <p>您在 <b>{{{$attendee->event->title}}}</b>的签到记录已经被取消。</p>
  <p>
      如有疑问请联系 <b>{{{$attendee->event->organiser->name}}}</b> at <a href='mailto:{{{$attendee->event->organiser->email}}}'>{{{$attendee->event->organiser->email}}}</a> 或回复此邮件。谢谢您的支持！
  </p>
  <p>
      Thank you
  </p>
</td>

@stop

@section('footer')

@stop
