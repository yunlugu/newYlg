<div role="dialog"  class="modal fade" style="display: none;">
   {!! Form::open(array('url' => route('postQrcode', array('member_id' => $member->id)), 'class' => 'ajax reset closeModalAfter')) !!}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title">
                    <i class="ico-envelope"></i>
                    Message {{{$member->full_name}}}
                </h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('subject', '主题', array('class'=>'control-label required')) !!}
                            {!!  Form::text('subject', '云麓谷：二维码来啦',
                                        array(
                                        'class'=>'form-control',
                                        'placeholder'=>'云麓谷：二维码来啦'
                                        ))  !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('message', '备注', array('class'=>'control-label')) !!}

                            {!!  Form::textarea('message', Input::old('message'),
                                        array(
                                        'class'=>'form-control',
                                        'rows' => '5'
                                        ))  !!}
                        </div>

                        <div class="form-group">
                            <div class="custom-checkbox">
                                <input type="checkbox" name="send_copy" id="send_copy" value="1">
                                <label for="send_copy">&nbsp;&nbsp;给该部门管理员 <b>{{$member->organiser->email}}</b>发送副本</label>
                            </div>
                        </div>
                    </div>
                </div>

            </div> <!-- /end modal body-->
            <div class="modal-footer">
               {!! Form::button('Cancel', ['class'=>"btn modal-close btn-danger",'data-dismiss'=>'modal']) !!}
               {!! Form::submit('发送', ['class'=>"btn btn-success"]) !!}
            </div>
        </div><!-- /end modal content-->
        {!! Form::close() !!}
    </div>
</div>
