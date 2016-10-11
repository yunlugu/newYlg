{{-- @todo Rewrite the JS for choosing event bg images and colours. --}}
@extends('Shared.Layouts.Master')

@section('title')
    @parent
    自定义培训
@stop

@section('top_nav')
    @include('ManageEvent.Partials.TopNav')
@stop

@section('menu')
    @include('ManageEvent.Partials.Sidebar')
@stop

@section('page_title')
    <i class="ico-cog mr5"></i>
    自定义培训
@stop

@section('page_header')
    <style>
        .page-header {
            display: none;
        }
    </style>
@stop

@section('head')
    {!! HTML::script('https://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places') !!}
    {!! HTML::script('vendor/geocomplete/jquery.geocomplete.min.js') !!}
    <script>
        $(function () {

            $("input[name='organiser_fee_percentage']").TouchSpin({
                min: 0,
                max: 100,
                step: 0.1,
                decimals: 2,
                verticalbuttons: true,
                postfix: '%',
                buttondown_class: "btn btn-link",
                buttonup_class: "btn btn-link",
                postfix_extraclass: "btn btn-link"
            });
            $("input[name='organiser_fee_fixed']").TouchSpin({
                min: 0,
                max: 100,
                step: 0.1,
                decimals: 2,
                verticalbuttons: true,
                postfix: '{{$event->currency->symbol_left}}',
                buttondown_class: "btn btn-link",
                buttonup_class: "btn btn-link",
                postfix_extraclass: "btn btn-link"
            });

            /* Affiliate generator */
            $('#affiliateGenerator').on('keyup', function () {
                var text = $(this).val().replace(/\W/g, ''),
                        referralUrl = '{{$event->event_url}}?ref=' + text;

                $('#referralUrl').toggle(text !== '');
                $('#referralUrl input').val(referralUrl);
            });

            /* Background selector */
            $('.bgImage').on('click', function (e) {
                $('.bgImage').removeClass('selected');
                $(this).addClass('selected');
                $('input[name=bg_image_path_custom]').val($(this).data('src'));

                var replaced = replaceUrlParam('{{route('showEventPagePreview', ['event_id'=>$event->id])}}', 'bg_img_preview', $('input[name=bg_image_path_custom]').val());
                document.getElementById('previewIframe').src = replaced;
                e.preventDefault();
            });

            /* Background color */
            $('input[name=bg_color]').on('change', function (e) {
                var replaced = replaceUrlParam('{{route('showEventPagePreview', ['event_id'=>$event->id])}}', 'bg_color_preview', $('input[name=bg_color]').val().substring(1));
                document.getElementById('previewIframe').src = replaced;
                e.preventDefault();
            });

            $('#bgOptions .panel').on('shown.bs.collapse', function (e) {
                var type = $(e.currentTarget).data('type');
                console.log(type);
                $('input[name=bg_type]').val(type);
            });

            $('input[name=bg_image_path], input[name=bg_color]').on('change', function () {
                //showMessage('Uploading...');
                //$('.customizeForm').submit();
            });

            /* Color picker */
            $('.colorpicker').minicolors();

            $('#ticket_design .colorpicker').on('change', function (e) {
                var borderColor = $('input[name="ticket_border_color"]').val();
                var bgColor = $('input[name="ticket_bg_color"]').val();
                var textColor = $('input[name="ticket_text_color"]').val();
                var subTextColor = $('input[name="ticket_sub_text_color"]').val();

                $('.ticket').css({
                    'border': '1px solid ' + borderColor,
                    'background-color': bgColor,
                    'color': subTextColor,
                    'border-left-color': borderColor
                });
                $('.ticket h4').css({
                    'color': textColor
                });
                $('.ticket .logo').css({
                    'border-left': '1px solid ' + borderColor,
                    'border-bottom': '1px solid ' + borderColor
                });
                $('.ticket .barcode').css({
                    'border-right': '1px solid ' + borderColor,
                    'border-bottom': '1px solid ' + borderColor,
                    'border-top': '1px solid ' + borderColor
                });

            });

            $('#enable_offline_payments').change(function () {
                $('.offline_payment_details').toggle(this.checked);
            }).change();
        });


    </script>

    <style type="text/css">
        .bootstrap-touchspin-postfix {
            background-color: #ffffff;
            color: #333;
            border-left: none;
        }

        .bgImage {
            cursor: pointer;
        }

        .bgImage.selected {
            outline: 4px solid #0099ff;
        }
    </style>
    <script>
        $(function () {

            var hash = document.location.hash;
            var prefix = "tab_";
            if (hash) {
                $('.nav-tabs a[href=' + hash + ']').tab('show');
            }

            $(window).on('hashchange', function () {
                var newHash = location.hash;
                if (typeof newHash === undefined) {
                    $('.nav-tabs a[href=' + '#general' + ']').tab('show');
                } else {
                    $('.nav-tabs a[href=' + newHash + ']').tab('show');
                }

            });

            $('.nav-tabs a').on('shown.bs.tab', function (e) {
                window.location.hash = e.target.hash;
            });

        });


    </script>

