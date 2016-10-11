@include('ManageOrganiser.Partials.EventCreateAndEditJS')

{!! Form::model($event, array('url' => route('postEditEvent', ['event_id' => $event->id]), 'class' => 'ajax gf')) !!}

<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-sm-9">
                <div class="form-group">
                    {!! Form::label('title', '培训主题', array('class'=>'control-label required')) !!}
                    {!!  Form::text('title', Input::old('title'),
                                                array(
                                                'class'=>'form-control',
                                                'placeholder'=>''
                                                ))  !!}
                </div>
            </div>

            <div class="col-sm-3">
                <div class="form-group">
                    {!! Form::label('is_live', '开放设置', array('class'=>'control-label required')) !!}
                    {!!  Form::select('is_live', [
                    '1' => '向全体开放培训',
                    '0' => '不对公众开发'],null,
                                                array(
                                                'class'=>'form-control'
                                                ))  !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <link rel="stylesheet" href="{{url('plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.css')}}" />
                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
                    <script src="{{url('plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js')}}"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
                    {!! Form::label('tags', '标签', array('class'=>'control-label required')) !!}
                    <!-- <input id="tagsinput" type="text" value="{{Input::old('tags')}}" class="form-control" data-role="tagsinput"> -->
                    {!!  Form::text('tagsinput', Input::old('tags'),array('id'=>'tagsinput', 'class'=>'form-control','data-role'=>'tagsinput'))  !!}
                    {!!  Form::hidden('tags', Input::old('tags'))  !!}
                    <script type="text/javascript">
                        $(function(){
                            $("#tagsinput").tagsinput('add', $('#tags').val());
                            $("#tagsinput").change(function(){
                                $('#tags').val($(this).val());
                            });
                        })

                    </script>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="form-group {{ ($errors->has('last_name')) ? 'has-error' : '' }}">
                    {!! Form::label('department', '部门', ['class' => 'control-label']) !!}
                    <select name="department" class="form-control" @click="fetchGroups">
                        <option value="{{$event->department->id}}">
                            {{$event->department->department_name}}
                        </option>
                        @foreach ($event->organiser->departments as $department)
                        @if ($department->id != $event->department->id)
                        <option value="{{$department->id}}">
                            {{ $department->department_name }}
                        </option>
                        @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    {!! Form::label('speaker', '主讲人', array('class'=>'control-label required')) !!}
                    {!!  Form::text('speaker', Input::old('speaker'),
                                                array(
                                                'class'=>'form-control',
                                                'placeholder'=>''
                                                ))  !!}
                </div>
            </div>
        </div>


        <div class="form-group">
           {!! Form::label('description', '简介', array('class'=>'control-label')) !!}
            {!!  Form::textarea('description', Input::old('description'),
                                        array(
                                        'class'=>'form-control editable',
                                        'rows' => 5
                                        ))  !!}
        </div>

        <div class="form-group address-automatic" style="display:{{$event->location_is_manual ? 'none' : 'block'}};">
            {!! Form::label('name', '培训地点', array('class'=>'control-label required ')) !!}
            {!!  Form::text('venue_name_full', Input::old('venue_name_full'),
                                        array(
                                        'class'=>'form-control geocomplete location_field',
                                        'placeholder'=>'E.g: 立言厅'
                                        ))  !!}

            <!--These are populated with the Google places info-->
            <div>
               {!! Form::hidden('formatted_address', $event->location_address, ['class' => 'location_field']) !!}
               {!! Form::hidden('street_number', $event->location_street_number, ['class' => 'location_field']) !!}
               {!! Form::hidden('country', $event->location_country, ['class' => 'location_field']) !!}
               {!! Form::hidden('country_short', $event->location_country_short, ['class' => 'location_field']) !!}
               {!! Form::hidden('place_id', $event->location_google_place_id, ['class' => 'location_field']) !!}
               {!! Form::hidden('name', $event->venue_name, ['class' => 'location_field']) !!}
               {!! Form::hidden('location', '', ['class' => 'location_field']) !!}
               {!! Form::hidden('postal_code', $event->location_post_code, ['class' => 'location_field']) !!}
               {!! Form::hidden('route', $event->location_address_line_1, ['class' => 'location_field']) !!}
               {!! Form::hidden('lat', $event->location_lat, ['class' => 'location_field']) !!}
               {!! Form::hidden('lng', $event->location_long, ['class' => 'location_field']) !!}
               {!! Form::hidden('administrative_area_level_1', $event->location_state, ['class' => 'location_field']) !!}
               {!! Form::hidden('sublocality', '', ['class' => 'location_field']) !!}
               {!! Form::hidden('locality', $event->location_address_line_1, ['class' => 'location_field']) !!}
            </div>
            <!-- /These are populated with the Google places info-->

        </div>

        <div class="address-manual" style="display:{{$event->location_is_manual ? 'block' : 'none'}};">
            <div class="form-group">
                {!! Form::label('location_venue_name', '会场名称', array('class'=>'control-label required ')) !!}
                {!!  Form::text('location_venue_name', $event->venue_name, [
                                        'class'=>'form-control location_field',
                                        'placeholder'=>'E.g: 立言厅'
                            ])  !!}
            </div>
            <div class="form-group">
                {!! Form::label('location_address_line_1', '地点详情', array('class'=>'control-label')) !!}
                {!!  Form::text('location_address_line_1', $event->location_address_line_1, [
                                        'class'=>'form-control location_field',
                                        'placeholder'=>'E.g: 本部三五食堂三楼'
                            ])  !!}
            </div>
        </div>

        <div class="clearfix" style="margin-top:-10px; padding: 5px; padding-top: 0px;">
            <span class="pull-right">
                or <a data-clear-field=".location_field" data-toggle-class=".address-automatic, .address-manual" data-show-less-text="{{$event->location_is_manual ? 'Enter Address Manually' : 'Select From Existing Venues'}}" href="javascript:void(0);" class="show-more-options clear_location">{{$event->location_is_manual ? '选择已有地点' : '手动输入地址'}}</a>
            </span>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    {!! Form::label('start_date', '培训开始日期', array('class'=>'required control-label')) !!}
                    {!!  Form::text('start_date', $event->getFormattedDate('start_date'),
                                                        [
                                                    'class'=>'form-control start hasDatepicker ',
                                                    'data-field'=>'datetime',
                                                    'data-startend'=>'start',
                                                    'data-startendelem'=>'.end',
                                                    'readonly'=>''

                                                ])  !!}
                </div>
            </div>

            <div class="col-sm-6 ">
                <div class="form-group">
                    {!!  Form::label('end_date', '培训结束日期',
                                        [
                                    'class'=>'required control-label '
                                ])  !!}
                    {!!  Form::text('end_date', $event->getFormattedDate('end_date'),
                                                [
                                            'class'=>'form-control end hasDatepicker ',
                                            'data-field'=>'datetime',
                                            'data-startend'=>'end',
                                            'data-startendelem'=>'.start',
                                            'readonly'=>''
                                        ])  !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                   {!! Form::label('event_image', '图片', array('class'=>'control-label ')) !!}
                   {!! Form::styledFile('event_image', 1) !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="float-l">
                    @if($event->images->count())
                    {!! Form::label('', '当前图片', array('class'=>'control-label ')) !!}
                    <div class="form-group">
                        <div class="well well-sm well-small">
                           {!! Form::label('remove_current_image', 'Delete?', array('class'=>'control-label ')) !!}
                           {!! Form::checkbox('remove_current_image') !!}

                        </div>
                    </div>
                    <div class="thumbnail">
                       {!!HTML::image('/'.$event->images->first()['image_path'])!!}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="panel-footer mt15 text-right">
           {!! Form::hidden('organiser_id', $event->organiser_id) !!}
           {!! Form::submit('保存更改', ['class'=>"btn btn-success"]) !!}
        </div>
    </div>
    {!! Form::close() !!}
</div>
