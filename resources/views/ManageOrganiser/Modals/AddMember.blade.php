<div role="dialog"  class="modal fade " style="display: none;">
   {!! Form::open(array('url' => route('postAddMember', array('organiser_id' => $organiser->id)), 'class' => 'ajax')) !!}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3 class="modal-title">
                    <i class="ico-user"></i>
                    添加成员</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('email', '邮箱', array('class'=>'control-label required')) !!}
                                    {!!  Form::text('email', Input::old('email'),
                                                        array(
                                                        'class'=>'form-control'
                                                        ))  !!}
                                </div>

                                <div class="form-group">
                                {!! Form::label('full_name', '姓名', array('class'=>'control-label required')) !!}

                                {!!  Form::text('full_name', Input::old('full_name'),
                                            array(
                                            'class'=>'form-control'
                                            ))  !!}
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                {!! Form::label('password', 'password', array('class'=>'control-label')) !!}

                                {!!  Form::text('password', Input::old('password'),
                                            array(
                                            'class'=>'form-control'
                                            ))  !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="checkbox custom-checkbox">
                                <input type="checkbox" name="email_ticket" id="email_ticket" value="1" />
                                <label for="email_ticket">发送邮件给该用户</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- /end modal body-->
            <div class="modal-footer">
               {!! Form::button('Cancel', ['class'=>"btn modal-close btn-danger",'data-dismiss'=>'modal']) !!}
               {!! Form::submit('创建用户', ['class'=>"btn btn-success"]) !!}
            </div>
        </div><!-- /end modal content-->
       {!! Form::close() !!}
    </div>
</div>
