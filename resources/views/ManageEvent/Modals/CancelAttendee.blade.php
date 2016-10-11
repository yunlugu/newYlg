<div role="dialog"  class="modal fade " style="display: none;">
   {!! Form::model($attendee, array('url' => route('postCancelAttendee', array('event_id' => $event->id, 'attendee_id' => $attendee->id)), 'class' => 'ajax')) !!}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title">
                    <i class="ico-cancel"></i>
                    Cancel <b>{{$attendee->full_name}} <b></h3>
            </div>
            <div class="modal-body">
                <p>
                    取消该记录将会在列表中删除此条记录
                </p>

                <br>
                <div class="form-group">
                    <div class="checkbox custom-checkbox">
                        <input type="checkbox" name="notify_attendee" id="notify_attendee" value="1">
                        <label for="notify_attendee">&nbsp;&nbsp;通知 <b>{{$attendee->member->full_name}}</b> 他的签到记录将被取消</label>
                    </div>
                </div>

            </div> <!-- /end modal body-->
            <div class="modal-footer">
               {!! Form::hidden('attendee_id', $attendee->id) !!}
               {!! Form::button('Cancel', ['class'=>"btn modal-close btn-danger",'data-dismiss'=>'modal']) !!}
               {!! Form::submit('Confirm Cancel Attendee', ['class'=>"btn btn-success"]) !!}
            </div>
        </div><!-- /end modal content-->
       {!! Form::close() !!}
    </div>
</div>
