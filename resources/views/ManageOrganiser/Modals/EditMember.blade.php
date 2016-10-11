@include('Shared.Layouts.ViewJavascript')
{!! HTML::script('vendor/vue/dist/vue.min.js') !!}
{!! HTML::script('vendor/vue-resource/dist/vue-resource.min.js') !!}
<div id="#app" role="dialog"  class="modal fade" style="display: none;">
   {!! Form::model($member, array('url' => route('postEditMember', array('organiser_id' => $organiser->id, 'member_id' => $member->id)), 'class' => 'ajax')) !!}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title">
                    <i class="ico-edit"></i>
                    编辑 <b>{{$member->full_name}} <b></h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('full_name', '姓名', array('class'=>'control-label required')) !!}
                                    {!!  Form::text('full_name', Input::old('full_name'),
                                            array(
                                            'class'=>'form-control'
                                            ))  !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('sex', '男', array('class'=>'control-label')) !!}
                                    {!!  Form::radio('sex', '男', (Input::old('sex') == '男'),
                                            array(
                                                'class'=>'form-control'
                                            ))  !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('sex', '女', array('class'=>'control-label')) !!}
                                    {!!  Form::radio('sex', '女', (Input::old('sex') == '女'),
                                            array(
                                                'class'=>'form-control'
                                            ))  !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::label('email', 'Email', array('class'=>'control-label required')) !!}

                                    {!!  Form::text('email', Input::old('email'),
                                            array(
                                            'class'=>'form-control'
                                            ))  !!}
                                    @if($errors->has('email'))
                                    <p class="help-block">{{ $errors->first('email') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::label('phone', '电话', array('class'=>'control-label')) !!}
                                    {!!  Form::text('phone', Input::old('phone'),
                                            array(
                                            'class'=>'form-control'
                                            ))  !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group {{ ($errors->has('last_name')) ? 'has-error' : '' }}">
                                    {!! Form::label('department', '部门', ['class' => 'control-label']) !!}
                                    <select name="department" class="form-control" @click="fetchGroups">
                                        <option value="{{$member->department->id}}">
                                            {{$member->department->department_name}}
                                        </option>
                                        @foreach ($organiser->departments as $department)
                                        @if ($department->id != $member->department->id)
                                        <option value="{{$department->id}}">
                                            {{ $department->department_name }}
                                        </option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group {{ ($errors->has('last_name')) ? 'has-error' : '' }}">
                                    {!! Form::label('group', '小组', ['class' => 'control-label']) !!}
                                    <select name="group" v-model="selected_group" class="form-control">
                                        <option value="{{$member->group_id}}">
                                            {{$member->group->group_name}}
                                        </option>
                                        @foreach ($member->department->groups as $group)
                                        @if ($group->id != $member->group->id)
                                        <option value="{{$group->id}}">
                                            {{ $group->group_name }}
                                        </option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- /end modal body-->
            <div class="modal-footer">
               {!! Form::hidden('member_id', $member->id) !!}
               {!! Form::button('Cancel', ['class'=>"btn modal-close btn-danger",'data-dismiss'=>'modal']) !!}
               {!! Form::submit('保存修改', ['class'=>"btn btn-success"]) !!}
            </div>
        </div><!-- /end modal content-->
       {!! Form::close() !!}
    </div>
</div>
{!! HTML::script('assets/javascript/edit_member.js') !!}
