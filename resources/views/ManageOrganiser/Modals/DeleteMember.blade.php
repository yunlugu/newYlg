<div role="dialog"  class="modal fade " style="display: none;">
   {!! Form::model($member, array('url' => route('postDeleteMember', array('organiser_id' => $organiser->id, 'member_id' => $member->id)), 'class' => 'ajax')) !!}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title">
                    <i class="ico-cancel"></i>
                    Cancel <b>{{$member->full_name}} <b></h3>
            </div>
            <div class="modal-body">
                <p>
                    删除用户后该用户会在组织中消失
                </p>

                <br>

            </div> <!-- /end modal body-->
            <div class="modal-footer">
               {!! Form::hidden('member_id', $member->id) !!}
               {!! Form::button('Cancel', ['class'=>"btn modal-close btn-danger",'data-dismiss'=>'modal']) !!}
               {!! Form::submit('确认删除', ['class'=>"btn btn-success"]) !!}
            </div>
        </div><!-- /end modal content-->
       {!! Form::close() !!}
    </div>
</div>
