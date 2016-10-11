@extends('Shared.Layouts.MasterWithoutMenus')

@section('title')
Sign Up
@stop

@section('content')
    <div id="app" class="row">
        <div class="col-md-7 col-md-offset-2">
            {!! Form::open(array('url' => 'signup', 'class' => 'panel', 'role' => 'panel')) !!}
            <div class="panel-body">
                <div class="logo">
                   {!! HTML::image('assets/images/logo.png') !!}
                </div>
                <h2>注册</h2>

                @if(Input::get('first_run'))
                    <div class="alert alert-info">
                        You're almost there. Just create a user account and you're ready to go.
                    </div>
                @endif

                <!-- <div class="row"> -->
                        <div class="form-group {{ ($errors->has('last_name')) ? 'has-error' : '' }}">
                            {!! Form::label('full_name', '姓名', ['class' => 'control-label']) !!}
                            {!! Form::text('full_name', null, ['class' => 'form-control']) !!}
                            @if($errors->has('full_name'))
                                <p class="help-block">{{ $errors->first('full_name') }}</p>
                            @endif
                        </div>
                <!-- </div> -->

                <div class="form-group {{ ($errors->has('email')) ? 'has-error' : '' }}">
                    {!! Form::label('email', 'Email', ['class' => 'control-label required']) !!}
                    {!! Form::text('email', null, ['class' => 'form-control']) !!}
                    @if($errors->has('email'))
                        <p class="help-block">{{ $errors->first('email') }}</p>
                    @endif
                </div>
                <div class="form-group {{ ($errors->has('phone')) ? 'has-error' : '' }}">
                    {!! Form::label('phone', '电话', ['class' => 'control-label']) !!}
                    {!! Form::text('phone', null, ['class' => 'form-control']) !!}
                    @if($errors->has('phone'))
                        <p class="help-block">{{ $errors->first('phone') }}</p>
                    @endif
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group {{ ($errors->has('last_name')) ? 'has-error' : '' }}">
                            {!! Form::label('department', '部门', ['class' => 'control-label']) !!}
                            <select name="department" v-model="selected_department" class="form-control" @change="fetchGroups">
                                <option v-for="department in departments" v-bind:value="department.id">
                                    @{{{ department.department_name }}}
                                </option>
                            </select>
                            @if($errors->has('department'))
                                <p class="help-block">{{ $errors->first('department') }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group {{ ($errors->has('last_name')) ? 'has-error' : '' }}">
                            {!! Form::label('group', '小组', ['class' => 'control-label']) !!}
                            <select name="group" v-model="selected_group" class="form-control">
                                <option v-for="group in groups" v-bind:value="group.id">
                                    @{{{ group.group_name }}}
                                </option>
                            </select>
                            @if($errors->has('group'))
                                <p class="help-block">{{ $errors->first('group') }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="form-group {{ ($errors->has('password')) ? 'has-error' : '' }}">
                    {!! Form::label('password', '密码', ['class' => 'control-label required']) !!}
                    {!! Form::password('password',  ['class' => 'form-control']) !!}
                    @if($errors->has('password'))
                        <p class="help-block">{{ $errors->first('password') }}</p>
                    @endif
                </div>
                <div class="form-group {{ ($errors->has('password_confirmation')) ? 'has-error' : '' }}">
                    {!! Form::label('password_confirmation', '确认密码', ['class' => 'control-label required']) !!}
                    {!! Form::password('password_confirmation',  ['class' => 'form-control']) !!}
                    @if($errors->has('password_confirmation'))
                        <p class="help-block">{{ $errors->first('password_confirmation') }}</p>
                    @endif
                </div>

                @if($is_attendize)
                <div class="form-group {{ ($errors->has('terms_agreed')) ? 'has-error' : '' }}">
                    <div class="checkbox custom-checkbox">
                        {!! Form::checkbox('terms_agreed', Input::old('terms_agreed'), false, ['id' => 'terms_agreed']) !!}
                        {!! Form::rawLabel('terms_agreed', '&nbsp;&nbsp;I agree to <a target="_blank" href="'.route('termsAndConditions').'"> Terms & Conditions </a>') !!}
                        @if ($errors->has('terms_agreed'))
                            <p class="help-block">{{ $errors->first('terms_agreed') }}</p>
                        @endif
                    </div>
                </div>
                @endif

                <div class="form-group ">
                   {!! Form::submit('注册', array('class'=>"btn btn-block btn-success")) !!}
                </div>

                @if($is_attendize)
                    <div class="signup">
                        <span>已有账户？ <a class="semibold" href="/login">登录</a></span>
                    </div>
                @endif
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    {!! HTML::script('assets/javascript/signup.js') !!}
@stop