@stop


@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- tab -->
            <ul class="nav nav-tabs">
                <li data-route="{{route('showEventCustomizeTab', ['event_id' => $event->id, 'tab' => 'general'])}}"
                    class="{{($tab == 'general' || !$tab) ? 'active' : ''}}"><a href="#general" data-toggle="tab">基本设置</a>
                </li>
                <li data-route="{{route('showEventCustomizeTab', ['event_id' => $event->id, 'tab' => 'design'])}}"
                    class="{{$tab == 'design' ? 'active' : ''}}"><a href="#design" data-toggle="tab">培训详情页设定</a></li>
                <!-- <li data-route="{{route('showEventCustomizeTab', ['event_id' => $event->id, 'tab' => 'order_page'])}}"
                    class="{{$tab == 'order_page' ? 'active' : ''}}"><a href="#order_page" data-toggle="tab">Order
                        Form</a></li> -->

                <li data-route="{{route('showEventCustomizeTab', ['event_id' => $event->id, 'tab' => 'social'])}}"
                    class="{{$tab == 'social' ? 'active' : ''}}"><a href="#social" data-toggle="tab">分享</a></li>
                <!-- <li data-route="{{route('showEventCustomizeTab', ['event_id' => $event->id, 'tab' => 'affiliates'])}}"
                    class="{{$tab == 'affiliates' ? 'active' : ''}}"><a href="#affiliates"
                                                                        data-toggle="tab">Affiliates</a></li> -->
                <!-- <li data-route="{{route('showEventCustomizeTab', ['event_id' => $event->id, 'tab' => 'fees'])}}"
                    class="{{$tab == 'fees' ? 'active' : ''}}"><a href="#fees" data-toggle="tab">Service Fees</a></li> -->
                <!-- <li data-route="{{route('showEventCustomizeTab', ['event_id' => $event->id, 'tab' => 'ticket_design'])}}"
                    class="{{$tab == 'ticket_design' ? 'active' : ''}}"><a href="#ticket_design" data-toggle="tab">Ticket
                        Design</a></li> -->
            </ul>
            <!--/ tab -->
            <!-- tab content -->
            <div class="tab-content panel">
                <div class="tab-pane {{($tab == 'general' || !$tab) ? 'active' : ''}}" id="general">
                    @include('ManageEvent.Partials.EditEventForm', ['event'=>$event, 'organisers'=>\Auth::user()->account->organisers])
                </div>

                <div class="tab-pane {{$tab == 'social' ? 'active' : ''}}" id="social">
                    <div class="well hide">
                        <h5>The following short codes are available for use:</h5>
                        Display the event's public URL: <code>[event_url]</code><br>
                        Display the organiser's name: <code>[organiser_name]</code><br>
                        Display the event title: <code>[event_title]</code><br>
                        Display the event description: <code>[event_description]</code><br>
                        Display the event start date & time: <code>[event_start_date]</code><br>
                        Display the event end date & time: <code>[event_end_date]</code>
                    </div>

                    {!! Form::model($event, array('url' => route('postEditEventSocial', ['event_id' => $event->id]), 'class' => 'ajax ')) !!}

                    <h4>分享设置</h4>

                    <div class="form-group hide">

                        {!! Form::label('social_share_text', 'Social Share Text', array('class'=>'control-label ')) !!}

                        {!!  Form::textarea('social_share_text', $event->social_share_text, [
                            'class' => 'form-control',
                            'rows' => 4
                        ])  !!}
                        <div class="help-block">
                            This is the text which will be share by default when a user shares your event on social
                            networks
                        </div>

                    </div>
                    <div class="form-group">
                        <label class="control-label">要展示的分享按钮</label>
                        <br>

                        <div class="custom-checkbox mb5">
                            {!! Form::checkbox('social_show_facebook', 1, $event->social_show_facebook, ['id' => 'social_show_facebook', 'data-toggle' => 'toggle']) !!}
                            {!! Form::label('social_show_facebook', 'Facebook') !!}
                        </div>
                        <div class="custom-checkbox mb5">

                            {!! Form::checkbox('social_show_twitter', 1, $event->social_show_twitter, ['id' => 'social_show_twitter', 'data-toggle' => 'toggle']) !!}
                            {!! Form::label('social_show_twitter', 'Twitter') !!}

                        </div>

                        <div class="custom-checkbox mb5">
                            {!! Form::checkbox('social_show_email', 1, $event->social_show_email, ['id' => 'social_show_email', 'data-toggle' => 'toggle']) !!}
                            {!! Form::label('social_show_email', 'Email') !!}
                        </div>
                        <div class="custom-checkbox mb5">
                            {!! Form::checkbox('social_show_googleplus', 1, $event->social_show_googleplus, ['id' => 'social_show_googleplus', 'data-toggle' => 'toggle']) !!}
                            {!! Form::label('social_show_googleplus', 'Google+') !!}
                        </div>
                        <div class="custom-checkbox mb5">
                            {!! Form::checkbox('social_show_linkedin', 1, $event->social_show_linkedin, ['id' => 'social_show_linkedin', 'data-toggle' => 'toggle']) !!}
                            {!! Form::label('social_show_linkedin', 'LinkedIn') !!}
                        </div>
                        <div class="custom-checkbox">

                            {!! Form::checkbox('social_show_whatsapp', 1, $event->social_show_whatsapp, ['id' => 'social_show_whatsapp', 'data-toggle' => 'toggle']) !!}
                            {!! Form::label('social_show_whatsapp', 'WhatsApp') !!}


                        </div>
                    </div>

                    <div class="panel-footer mt15 text-right">
                        {!! Form::submit('Save Changes', ['class'=>"btn btn-success"]) !!}
                    </div>

                    {!! Form::close() !!}

                </div>
                <div class="tab-pane scale_iframe {{$tab == 'design' ? 'active' : ''}}" id="design">

                    <div class="row">
                        <div class="col-sm-6">

                            {!! Form::open(array('url' => route('postEditEventDesign', ['event_id' => $event->id]), 'files'=> true, 'class' => 'ajax customizeForm')) !!}

                            {!! Form::hidden('bg_type', $event->bg_type) !!}

                            <h4>背景设置</h4>

                            <div class="panel-group" id="bgOptions">

                                <div class="panel panel-default" data-type="color">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#bgOptions" href="#bgColor"
                                               class="{{($event->bg_type == 'color') ? '' : 'collapsed'}}">
                                                <span class="arrow mr5"></span> 背景使用纯色
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="bgColor"
                                         class="panel-collapse {{($event->bg_type == 'color') ? 'in' : 'collapse'}}">
                                        <div class="panel-body">
                                            {!! Form::text('bg_color', $event->bg_color, ['class' => 'colorpicker form-control']) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="panel panel-default" data-type="image">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#bgOptions" href="#bgImage"
                                               class="{{($event->bg_type == 'image') ? '' : 'collapsed'}}">
                                                <span class="arrow mr5"></span> 选择背景图片
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="bgImage"
                                         class="panel-collapse {{($event->bg_type == 'image') ? 'in' : 'collapse'}}">
                                        <div class="panel-body">
                                            @foreach($available_bg_images_thumbs as $bg_image)

                                                <img data-3="{{str_replace('/thumbs', '', $event->bg_image_path)}}"
                                                     class="img-thumbnail ma5 bgImage {{ ($bg_image === str_replace('/thumbs', '', $event->bg_image_path) ? 'selected' : '') }}"
                                                     style="width: 120px;" src="{{asset($bg_image)}}"
                                                     data-src="{{str_replace('/thumbs', '', substr($bg_image,1))}}"/>

                                            @endforeach

                                            {!! Form::hidden('bg_image_path_custom', ($event->bg_type == 'image') ? $event->bg_image_path : '') !!}
                                        </div>
                                            <a class="btn btn-link" href="https://pixabay.com?ref=attendize" title="PixaBay Free Images">
                                            Images Provided By <b>PixaBay.com</b>
                                            </a>
                                    </div>
                                </div>

                            </div>
                            <div class="panel-footer mt15 text-right">
                                <span class="uploadProgress" style="display:none;"></span>
                                {!! Form::submit('保存更改', ['class'=>"btn btn-success"]) !!}
                            </div>

                            <div class="panel-footer ar hide">
                                {!! Form::button('Cancel', ['class'=>"btn modal-close btn-danger",'data-dismiss'=>'modal']) !!}
                                {!! Form::submit('保存更改', ['class'=>"btn btn-success"]) !!}
                            </div>

                            {!! Form::close() !!}

                        </div>
                        <div class="col-sm-6">
                            <h4>详情页预览</h4>

                            <div class="iframe_wrap" style="overflow:hidden; height: 600px; border: 1px solid #ccc;">
                                <iframe id="previewIframe"
                                        src="{{route('showEventPagePreview', ['event_id'=>$event->id])}}"
                                        frameborder="0" style="overflow:hidden;height:100%;width:100%" height="100%"
                                        width="100%">
                                </iframe>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <!--/ tab content -->
        </div>
    </div>
@stop
