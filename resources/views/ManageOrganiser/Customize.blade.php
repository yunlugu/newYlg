@extends('Shared.Layouts.Master')

@section('title')
    @parent
    {{trans('ManageOrganiser/Customize.organiser_events')}}
@stop

@section('page_title')
    {{$organiser->name}} {{trans('ManageOrganiser/Customize.events')}}
@stop

@section('top_nav')
    @include('ManageOrganiser.Partials.TopNav')
@stop

@section('head')
    <style>
        .page-header {
            display: none;
        }
    </style>
    <script>
        $(function () {
            $('.colorpicker').minicolors({
                changeDelay: 500,
                change: function () {
                    var replaced = replaceUrlParam('{{route('showOrganiserHome', ['organiser_id'=>$organiser->id])}}', 'preview_styles', encodeURIComponent($('#OrganiserPageDesign form').serialize()));
                    document.getElementById('previewIframe').src = replaced;
                }
            });

        });
    </script>
@stop

@section('menu')
    @include('ManageOrganiser.Partials.Sidebar')
@stop

@section('page_header')

@stop

@section('content')

    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#organiserSettings" data-toggle="tab">{{trans('ManageOrganiser/Customize.organiser_settings')}}</a>
                </li>
                <li>
                    <a href="#OrganiserPageDesign" data-toggle="tab">{{trans('ManageOrganiser/Customize.organiser_page_design')}}</a>
                </li>
            </ul>
            <div class="tab-content panel">
                <div class="tab-pane active" id="organiserSettings">
                    {!! Form::model($organiser, array('url' => route('postEditOrganiser', ['organiser_id' => $organiser->id]), 'class' => 'ajax')) !!}

                    <div class="form-group">
                        {!! Form::label('enable_organiser_page', trans('ManageOrganiser/Customize.enable_public_organiser_page'), array('class'=>'control-label required')) !!}
                        {!!  Form::select('enable_organiser_page', [
                        '1' => trans('ManageOrganiser/Customize.make_organiser_page_visible'),
                        '0' => trans('ManageOrganiser/Customize.hide_organiser_page')],Input::old('enable_organiser_page'),
                                                    array(
                                                    'class'=>'form-control'
                                                    ))  !!}
                        <div class="help-block">
                            {{trans('ManageOrganiser/Customize.organiser_pages_cotain_events_list')}}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('name', trans('ManageOrganiser/Customize.organiser_name'), array('class'=>'required control-label ')) !!}
                        {!!  Form::text('name', Input::old('name'),
                                                array(
                                                'class'=>'form-control'
                                                ))  !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('email', trans('ManageOrganiser/Customize.organiser_email'), array('class'=>'control-label required')) !!}
                        {!!  Form::text('email', Input::old('email'),
                                                array(
                                                'class'=>'form-control ',
                                                'placeholder'=>''
                                                ))  !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('about', trans('ManageOrganiser/Customize.organiser_description'), array('class'=>'control-label ')) !!}
                        {!!  Form::textarea('about', Input::old('about'),
                                                array(
                                                'class'=>'form-control ',
                                                'placeholder'=>'',
                                                'rows' => 4
                                                ))  !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('google_analytics_code', trans('ManageOrganiser/Customize.organiser_analytics_code'), array('class'=>'control-label')) !!}
                        {!!  Form::text('google_analytics_code', Input::old('google_analytics_code'),
                                                array(
                                                'class'=>'form-control'
                                                ))  !!}
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('facebook', 'Organiser Facebook', array('class'=>'control-label ')) !!}

                                <div class="input-group">
                                    <span style="background-color: #eee;" class="input-group-addon">facebook.com/</span>
                                    {!!  Form::text('facebook', Input::old('facebook'),
                                                    array(
                                                    'class'=>'form-control ',
                                                    'placeholder'=>'Username'
                                                    ))  !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('twitter', 'Organiser Twitter', array('class'=>'control-label ')) !!}

                                <div class="input-group">
                                    <span style="background-color: #eee;" class="input-group-addon">twitter.com/</span>
                                    {!!  Form::text('twitter', Input::old('twitter'),
                                             array(
                                             'class'=>'form-control ',
                                             'placeholder'=>'Username'
                                             ))  !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(is_file($organiser->logo_path))
                        <div class="form-group">
                            {!! Form::label('current_logo', trans('ManageOrganiser/Customize.current_logo'), array('class'=>'control-label ')) !!}

                            <div class="thumbnail">
                                {!!HTML::image($organiser->logo_path)!!}
                                {!! Form::label('remove_current_image', trans('ManageOrganiser/Customize.delete_logo'), array('class'=>'control-label ')) !!}
                                {!! Form::checkbox('remove_current_image') !!}
                            </div>
                        </div>
                    @endif
                    <div class="form-group">
                        {!!  Form::labelWithHelp('organiser_logo', trans('ManageOrganiser/Customize.organiser_logo'), array('class'=>'control-label '),
                            trans('ManageOrganiser/Customize.recommend_square_image')) !!}
                        {!!Form::styledFile('organiser_logo')!!}
                    </div>
                    <div class="modal-footer">
                        {!! Form::submit(trans('ManageOrganiser/Customize.save_organiser'), ['class'=>"btn btn-success"]) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
                <div class="tab-pane scale_iframe" id="OrganiserPageDesign">
                    {!! Form::model($organiser, array('url' => route('postEditOrganiserPageDesign', ['event_id' => $organiser->id]), 'class' => 'ajax ')) !!}

                    <div class="row">

                        <div class="col-md-6">
                            <h4>{{trans('ManageOrganiser/Customize.organiser_design')}}</h4>

                            <div class="form-group">
                                {!! Form::label('page_header_bg_color', trans('ManageOrganiser/Customize.header_background_color'), ['class'=>'control-label required ']) !!}
                                {!!  Form::input('text', 'page_header_bg_color', Input::old('page_header_bg_color'),
                                                            [
                                                            'class'=>'form-control colorpicker',
                                                            'placeholder'=>'#000000'
                                                            ])  !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('page_text_color', trans('ManageOrganiser/Customize.text_color'), ['class'=>'control-label required ']) !!}
                                {!!  Form::input('text', 'page_text_color', Input::old('page_text_color'),
                                                            [
                                                            'class'=>'form-control colorpicker',
                                                            'placeholder'=>'#FFFFFF'
                                                            ])  !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('page_bg_color', trans('ManageOrganiser/Customize.background_color'), ['class'=>'control-label required ']) !!}
                                {!!  Form::input('text', 'page_bg_color', Input::old('page_bg_color'),
                                                            [
                                                            'class'=>'form-control colorpicker',
                                                            'placeholder'=>'#EEEEEE'
                                                            ])  !!}
                            </div>
                            <div class="form-group">

                            </div>
                        </div>
                        <div class="col-md-6">
                            <h4>{{trans('ManageOrganiser/Customize.organiser_page_preview')}}</h4>
                            <div class="preview iframe_wrap"
                                 style="overflow:hidden; height: 500px; border: 1px solid #ccc; overflow: hidden;">
                                <iframe id="previewIframe"
                                        src="{{ route('showOrganiserHome', ['organiser_id' => $organiser->id]) }}"
                                        frameborder="0" style="overflow:hidden;height:100%;width:100%" width="100%"
                                        height="100%"></iframe>
                            </div>
                        </div>


                    </div>

                    <div class="panel-footer mt15 text-right">
                        {!! Form::submit(trans('ManageOrganiser/Customize.save_changes'), ['class'=>"btn btn-success"]) !!}
                    </div>

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
@stop
