@extends('Emails.Layouts.Master')

@section('preheader')
来自云麓谷的通知！请打开邮件确认（使用微信查看邮件可能产生错乱）
@stop

@section('message_content')
<td>
  <p>Hi {{$full_name}}</p>
  <p>
      您的二维码：
  </p>
  <div class="barcode">
      {!! DNS2D::getBarcodeSVG($api_token, "QRCODE") !!}
  </div>
  <p>
      如果您有任何问题或者建议请回复此邮件！谢谢您的支持！
  </p>
  <p>
      Thank you
  </p>
</td>
@stop

@section('footer')


@stop
