@if(isset($event_data) && count($event_data) > 0)
    @foreach ($event_data as $item)
          <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="event_card" onclick="location.href='{{url('event/event_details')}}/{{$item['item_id']}}';">
                <div class="event_card_image" style="cursor: pointer;">
                    <img src="{{$item['item_image']}}" alt="">
                    <div class="overlay"></div>
                    <div class="date">
                        {{-- <h3>{{date('d',strtotime($item['event_date']))}} <span>{{date('F',strtotime($item['event_date']))}}</span></h3>  --}}
                        @if($item['event_end_date'] != '')          
                                <h3>{{date('d',strtotime($item['event_date']))}} <span>{{date('F',strtotime($item['event_date']))}}</span>&nbsp;<span>-</span>&nbsp;<h3>{{date('d',strtotime($item['event_end_date']))}}<span>{{date('F',strtotime($item['event_end_date']))}}</span></h3></h3>
                            @else 
                                <h3>{{date('d',strtotime($item['event_date']))}} <span>{{date('F',strtotime($item['event_date']))}}</span></h3> 
                            @endif
                    </div>
                </div>
                <div class="event_details">
                    <h3>{{$item['title']}}</h3>
                    <div class="time_address">
                        <div class="time_address_text">
                            <img src="{{config('global.static_image.clock')}}" alt="">
                            
                            @php 
                            $dash_obj = new App\Http\Controllers\Controller;
                            $users_timezone = $dash_obj->getTimeZone();
                            $start_time_local =$dash_obj->getLocalTime(strtotime($item['event_start_time']), $users_timezone);
                            $end_time_local =$dash_obj->getLocalTime(strtotime($item['event_end_time']), $users_timezone);
                            @endphp

                            <p>{{$start_time_local}} - {{$end_time_local}}</p>
                         
                        </div>
                    </div>
                    <div class="time_address">
                        <div class="time_address_text">
                            <img src="{{config('global.static_image.location')}}" alt="">
                            {{-- <p>{{$item['location']}}</p> --}}
                            <p>{{ ($item['location'] !='') ? $item['location'] : $item['event_link'] }}</p>
                        </div>
                    </div>
                    <?php 
                    $date_now = date("Y-m-d");
                    $weeklyon =[];
                    if($item['event_date'] >= $date_now){
                    if($item['recurrence_type'] == 2){
                        if($item['recurrence_repeat_type'] == 2){
                            // print_r($item['event_next_date']);
                            if(!empty($item['event_next_date'])){
                                $nextdate1 ='';
                                foreach($item['event_next_date'] as $nextdate){
                                    
                                    if($nextdate > $item['event_date']){
                                        $nextdate1 = $nextdate;
                                        break;
                                    }
                                }
                            }
                            // }
                            // die;
                            if($item['recurrence_repeat_type'] == 1){
                            $repeatTxt = 'Daily';
                            }elseif($item['recurrence_repeat_type'] == 2){
                                $repeatTxt = 'Weekly';
                                if($item['frequency_day'] !=''){
                                    $allCheckboxValues = explode(",",$item['frequency_day']);
                                    
                                    if (in_array(0, $allCheckboxValues))
                                    {
                                        $weeklyon ='Sunday';
                                    }
                                    if (in_array(1, $allCheckboxValues))
                                    {
                                        $weeklyon ='Monday';
                                    }
                                    if (in_array(2, $allCheckboxValues))
                                    {
                                        $weeklyon ='Tuesday';
                                    }
                                    if (in_array(3, $allCheckboxValues))
                                    {
                                        $weeklyon ='Wednesday';
                                    }
                                    if (in_array(4, $allCheckboxValues))
                                    {
                                        $weeklyon ='Thursday';
                                    }
                                    if (in_array(5, $allCheckboxValues))
                                    {
                                        $weeklyon ='Friday';
                                    }
                                    if (in_array(6, $allCheckboxValues))
                                    {
                                        $weeklyon ='Saturday';
                                    }
                                                                    
                                }
                            }else{
                                $repeatTxt = 'Monthly';
                            }

                    ?>
                    <div class="time_address">
                        <div class="time_address_text">
                            <p>Repeat:- {{$repeatTxt}}({{$weeklyon}})</p>
                        </div>
                    </div>
                    <div class="time_address">
                        <div class="time_address_text">
                            <p>Next Date:- {{$nextdate}}</p>
                        </div>
                    </div>
                    <?php }}}?>
                    <p>{{Helper::readMoreHelper($item['description'],40)}}</p>
                    <div class="like_comment">
                        <a href="#" class="like_comment_tetx">
                            <img src="{{config('global.static_image.like1')}}" alt="">
                            <p>{{$item['like_count']}}</p>
                        </a>
                        <a href="#" class="like_comment_tetx">
                            <img src="{{config('global.static_image.comment2')}}" alt="">
                            <p>{{$item['comment_count']}}</p>
                        </a>

                        <a href="#" class="like_comment_tetx">
                            <img src="{{config('global.static_image.reg_link')}}" alt="">
                            <p>{{$item['reg_link_count']}}</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@else
    <div class="col-lg-4 col-md-6 col-sm-12">
        <span><h4>No data found</h4></span>
    </div>
@endif