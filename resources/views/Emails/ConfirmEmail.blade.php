@extends('Emails.Layouts.Master')

@section('preheader')
欢迎注册云麓谷！请打开邮件确认（使用微信查看邮件可能产生错乱）
@stop

@section('message_content')
<td>
  <p>Hi {{$full_name}}</p>
  <p>感谢注册云麓谷！请点击下方按钮进行验证！</p>
  <p>
      如按钮异常请点此<a href="{{route('confirmEmail', ['confirmation_code' => $confirmation_code])}}" target="_blank">{{route('confirmEmail', ['confirmation_code' => $confirmation_code])}}</a>进行验证
  </p>
  <table border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
    <tbody>
      <tr>
        <td align="left">
          <table border="0" cellpadding="0" cellspacing="0">
            <tbody>
              <tr>
                <td> <a href="{{route('confirmEmail', ['confirmation_code' => $confirmation_code])}}" target="_blank">点我点我点我</a> </td>
              </tr>
            </tbody>
          </table>
        </td>
      </tr>
    </tbody>
  </table>
  <p>
      如按钮异常请点此<a href="{{route('confirmEmail', ['confirmation_code' => $confirmation_code])}}" target="_blank">{{route('confirmEmail', ['confirmation_code' => $confirmation_code])}}</a>进行验证
  </p>
  <p>
      我的二维码：
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
