@extends('Shared.Layouts.MasterWithoutMenus')

@section('title')
Sign Up
@stop

@section('content')
    <div id="app" class="row">
        <p>
            提交成功！
        </p>
    </div>
    {!! HTML::script('assets/javascript/signup.js') !!}
@stop
