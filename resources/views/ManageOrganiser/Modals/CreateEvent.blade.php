<div role="dialog"  class="modal fade" style="display: none;">

    @include('ManageOrganiser.Partials.EventCreateAndEditJS');

    {!! Form::open(array('url' => route('postCreateEvent'), 'class' => 'ajax gf')) !!}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title">
                    <i class="ico-calendar"></i>
                    新增培训</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    {!! Form::label('title', '培训主题', array('class'=>'control-label required')) !!}
                                    {!!  Form::text('title', Input::old('title'),array('class'=>'form-control','placeholder'=>'' ))  !!}
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    {!! Form::label('speaker', '主讲人', array('class'=>'control-label required')) !!}
                                    {!!  Form::text('speaker', Input::old('speaker'),array('class'=>'form-control','placeholder'=>'' ))  !!}
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group {{ ($errors->has('last_name')) ? 'has-error' : '' }}">
                                    {!! Form::label('department', '部门', ['class' => 'control-label']) !!}
                                    <select name="department" class="form-control" @click="fetchGroups">
                                        @foreach ($organiser->departments as $department)
                                        <option value="{{$department->id}}">
                                            {{ $department->department_name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- <div class="col-sm-3">
                                <div class="form-group">
                                    {!! Form::label('title', '小组', array('class'=>'control-label required')) !!}
                                    这里准备改ajax
                                    {!!Form::select('department', [
                                        '1' => '技术部',
                                        '2' => '行政部',
                                        '3' => '运营部',
                                        '4' => '宣传部',
                                        '5' => '外媒部'

                                        ], null, ['class' => 'form-control'])!!}
                                </div>
                            </div> -->
                        </div>
                        <div class="row">
                            <div class="col-sm-10">
                                <div class="form-group">
                                    <link rel="stylesheet" href="{{url('plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.css')}}" />
                                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
                                    <script src="{{url('plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js')}}"></script>
                                    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
                                    {!! Form::label('tags', '标签', array('class'=>'control-label required')) !!}
                                    <!-- <input id="tagsinput" type="text" value="{{Input::old('tags')}}" class="form-control" data-role="tagsinput"> -->
                                    {!!  Form::text('tags', Input::old('tags'),array('id'=>"tagsinput",'class'=>'form-control','data-role'=>'tagsinput' ))  !!}
                                    {!!  Form::hidden('tags', Input::old('tags'))  !!}
                                    <script type="text/javascript">
                                        $(function(){
                                            $("#tagsinput").change(function(){
                                                $('#tags').val($(this).val());
                                            });
                                        })

                                    </script>
                                </div>
                            </div>

                        </div>

                        <div class="form-group custom-theme">
                            {!! Form::label('description', '描述', array('class'=>'control-label required')) !!}
                            {!!  Form::textarea('description', Input::old('description'),
                                        array(
                                        'class'=>'form-control  editable',
                                        'rows' => 5
                                        ))  !!}
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    {!! Form::label('start_date', '开始时间', array('class'=>'required control-label')) !!}
                                    {!!  Form::text('start_date', Input::old('start_date'),
                                                        [
                                                    'class'=>'form-control start hasDatepicker ',
                                                    'data-field'=>'datetime',
                                                    'data-startend'=>'start',
                                                    'data-startendelem'=>'.end',
                                                    'readonly'=>''

                                                ])  !!}
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    {!!  Form::label('end_date', '结束时间',
                                                [
                                            'class'=>'required control-label '
                                        ])  !!}

                                    {!!  Form::text('end_date', Input::old('end_date'),
                                                [
                                            'class'=>'form-control end hasDatepicker ',
                                            'data-field'=>'datetime',
                                            'data-startend'=>'end',
                                            'data-startendelem'=>'.start',
                                            'readonly'=> ''
                                        ])  !!}
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('event_image', trans('ManageOrganiser/Modals/CreateEvent.event_image'), array('class'=>'control-label ')) !!}
                            {!! Form::styledFile('event_image') !!}

                        </div>
                        <div class="form-group address-automatic">
                            {!! Form::label('name', trans('ManageOrganiser/Modals/CreateEvent.place'), array('class'=>'control-label required ')) !!}
                            {!!  Form::text('venue_name_full', Input::old('venue_name_full'),
                                        array(
                                        'class'=>'form-control geocomplete location_field',
                                        'placeholder'=>'E.g: The Crab Shack'
                                        ))  !!}

                                    <!--These are populated with the Google places info-->
                            <div>
                                {!! Form::hidden('formatted_address', '', ['class' => 'location_field']) !!}
                                {!! Form::hidden('street_number', '', ['class' => 'location_field']) !!}
                                {!! Form::hidden('country', '', ['class' => 'location_field']) !!}
                                {!! Form::hidden('country_short', '', ['class' => 'location_field']) !!}
                                {!! Form::hidden('place_id', '', ['class' => 'location_field']) !!}
                                {!! Form::hidden('name', '', ['class' => 'location_field']) !!}
                                {!! Form::hidden('location', '', ['class' => 'location_field']) !!}
                                {!! Form::hidden('postal_code', '', ['class' => 'location_field']) !!}
                                {!! Form::hidden('route', '', ['class' => 'location_field']) !!}
                                {!! Form::hidden('lat', '', ['class' => 'location_field']) !!}
                                {!! Form::hidden('lng', '', ['class' => 'location_field']) !!}
                                {!! Form::hidden('administrative_area_level_1', '', ['class' => 'location_field']) !!}
                                {!! Form::hidden('sublocality', '', ['class' => 'location_field']) !!}
                                {!! Form::hidden('locality', '', ['class' => 'location_field']) !!}
                            </div>
                            <!-- /These are populated with the Google places info-->
                        </div>

                        <div class="address-manual" style="display:none;">
                            <h5>
                                {{trans('ManageOrganiser/Modals/CreateEvent.address_details')}}
                            </h5>

                            <div class="form-group">
                                {!! Form::label('location_venue_name', trans('ManageOrganiser/Modals/CreateEvent.venue_name'), array('class'=>'control-label required ')) !!}
                                {!!  Form::text('location_venue_name', Input::old('location_venue_name'), [
                                        'class'=>'form-control location_field',
                                        'placeholder'=>'E.g: 立言厅'
                                        ])  !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('location_address_line_1', '地点详情', array('class'=>'control-label')) !!}
                                {!!  Form::text('location_address_line_1', Input::old('location_address_line_1'), [
                                        'class'=>'form-control location_field',
                                        'placeholder'=>'E.g: 本部三五食堂三楼'
                                        ])  !!}
                            </div>
                        </div>

                        <span>
                            <a data-clear-field=".location_field"
                               data-toggle-class=".address-automatic, .address-manual"
                               data-show-less-text="or <b>{{trans('ManageOrganiser/Modals/CreateEvent.select_from_existing_venues')}}</b>" href="javascript:void(0);"
                               class="in-form-link show-more-options clear_location">
                                or <b>{{trans('ManageOrganiser/Modals/CreateEvent.enter_address_manually')}}</b>
                            </a>
                        </span>

                        @if($organiser->id)
                            {!! Form::hidden('organiser_id', $organiser->id) !!}
                        @else
                            <div class="create_organiser" style="{{$organisers->isEmpty() ? '' : 'display:none;'}}">
                                <h5>
                                    {{trans('ManageOrganiser/Modals/CreateEvent.organiser_detail')}}
                                </h5>

                                <div class="form-group">
                                    {!! Form::label('organiser_name', trans('ManageOrganiser/Modals/CreateEvent.organiser_name'), array('class'=>'required control-label ')) !!}
                                    {!!  Form::text('organiser_name', Input::old('organiser_name'),
                                                array(
                                                'class'=>'form-control',
                                                'placeholder'=>'Who\'s organising the event?'
                                                ))  !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('organiser_email', trans('ManageOrganiser/Modals/CreateEvent.organiser_email'), array('class'=>'control-label required')) !!}
                                    {!!  Form::text('organiser_email', Input::old('organiser_email'),
                                                array(
                                                'class'=>'form-control ',
                                                'placeholder'=>''
                                                ))  !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('organiser_about', trans('ManageOrganiser/Modals/CreateEvent.organiser_description'), array('class'=>'control-label ')) !!}
                                    {!!  Form::textarea('organiser_about', Input::old('organiser_about'),
                                                array(
                                                'class'=>'form-control editable2',
                                                'placeholder'=>'',
                                                'rows' => 4
                                                ))  !!}
                                </div>
                                <div class="form-group more-options">
                                    {!! Form::label('organiser_logo', trans('ManageOrganiser/Modals/CreateEvent.organiser_logo'), array('class'=>'control-label ')) !!}
                                    {!! Form::styledFile('organiser_logo') !!}
                                </div>
                                <div class="row more-options">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('organiser_facebook', 'Organiser Facebook', array('class'=>'control-label ')) !!}
                                            {!!  Form::text('organiser_facebook', Input::old('organiser_facebook'),
                                                array(
                                                'class'=>'form-control ',
                                                'placeholder'=>'E.g http://www.facebook.com/MyFaceBookPage'
                                                ))  !!}

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('organiser_twitter', 'Organiser Twitter', array('class'=>'control-label ')) !!}
                                            {!!  Form::text('organiser_twitter', Input::old('organiser_twitter'),
                                                array(
                                                'class'=>'form-control ',
                                                'placeholder'=>'E.g http://www.twitter.com/MyTwitterPage'
                                                ))  !!}

                                        </div>
                                    </div>
                                </div>

                                <a data-show-less-text="Hide Additional Oraganiser Options" href="javascript:void(0);"
                                   class="in-form-link show-more-options">
                                    {{trans('ManageOrganiser/Modals/CreateEvent.additional_organiser_options')}}
                                </a>
                            </div>

                            @if(!$organisers->isEmpty())
                                <div class="form-group select_organiser" style="{{$organisers ? '' : 'display:none;'}}">

                                    {!! Form::label('organiser_id', trans('ManageOrganiser/Modals/CreateEvent.select_organiser'), array('class'=>'control-label ')) !!}
                                    {!! Form::select('organiser_id', $organisers, $organiser_id, ['class' => 'form-control']) !!}

                                </div>
                                <span class="">
                                    <a data-toggle-class=".select_organiser, .create_organiser"
                                       data-show-less-text="or <b>Select an organiser</b>" href="javascript:void(0);"
                                       class="in-form-link show-more-options">
                                        or <b>{{trans('ManageOrganiser/Modals/CreateEvent.create_an_organiser')}}</b>
                                    </a>
                                </span>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <span class="uploadProgress"></span>
                {!! Form::button('Cancel', ['class'=>"btn modal-close btn-danger",'data-dismiss'=>'modal']) !!}
                {!! Form::submit(trans('ManageOrganiser/Modals/CreateEvent.create_event'), ['class'=>"btn btn-success"]) !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
