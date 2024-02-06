@extends('layouts.app')
@section('content')
    <!-- <section class="banner_image"> -->
    <!-- <section>
        <div class="banner_title">
            <h1>Event Details</h1>
        </div>
    </section> -->
    <header>
        <nav class="main_navbar navbar navbar-expand-lg navbar-light ">
            <!-- <a href=" @if (Auth::check()) {{url('event')}} @else  @endif" class="navbar-brand"><img id = "mail_logo_id" class="main_logo" src="{{config('global.static_image.logo')}}" alt=""></a> -->
            <!-- <div class="dropdown ml-auto"> -->
            <div class="dropdown ">
                @if (Auth::check())
                    <a href="#" class="user_profile " id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="user_image"><img src="{{Helper::LoggedWebUserImage()}}" alt=""></div>
                        <div class="user_name"><h6> {{(Auth::user()->user_org_data) ?  Auth::user()->user_org_data->organization_name:''}}</h6></div>
                    </a>
                @endif
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="{{url('profile')}}">Edit Profile</a>
                    <a class="dropdown-item" href="{{url('userdata')}}">Users Data</a>
                    {{-- <a class="dropdown-item" href="{{url('change_password')}}">Change Password</a> --}}
                    <a class="dropdown-item" href="#"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();" >Log out</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        <input type="hidden" name="is_web" value = "1">
                        @csrf
                    </form>
                </div>
            </div>
            <div class="banner_title ml-auto">
                <h6>Event Details</h6>
            </div>
        </nav>
    </header>
 
    @php
        $dataval = '';
        $val =0;
        // echo 'in';die;
    @endphp
    @if(isset($event_details_data))      
    <section class="event_details_screen">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{ url('event') }}">Event</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Event Details</li>
                </ol>
              </nav>
            <div class="event_details_card">
               <div class="event_details_card_image">
                   <img src="{{$event_details_data['item_image']}}" alt="" style="height: 624px !important">
                   <div class="overlay"></div>
                    <div class="date">
                        {{-- <h3>{{ date('d', strtotime($event_details_data['event_date'])) }} <span>{{ date('F', strtotime($event_details_data['event_date'])) }}</span></h3> --}}
                        @if($event_details_data['event_end_date'] != '')          
                        <h3>{{date('d',strtotime($event_details_data['event_date']))}} <span>{{date('F',strtotime($event_details_data['event_date']))}}</span>&nbsp;<span>-</span>&nbsp;<h3>{{date('d',strtotime($event_details_data['event_end_date']))}}<span>{{date('F',strtotime($event_details_data['event_end_date']))}}</span></h3></h3>
                    @else 
                        <h3>{{date('d',strtotime($event_details_data['event_date']))}} <span>{{date('F',strtotime($event_details_data['event_date']))}}</span></h3> 
                    @endif
                </div>                    
            </div>
            <div class="event_details">
                <div class="event_details_title">
                    <h3 class="mb-0">{{$event_details_data['title']}}</h3>
                    <div class="event_details_edit_delete">
                        <a href="{{url('event/edit_event')}}/{{$event_details_data['item_id']}}">
                            <img src="{{config('global.static_image.editing')}}" alt="">
                        </a>
                        <a href="#" data-target="#delete" data-toggle="modal">
                            <img src="{{config('global.static_image.delete')}}" alt="">
                        </a>
                    </div>
                </div>
                <div class="time_address">
                    <div class="time_address_text">
                        <img src="{{config('global.static_image.clock')}}" alt="">
                        @php 
                            $dash_obj = new App\Http\Controllers\Controller;
                            $users_timezone = $dash_obj->getTimeZone();
                            $start_time_local =$dash_obj->getLocalTime(strtotime($event_details_data['event_start_time']), $users_timezone);
                            $end_time_local =$dash_obj->getLocalTime(strtotime($event_details_data['event_end_time']), $users_timezone);
                            @endphp

                            <p>{{$start_time_local}} - {{$end_time_local}}</p>
                         
                    </div>
                    <div class="time_address_text">
                        <img src="{{config('global.static_image.location')}}" alt="">
                        {{-- <p>{{$event_details_data['location']}}</p> --}}
                        <p>{{ ($event_details_data['location'] !='') ? $event_details_data['location'] : $event_details_data['event_link'] }}</p>
                    </div>
                </div>
               
                <?php 
                $date_now = date("Y-m-d");
                // echo $event_details_data['event_date'];
                if($event_details_data['event_date'] >= $date_now){
                    // echo 'in';die;
                if($event_details_data['recurrence_type'] == 2){
                    if($event_details_data['recurrence_repeat_type'] == 2){
                        // print_r($event_details_data['event_next_date']);
                        if(!empty($event_details_data['event_next_date'])){
                            $nextdate1 ='';
                            foreach($event_details_data['event_next_date'] as $nextdate){
                                
                                if($nextdate > $event_details_data['event_date']){
                                    $nextdate1 = $nextdate;
                                    break;
                                }
                            }
                        }
                        // }
                        // die;
                        if($event_details_data['recurrence_repeat_type'] == 1){
                        $repeatTxt = 'Daily';
                        }elseif($event_details_data['recurrence_repeat_type'] == 2){
                            $repeatTxt = 'Weekly';
                            if($event_details_data['frequency_day'] !=''){
                                $allCheckboxValues = explode(",",$event_details_data['frequency_day']);
                                $weeklyon =[];
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
                <p>{{$event_details_data['description']}}</p>
                <div class="like_comment">
                    <a href="#" class="like_comment_tetx">
                        <img src="{{config('global.static_image.like1')}}" alt="">
                        <p>{{$event_details_data['like_count']}}</p>
                    </a>                
                </div>
                
                <div class="fees_person">
                    <div class="attending_person">
                        <h3 class="comment_title">Attending Person :</h3>
                        @if ($event_details_data['joined_user_count'] <= 1)
                            <h6 class="mb-0"><a href="javascript:void(0)" data-toggle="modal" data-target="#exampleModal">{{$event_details_data['joined_user_count']}}</a> attending this Meetup</h6>          
                        @else
                            <h6 class="mb-0"><a href="javascript:void(0)" data-toggle="modal" data-target="#exampleModal">{{$event_details_data['joined_user_count']-1}}+</a>attending this Meetup</h6>
                        @endif                        
                    </div>
                    <div class="attending_person">
                        <h3 class="comment_title">Event Fees :</h3>
                        <h6 class="mb-0"><a href="javascript:void(0)">@if($event_details_data['cost_type'] == 1 || $event_details_data['cost_type'] == 2) {{ Helper::GetCostTypeText($event_details_data['cost_type'])}} @else${{ number_format($event_details_data['cost'], 2) }}@endif</a></h6>
                    </div>
                </div>    
                @if(isset($event_details_data['item_comment']))                   
                    <div class="comments">
                        <h3 class="comment_title">Comments :</h3>
                        <form method="post" name="add_comment" id="add_comment">
                            @csrf
                            <div class="form-group comment_group">
                                <input type="hidden" name="event_id" id="event_id" value="{{$event_details_data['item_id']}}">
                                <textarea class="form-control" id="event_comment" name="event_comment" rows="1" placeholder="Add a Comment" style="padding-right: 35px" autocomplete="off"></textarea>
                                <button type="submit" class="send_comment" style="border: none;background: transparent;">
                                    <img src="{{config('global.static_image.send')}}" alt="">
                                </button>
                            </div>
                        </form> 
                        @if(isset($event_details_data['item_comment']))  
                            <div id="append_comment">                     
                                @foreach ($event_details_data['item_comment'] as $key => $value)
                                    <div class="comments_card @if($key > 2) more_comment @endif">
                                        <div class="main_comment" id="main_comment_id_{{$key}}">
                                            <div class="comments_card_image">
                                                @if ($value->profile_image)
                                                    <img src="{{$value->profile_image}}" alt="">
                                                @else
                                                    <img src="{{config('global.static_image.dummy-img')}}" alt="">
                                                @endif
                                            </div>
                                            <div class="comments_card_details">
                                                <div class="comment_user">
                                                    @php
                                                     $name = strcmp($value->first_name,$value->last_name);
                                                     if($name == 0){
                                                         $username =$value->first_name;
                                                     }
                                                     else{
                                                        $username =$value->first_name.' '.$value->last_name;
                                                     }
                                                    @endphp
                                                    <h6 class="mb-0">{{$username}}</h6>
                                                </div>
                                                <p>{{$value->item_comment}}</p>
                                            </div>
                                            <div class="rply_time">
                                                <p class="comment_time">{{Helper::GetTimeStamp($value->created_at)}}</p>
                                            </div>                                    
                                        </div>
                                        @if(isset($value->Replies)) 
                                        <div class="reply_comment" id="reply_comment">
                                            @foreach($value->Replies as $key1 => $reply)
                                            @php
                                                $dataval = $reply->event_comment_reply_id;
                                                $val = $key1;
                                                // echo 'val'.$val;
                                            @endphp
                                            <div class="comments_card more_comment replystyle">
                                                <div class="comments_card_image">
                                                    @if ($reply->reply_user_profile_image)
                                                        <img src="{{$reply->reply_user_profile_image}}" alt="">
                                                    @else
                                                        <img src="{{config('global.static_image.dummy-img')}}" alt="">
                                                    @endif
                                                </div>
                                                <div class="comments_card_details">
                                                    <div class="comment_user">
                                                        @php
                                                        $replyname = strcmp($reply->reply_user_first_name,$reply->reply_user_last_name);
                                                        if($replyname == 0){
                                                            $replyusername =$reply->reply_user_first_name;
                                                        }
                                                        else{
                                                            $replyusername =$reply->reply_user_first_name.' '.$reply->reply_user_last_name;
                                                        }
                                                       @endphp
                                                        <h6 class="mb-0">{{$replyusername}}</h6>
                                                        <p>{{$reply->event_reply_comment}}</p>
                                                    </div>
                                                    <div class="rply_time">
                                                        <p class="comment_time">{{Helper::GetTimeStamp($reply->reply_user_reply_date)}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach   
                                        </div>  
                                        @endif                         
                                             <form method="post" id="addreply_{{$key}}" name="addreply" class="addreplyform">                                                
                                                @csrf
                                                @method('PUT')
                                                <div class="form-group">
                                                    <input type="text" name="event_reply_comment" id="event_reply_comment_{{$key}}_{{$val}}" class="form-control" autocomplete="off" oninput="validatefun(this)" />
                                                    <div id="comment_error_{{$key}}_{{$val}}" class="error-msg" style="display:none;">
                                                    </div>
                                                    <input type="hidden" name="event_id" id="reply_event_id_{{$key}}_{{$val}}" value="{{ $value->event_id }}" />
                                                    <input type="hidden" name="event_comment_id" id="event_comment_id_{{$key}}_{{$val}}" value="{{ $value->event_comment_id }}" />
                                                </div>
                                                <div class="form-group">                                            
                                                    <input type="button" id="rply_btn_{{$key}}_{{$val}}" class="btn btn-warning reply" onclick="replaysumbit({{$key}},{{$val}});" value="Reply" />
                                                </div>
                                            </form>
                                        
                                    </div> 
                                @endforeach
                            </div>
                            <div id="hello"></div>
                                @if (count($event_details_data['item_comment']) > 3)
                                    <div class="view_more">
                                        <a href="javascript:void(0)" id="view_more_comment">
                                            <p>View More</p>
                                        </a>
                                    </div>
                                @endif                        
                            </div>                        
                        @endif
                        @endif
                </div>
            </div>    
    </section>
    @endif
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                <div class="modal_title">
                    <h3 class="modal-title" id="exampleModalLabel">Attending Person</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal_data">
                    <div class="attending_person_list">
                        @if (isset($event_details_data['joined_user']) && count($event_details_data['joined_user']) > 0)
                            @foreach ($event_details_data['joined_user'] as $user)
                                <div class="attending_person_user">
                                    @if ($user['profile_image'] == '')
                                        <img src="{{config('global.static_image.dummy-img')}}" alt="">
                                    @else
                                        <img src="{{$user['profile_image']}}" alt="">
                                    @endif
                                    @php
                                    $personname = strcmp($user['first_name'],$user['last_name']);
                                    if($personname == 0){
                                        $personusername =$user['first_name'];
                                    }
                                    else{
                                        $personusername =$user['first_name'].' '.$user['last_name'];
                                    }
                                   @endphp                     
                                    <h4 class="mb-0">{{$personusername}}</h4>
                                </div>
                            @endforeach
                        @else
                            <h4>No user attend this event.</h4>
                        @endif
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="delete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog small_modal">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal_title">
                        <button type="button" class="close ml-auto" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal_data">
                        <div class="delete_poup">
                            <img src="{{config('global.static_image.delete')}}" alt="">
                            <div class="delete_popup">
                                <h3>Are you sure </h3>
                                <p>do you really want to delete these Event? this process be undone.</p>
                                <a href="{{url('event/delete_event')}}/{{$event_details_data['item_id']}}" class="btn btn-primary create_event_button mx-auto mt-5">Delete</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@include('layouts.footer')
@endsection
@section('scripts')
<script type="text/javascript">
function validatefun(input){
  if(/^\s/.test(input.value))
    input.value = '';
}
$('form').submit(function(e){
        e.preventDefault();
    });

    $(document).ready(function()
    {  
        $('.more_comment').hide();
        $('#view_more_comment').on('click',function(){
            $('.more_comment').show();
            $('#view_more_comment').hide();
        });
        $('#add_comment').validate({ // initialize the plugin
            ignore: ":hidden",
            onfocusout: false,
            // invalidHandler: function(form, validator) {
            //     $('html, body').animate({
            //         scrollTop: $(validator.errorList[0].element).offset().top
            //     }, 1000);
            // } ,
            rules: {
                event_comment: {
                    noSpace: true,
                    required: true
                },
            },
            errorElement: 'span',
            errorPlacement: function (error, element) { 
                error.addClass('invalid-feedback');               
                element.closest('.form-group').append(error);
                $('.error').css("font-weight", "bold");
                $('.send_comment').css('top','35% !important');          
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');                
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            },
            messages: {
                event_comment:{
                    required: "{{__('messages.web.event.event_comment_required')}}",
                },
            },
            submitHandler: function(form){
                $('.send_comment').attr('disabled',true);
                var url = "{{url('event/add_comment')}}";
                $.ajax({
                    url: url,
                    type: 'POST',
                    // async: false,
                    data: {
                        "_token"      : "{{ csrf_token() }}",
                        event_comment : $('#event_comment').val(),
                        event_id      : $('#event_id').val()
                    },
                    success: function(data) {
                        if(data.result == true)
                        {
                            $('.send_comment').attr('disabled',false);
                            $('#event_comment').val('');
                            $('#append_comment').append(data.data);
                            // data
                            // $("html, body").animate({
                            //     scrollTop: $(
                            //     'html, body').get(0).scrollHeight
                            // }, 2000);
                            $('.more_comment').show();
                            $('#view_more_comment').hide();
                            location.reload();
                        }
                        // else
                        // {
                        //     alert(data.message);
                        // }
                    },
                    error: function (request, status, error) {
                        if(request.status == 419)
                        {
                            location.href = "{{url('/')}}";
                        }
                    }
                })  
            },
        });

     
        
        // $(#addreply).validate({ // initialize the plugin
        //     ignore: ":hidden",
        //     onfocusout: false,
        //     invalidHandler: function(form, validator) {
        //         $('html, body').animate({
        //             scrollTop: $(validator.errorList[0].element).offset().top
        //         }, 1000);
        //     } ,
        //     rules: {
        //         event_reply_comment: {
        //             noSpace: true,
        //             required: true
        //         },
        //     },
        //     errorElement: 'span',
        //     errorPlacement: function (error, element) { 
        //         error.addClass('invalid-feedback');               
        //         element.closest('.form-group').append(error);
        //         $('.error').css("font-weight", "bold");         
        //     },
        //     highlight: function (element, errorClass, validClass) {
        //         $(element).addClass('is-invalid');                
        //     },
        //     unhighlight: function (element, errorClass, validClass) {
        //         $(element).removeClass('is-invalid');
        //     },
        //     messages: {
        //         event_reply_comment:{
        //             required: "{{__('messages.web.event.reply_comment_required')}}",
        //         },
        //     },
        //     submitHandler: function(form){
        //         alert('in');
        //         $('.reply').attr('disabled',true);
        //         var url = "{{url('reply/store')}}";
        //         $.ajax({
        //             url: url,
        //             type: 'POST',
        //             // async: false,
        //             data: {
        //                 "_token"      : "{{ csrf_token() }}",
        //                 event_reply_comment : $('#event_reply_comment').val(),
        //                 event_id      : $('#reply_event_id').val(),
        //                 event_comment_id: $('#event_comment_id').val()
        //             },
        //             success: function(data) {
        //                 if(data.result == true)
        //                 {
        //                     $('.reply').attr('disabled',false);
        //                     $('#event_reply_comment').val('');
        //                     console.log(data.data);
        //                     // $('#reply_comment').append(data.data);.
        //                     $("div#main_comment_id_0").next().append(data.data);
        //                     // data
        //                     // $("html, body").animate({
        //                     //     scrollTop: $(
        //                     //     'html, body').get(0).scrollHeight
        //                     // }, 2000);
        //                     // $('.more_comment').show();
        //                     // $('#view_more_comment').hide();
        //                     // location.reload();
        //                 }
        //                 // else
        //                 // {
        //                 //     alert(data.message);
        //                 // }
        //             },
        //             error: function (request, status, error) {
        //                 if(request.status == 419)
        //                 {
        //                     location.href = "{{url('/')}}";
        //                 }
        //             }
        //         })  
        //     },
        // });
    });

function replaysumbit(id,reply){
// alert(id);
// alert(reply);

var event_reply_comment = $('#event_reply_comment_'+id+'_'+reply).val();
var event_id = $('#reply_event_id_'+id+'_'+reply).val();
var event_comment_id = $('#event_comment_id_'+id+'_'+reply).val();
// console.log(event_reply_comment);
// console.log(event_id);
// console.log(event_comment_id);

if ($('#event_reply_comment_'+id).val() == "") {
    $('#comment_error_'+id).show();
    $('#comment_error_'+id).html('Please enter reply comment');
    setTimeout(function() {
        $('#comment_error_'+id).hide();
    }, 7000);
    return false;
}
else{
    $('.reply').attr('disabled',true);
    var url = "{{url('reply/store')}}";
    $.ajax({
            url: url,
            type: 'POST',
            // async: false,
            data: {
                "_token"      : "{{ csrf_token() }}",
                event_reply_comment :event_reply_comment,
                event_id      : event_id,
                event_comment_id: event_comment_id
            },
            success: function(data) {
                if(data.result == true)
                {
                    $('.reply').attr('disabled',false);
                    $('#event_reply_comment').val('');
                    console.log(data.data);
                    // $('#reply_comment').append(data.data);.
                    var id=$('div.comments_card').children().next().attr('id');
                    console.log(id);
                    // $("div.comments_card").next().append(data.data); 
                    $("#"+id).append(data.data);      
                    location.reload();                      
                }
            },
            error: function (request, status, error) {
                if(request.status == 419)
                {
                    location.href = "{{url('/')}}";
                }
            }
        }); 
    }
     
}
</script>
@endsection