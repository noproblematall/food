@extends('layouts.app')
@section('css')
{{-- <link href="{{asset('css/ionicons.min.css')}}" rel="stylesheet">
<link rel="stylesheet" href="{{asset('css/admin/bracket.css')}}"> --}}
<link rel="stylesheet" href="{{asset('date/css/bootstrap-datepicker.standalone.min.css')}}">

<style>
    .border-red {border: 1px solid red !important;}
    #bookingModal .modal-body p{font-weight: bold;}
    #bookingModal .modal-body p span{font-weight: normal;}
    .wajba-control {margin-bottom: 7px !important;}
    #empty_alert, #error_alert {position: relative;padding: .15rem 1.25rem;margin-bottom: 7px;border: 1px solid transparent;border-radius: .25rem;font-size: 14px;}
</style>
@endsection
@section('content')
@php
    if ($wajba->photos()->where('type', 1)->exists()) {
        $url = $wajba->photos()->where('type', 1)->first()->url;
    }else{
        $url = 'frontend/images/uploads/tours/banner_detail.jpg';
    }

    if(Auth::user()){
        $flag = 1;
    }else{
        $flag = 0;
    }
@endphp
<section class="tour-item-banner" style="background-image: url({{ asset($url) }})">
    <div class="container">
        <div class="tour-item-banner__btn-area">
            <span class="tour-item-banner__btn tour-item-banner__btn--view-photos"><img src="{{asset('frontend/images/tours/tour_item-icon-pic.png')}}" alt="tour_item-icon-pic"> View Photos</span>
            {{-- <span class="tour-item-banner__btn tour-item-banner__btn--video-preview"><img src="assets/images/tours/tour_item-icon-video.png" alt="video"> Video Preview</span> --}}
        </div>
    </div>
    @if ($wajba->photos()->where('type', 2)->exists())
        @php
            $gallery = $wajba->photos()->where('type', 2)->get();
        @endphp
        <section>
            {{-- <h2 class="galery-h2">galerry</h2> --}}
            <div class="gallery__syncing">
                <div class="gallery__syncing__close"> </div>
                <div class="gallery__syncing__area">
                    <span class="gallery__syncing__btn-close" >&times;</span> 
                    <div class="gallery__syncing__single">
                        @foreach ($gallery as $item)
                            <div class="gallery__syncing__single__item">
                                <img src="{{asset($item->url)}}" alt="gall1">
                            </div>
                        @endforeach                        
                    </div>       
                    <div class="gallery__syncing__nav">
                        @foreach ($gallery as $item)
                            <div class="gallery__syncing__nav__item">
                                <img src="{{asset($item->url)}}" alt="gall1">
                            </div>                            
                        @endforeach
                        
                    </div> 
                </div>        
            </div>
        </section>
    @else
        <section>
            {{-- <h2 class="galery-h2">galerry</h2> --}}
            <div class="gallery__syncing">
                <div class="gallery__syncing__close"> </div>
                <div class="gallery__syncing__area">
                    <span class="gallery__syncing__btn-close" >&times;</span> 
                    <div class="gallery__syncing__single">
                        <div class="gallery__syncing__single__item">
                            <img src="{{asset('frontend/images/uploads/gallery/gall1.jpg')}}" alt="gall1">
                        </div>
                        <div class="gallery__syncing__single__item">
                            <img src="{{asset('frontend/images/uploads/gallery/gall2.jpg')}}" alt="gall2">
                        </div>
                        <div class="gallery__syncing__single__item">
                            <img src="{{asset('frontend/images/uploads/gallery/gall3.jpg')}}" alt="gall3">
                        </div>
                    </div>       
                    <div class="gallery__syncing__nav">
                        <div class="gallery__syncing__nav__item">
                            <img src="{{asset('frontend/images/uploads/gallery/gall1.jpg')}}" alt="gall1">
                        </div>
                        <div class="gallery__syncing__nav__item">
                            <img src="{{asset('frontend/images/uploads/gallery/gall2.jpg')}}" alt="gall2">
                        </div>
                        <div class="gallery__syncing__nav__item">
                            <img src="{{asset('frontend/images/uploads/gallery/gall3.jpg')}}" alt="gall3">
                        </div>
                    </div> 
                </div>        
            </div>
        </section>        
    @endif
</section>

<section class="tour-infomation">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 ">
                    <aside>
                        <div class="tour-infomation__content">
                            <div class="tour-infomation__content__header">
                                <h2>{{ $wajba->title }}</h2>
                                
                                <div class="tour-infomation__content__header__icon">                                    
                                    <p><i class="fas fa-utensils"></i>&nbsp;&nbsp;{{ $wajba->place_category->name }}</p>
                                    <p><i class="fas fa-hamburger"></i>&nbsp;&nbsp;{{ $wajba->food_category->name }}</p>
                                    <p><i class="fas fa-map-marker-alt"></i>&nbsp;&nbsp;{{ $wajba->city_name == '' ? $wajba->city : $wajba->city_name }}</p>
                                    <p><i class="fas fa-door-closed"></i>&nbsp;&nbsp;{{ $wajba->door_type == 'in_door' ? 'Indoor' : 'Outdoor'}}</p>
                                    @if ($wajba->time != null)
                                        <p><i class="fas fa-clock"></i>&nbsp;&nbsp;{{ $wajba->time->fromTime }}h ~ {{ $wajba->time->toTime }}h</p>
                                    @else
                                        <p><i class="fas fa-clock"></i>&nbsp;&nbsp;9h ~ 12h</p>       
                                    @endif
                                </div>
                            </div>
                            <div class="tour-infomation__content__descript">
                                <h2>Description</h2>
                                <p>{{ $wajba->description }}</p>
                            </div>

                            {{-- <div class="tour-infomation__content__descript">
                                <h2>Healthy Condition And Warning</h2>
                                <p>{{ $wajba->healthConditionsAndWarnings }}</p>
                            </div> --}}

                            {{-- <div class="tour-infomation__content__descript">
                                <h2>Information About Author</h2>
                                <p>{{ $wajba->host->aboutYou }}</p>
                            </div> --}}
        
                            {{-- <div class="tour-infomation__content__time-table">
                                <span>Name</span>
                                <p>{{ $wajba->host->user->full_name }}</p>         
                            </div>
                            
                            <div class="tour-infomation__content__time-table">
                                <span>Email</span>
                                <p>{{ $wajba->host->user->email }}</p>         
                            </div>
                            <div class="tour-infomation__content__time-table">
                                <span>Mobile</span>
                                <p>+96655555555</p>
                            </div>
                            
                            <div class="tour-infomation__content__time-table">
                                <span>City</span>
                                <p>{{ $wajba->city }}</p>         
                            </div> --}}
        
                            <div class="tour-infomation__content__activity-location">
                                <h2>Activity's Location</h2>
                                <div class="tour-infomation__content__activity-location__gmap">
                                    <div id="googleMap" style="width: 100%;height: 400px;"></div>
                                    {{-- <i class="fas fa-map-marker-alt"></i> --}}
                                </div>
                            </div>
                        </div>
                    </aside>
              
                </div>
                <div class="col-lg-4" id="app">                    
                    <div class="sidebar">
                        <div class="right-sidebar">
                            <div class="right-sidebar__item">
                                <div class="text-center per_price">
                                    <p class="text-center">Estimated</p>
                                    <h3><span class="mr-2">SR</span>{{$wajba->price}}</h3>
                                </div>
                                <form class="right-sidebar__item__form" id="booking_form" action="{{ route('creat_booking') }}" method="get">
                                    {{-- @csrf --}}
                                    <input type="hidden" name="wajba_id" id="wajba_id" value="{{ $wajba->id }}">
                                    <input type="hidden" name="date_id" id="date_id">
                                    <div class="all_input">
                                        <label>Please pick your favorite date</label>
                                        <div class="right-sidebar__item__form--date">
                                            <span class="far fa-calendar-alt"></span>
                                            <input type="text" id="available_date" style="background-color: #fff;">
                                        </div>
                                        <label>The available experience seats</label>
                                        <input name="basenumber" type="number" value="0" id="basenumber" min="0" readonly>
                                        <label>How many gentlemen ?</label>
                                        <input name="number_males" type="number" id="number_males" min="0" value="0" style="background-color: #fff;">
                                        <label>How many ladies?</label>
                                        <input name="number_females" type="number" id="number_females" min="0" value="0" autocomplete="off" style="background-color: #fff;">
                                        <label>How many children ?</label>
                                        <input name="number_childrens" type="number" id="number_childrens" min="0" value="0" autocomplete="off" style="background-color: #fff;">
                                    </div>
                                    {{-- <div class="mt-2" id="booking_message">
                                        <div class="alert alert-info">
                                            <p>If you are interested to enjoy this excperience, please contact us: <b>nourah.alsadoun@hihome.sa.</b></p>
                                        </div>
                                    </div> --}}
                                    <button type="button" id="book_now" class="btn btn-custom mt-3 w-100">BOOK NOW</button>
                                </form>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="similar-tour__tittle">
                <div class="section-tittle">
                    <h2>discover</h2>
                    <div class="section-tittle__line-under"></div>
                    <p>Similar <span>Experiences</span></p>
                </div>
            </div>     
        </div>
        <div class="similar-tour">
            <div class="container">
                <div class="row">
                    @forelse ($similar_wajba as $item)
                        <div class="col-lg-4 col-md-6 col-xl-3 col-sm-6 col-12">
                            <a href="{{route('wajba_detail', $item->id)}}" class="trending-tour-item">
                                {{-- <div class="trending-tour-item__sale"></div> --}}
                                @if ($item->photos()->where('type', 0)->exists())
                                    <img class="trending-tour-item__thumnail" src="{{asset($item->photos()->where('type', 0)->first()->url)}}" alt="tour1">
                                @else
                                    <img class="trending-tour-item__thumnail" src="{{asset('frontend/images/uploads/tours/sample3.jpg')}}" alt="tour1">                            
                                @endif

                                <div class="trending-tour-item__info">
                                    <h3 class="trending-tour-item__name ellipsis">
                                        {{$item->title}}
                                    </h3>
                                    <div class="trending-tour-item__group-infor">
                                        <div class="trending-tour-item__group-infor--left">
                                            <div class="trending-tour-item__group-infor__lasting"><i class="fas fa-map-marker-alt" style="color: #a7662f"></i>&nbsp;&nbsp;{{$item->city_name == '' ? $item->city : $item->city_name}}</div>
                                        </div>
                                        <span class="trending-tour-item__group-infor__sale__detail-price">Estimated</span>
                                        <span class="trending-tour-item__group-infor__price">SR&nbsp;{{$item->price}}</span>
                        
                                    </div>
                                </div>
                            </a>
                        </div>                        
                    @empty
                        
                    @endforelse
                </div>
            </div>
        </div>
    </section>    
    
    <!-- The Modal -->
    <div class="modal fade" id="bookingModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">        
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title text-center">Booking Detail</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>            
                <!-- Modal body -->
                <div class="modal-body" style="padding: 2rem;">
                    <p class="male_number">Number Of Males: <span></span></p>
                    <p class="female_number">Number Of Females: <span></span></p>
                    <p class="children_number">Number Of Childrens: <span></span></p>
                    <p class="total_number">Number Of Total: <span></span></p>
                    <p class="price">Price: <span></span> <span>SAR</span></p>
                    <p class="text-center">Please confirm your booking.</p>
                </div>            
                <!-- Modal footer -->
                <div class="modal-footer">
                <button type="button" id="booking_confirm" class="btn btn-custom">Confirm</button>
                <button type="button" class="btn btn-secondary cancel" data-dismiss="modal">Cancel</button>
                </div>            
            </div>
        </div>
    </div>
    <!-- The Login Modal With Password -->
    <div class="modal fade" id="login_pass">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">        
                <div class="modal-body">
                    @csrf
                    <div class="text-center mt-2"><a href="{{ asset('/') }}"><img src="{{asset('img/logo.png')}}" width="75" alt="logo"></a></div>
                    <div class="form-group mt-4">
                        <input type="text" class="form-control mobile_input" name="mobile" required placeholder="Enter your mobile" autofocus autocomplete="off"> 
                        <label for="#" style="margin: 0;font-size:12px;color: #717171;">Example +955511111111</label>                           
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control password" name="password" required placeholder="Enter your password" autofocus autocomplete="off">                            
                    </div>
                    <div class="alert alert-danger error display_none">
                        <strong>Warning!</strong> These credentials do not match our records.
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-custom btn-block" id="login_with_pass">Sign In</button>                        
                        <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Close</button>                    
                    </div>
                    <div class="text-center"><a href="javascript:void(0);" class="to_verify">Login with SMS</a></div>
                    <div class="text-center">Not yet a member? <a href="javascript:void(0);" id="to_signUp_pass" class="tx-info">Sign Up</a></div>
                </div>
            </div>
        </div>
    </div>
    <!-- The Login Modal With SMS -->
    <div class="modal fade" id="verify_form">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="text-center mt-2"><a href="{{ asset('/') }}"><img src="{{asset('img/logo.png')}}" width="75" alt="logo"></a></div>
                    <div class="form-group mt-4">
                        <input type="text" class="form-control float-left" style="width: 70px;" name="mobile" required id="phone_code" value="+966" autofocus autocomplete="off">                            
                        <input type="text" class="form-control float-right" name="mobile" style="width: 195px;" required placeholder="Enter your mobile" id="mobile_verify" autofocus autocomplete="off">
                        <div class="clearfix"></div>
                    </div>
                    <span class="custom-invalid-feedback display_none" id="not_mobile" role="alert">
                        <strong>The mobile number is not registered.</strong>
                    </span>
                    <span class="custom-invalid-feedback display_none" id="empty_mobile" role="alert">
                        <strong>Please enter valid mobile.</strong>
                    </span>
                    <span class="custom-invalid-feedback display_none" id="many_mobile" role="alert">
                        <strong>Too many requests.</strong>
                    </span>
                    
                    <div class="form-group">
                        <button type="button" class="btn btn-custom btn-block" id="verify">Sign In</button>
                        <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Close</button>
                    </div>
                    <div class="text-center"><a href="javascript:void(0);" class="to_password">Login with mobile and password</a></div>
                    <div class="text-center">Not yet a member? <a href="javascript:void(0);" id="to_signUp_verify" class="tx-info">Sign Up</a></div>
                </div>
            </div>
        </div>
    </div>
    <!-- The Modal With Verification Code -->
    <div class="modal fade" id="confirm_form">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">        
                <div class="modal-body">
                    <div class="text-center mt-2"><a href="{{ asset('/') }}"><img src="{{asset('img/logo.png')}}" width="75" alt="logo"></a></div>
                    <div class="alert alert-success display_none" id="empty_alert">
                        <strong>Success!</strong> Resent code successfully.
                    </div>
                    <div class="form-group mt-4">
                        <input type="text" class="form-control" name="mobile" required id="code_confirm"  placeholder="Enter your code" autofocus autocomplete="off">
                        <span class="custom-invalid-feedback display_none" id="empty_code" role="alert">
                            <strong>Please enter confirm code.</strong>
                        </span>
                        <span class="custom-invalid-feedback display_none" id="invaild_code" role="alert">
                            <strong>The code you’ve entered is incorrect, please enter the correct code.</strong>
                        </span>
                    </div>                
                    <div class="form-group">
                        <button type="button" class="btn btn-custom btn-block"  id="confirm">Confirm</button>
                        <button type="button" class="btn btn-custom btn-block mg-t-20 display_none resend">Resend</button>
                        <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Close</button>
                    </div>
                    <div class="text-center"><a href="javascript:void(0);" class="to_password">Login with mobile and password</a></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Register functions -->
    <div class="modal fade" id="register_verify_form">        
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="text-center mt-2"><a href="{{ asset('/') }}"><img src="{{asset('img/logo.png')}}" width="75" alt="logo"></a></div>
                    <div class="form-group mt-4">
                        <input type="text" class="form-control float-left" style="width: 70px;" name="mobile" required id="register_phone_code" value="+966" autofocus autocomplete="off">                            
                        <input type="text" class="form-control float-right" name="mobile" style="width: 195px;" required placeholder="Enter your mobile" id="register_mobile_verify" autofocus autocomplete="off">
                        <div class="clearfix"></div>
                    </div>
                    <span class="custom-invalid-feedback display_none" id="register_unique_mobile" role="alert">
                        <strong>The mobile has already been taken.</strong>
                    </span>
                    <span class="custom-invalid-feedback display_none" id="register_empty_mobile" role="alert">
                        <strong>Please enter valid mobile.</strong>
                    </span>
                    <span class="custom-invalid-feedback display_none" id="register_many_mobile" role="alert">
                        <strong>Too many requests.</strong>
                    </span>
                    
                    {{-- <label class="ckbox ckbox-success mg-t-15">
                        <input type="checkbox" id="terms"><span>I agree to the <b>Terms and Conditions</b></span>
                    </label> --}}
                    <div class="form-group">
                        <button type="button" class="btn btn-custom btn-block" id="register_verify">Verify</button>
                        <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Close</button>
                    </div>
                    <div class="text-center">Already a member? <a href="javascript:void(0);" id="to_signIn" class="tx-info">Sign In</a></div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="register_confirm_form">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">        
                <div class="modal-body">
                    <div class="text-center mt-2"><a href="{{ asset('/') }}"><img src="{{asset('img/logo.png')}}" width="75" alt="logo"></a></div>
                    <div class="alert alert-success display_none" id="empty_alert">
                        <strong>Success!</strong> Resent code successfully.
                    </div>
                    <div class="form-group mt-4">
                        <input type="text" class="form-control" name="mobile" required id="register_code_confirm"  placeholder="Enter your code" autofocus autocomplete="off">
                        <span class="custom-invalid-feedback display_none" id="register_empty_code" role="alert">
                            <strong>Please enter confirm code.</strong>
                        </span>
                        <span class="custom-invalid-feedback display_none" id="register_invaild_code" role="alert">
                            <strong>The code you’ve entered is incorrect, please enter the correct code.</strong>
                        </span>
                        <span class="custom-invalid-feedback display_none" id="register_server_mobile" role="alert">
                            <strong>Server error.</strong>
                        </span>
                    </div>                
                    <div class="form-group">
                        <button type="button" class="btn btn-custom btn-block"  id="register_confirm">Confirm</button>
                        <button type="button" class="btn btn-custom btn-block mg-t-20 display_none resend">Resend</button>
                        <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Close</button>
                    </div>
                    <div class="text-center">Already a member? <a href="javascript:void(0);" id="to_signIn">Sign In</a></div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="register_form">
        @csrf
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">        
                <div class="modal-body">
                    <div class="text-center mt-2 mb-3"><a href="{{ asset('/') }}"><img src="{{asset('img/logo.png')}}" width="75" alt="logo"></a></div>
                    <div class="alert alert-warning display_none" id="empty_alert">
                        <strong>Warning!</strong> Please input your infos correctly.
                    </div>
                    <div class="alert alert-warning display_none" id="error_alert">
                        <ul>

                        </ul>
                    </div>
                    <div class="form-group wajba-control">
                        <input type="text" class="form-control" name="firstName" id="first_name" placeholder="Enter your first name" required autofocus>
                        
                    </div><!-- form-group -->
                    <div class="form-group wajba-control">
                        <input type="text" class="form-control" name="lastName" id="last_name" placeholder="Enter your last name" required>
                        
                    </div><!-- form-group -->
                    <div class="form-group wajba-control">
                        <input type="email" class="form-control" name="email" id="register_email" placeholder="Enter your email" required>
                        <span class="custom-invalid-feedback display_none" id="register_email_validation" role="alert">
                            <strong>You have entered an invalid email.</strong>
                        </span>
                    </div><!-- form-group -->
                    <div class="form-group wajba-control">
                        <input type="hidden" class="form-control" name="mobile" placeholder="Enter your mobile" readonly id="mobile_number">
                    </div><!-- form-group -->
                    <div class="form-group wajba-control">
                        <label class="d-block tx-11 tx-uppercase tx-medium tx-spacing-1" style="font-size:13px;">The password must be at least 8 characters.</label>
                        <input type="password" class="form-control" name="password" id="register_password" placeholder="Enter your password" required>
                        
                    </div><!-- form-group -->
                    <div class="form-group wajba-control">
                        <input type="password" class="form-control" name="password_confirmation" id="register_confirmation_password" placeholder="Confirm your password" required>
                        <span class="custom-invalid-feedback display_none" id="register_password_confirm" role="alert">
                            <strong>The password confirmation does not match.</strong>
                        </span>
                    </div><!-- form-group -->
                    <div class="form-group wajba-control">
                        <input type="text" class="form-control" name="city" id="city" placeholder="Enter your city" required>
                        
                    </div><!-- form-group -->
                    <div class="form-group wajba-control">
                        <label class="d-block tx-11 tx-uppercase tx-medium tx-spacing-1" style="font-size:13px;">Gender</label>
                        <select class="form-control select2" name="gender" id="register_gender" data-placeholder="Gender">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div><!-- form-group -->                

                    <div class="form-group wajba-control tx-12" style="font-size:13px;">By clicking the Sign Up button below, you agreed to our privacy policy and terms of use of our website.</div>
                    <div class="form-group wajba-control">
                        <button type="button" class="btn btn-custom btn-block"  id="signup_submit">Sign Up</button>
                        <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Close</button>
                    </div>

                    <div class="mt-2 tx-center">Already a member? <a href="javascript:void(0);" id="final_to_signIn" class="tx-info">Sign In</a></div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="term_modal">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">            
            <!-- Modal Header -->
            <div class="modal-header">
                <h1 class="modal-title">Terms And Conditions</h1>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            
            <!-- Modal body -->
            <div class="modal-body">
                @include('term')
            </div>
            
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-custom" data-dismiss="modal">Close</button>
            </div>
            
            </div>
        </div>
    </div>

    @php
    $dates = '';
    if ($wajba->dates()->exists()) {
        foreach ($wajba->dates()->get() as $value) {
            $dates = $dates . $value->date . ',';
        }
    }
    @endphp
    <input type="hidden" name="" id="booking_price" value="{{$wajba->price}}">
    <input type="hidden" name="" id="available" value="{{ $dates }}">
    <input type="hidden" name="" id="lat" value="{{ $wajba->latitude }}">
    <input type="hidden" name="" id="lot" value="{{ $wajba->longitude }}">
    <input type="hidden" value="{{ $flag }}" id="auth">
@endsection



@section('script')
<script src="{{asset('moment/moment.min.js')}}"></script>
<script src="{{asset('date/js/bootstrap-datepicker.min.js')}}"></script>
<script>
$(document).ready(function(){
    let available = $('#available').val();    
    available = available.split(',')
    $('#available_date').datepicker({
        format: 'yyyy-mm-dd',
        todayHighlight: true,
        orientation: "bottom left",
        startDate: new Date(),
        beforeShowDay: function(date){
            if (available.indexOf(formatDate(date)) < 0)
                return {
                enabled: false
                }
            else
                return {
                    classes: 'day-active',
                    enabled: true
                }
            },
        autoclose: true,
    });

    let basenumber = Number($('#basenumber').val())
    let malenumber = 0
    let femalenumber = 0;
    let childrennumber = 0;
    let bookdate = 0;
    let temp = 0

    $('#available_date').change(function(){
        let date = $(this).val();
        let wajba_id = $('#wajba_id').val();
        $.ajax({
            url: '/get_available',
            type: 'get',
            data: {date:date, wajba_id: wajba_id},
            success: function(data){

                $('#basenumber').val(Number(data.available));
                $('#date_id').val(data.date_id)
                basenumber = Number(data.available)
                $('#number_males').val(0)
                $('#number_females').val(0)
                $('#number_childrens').val(0)
                $('#number_males').removeAttr('disabled');
                $('#number_females').removeAttr('disabled');
            }
        })
    })

    $('#bookingModal .cancel').click(function(){
        location.reload()
    })

    if (basenumber == 0) {
        $('#book_now').attr('disabled', 'disabled');
        // $('#available_date').attr('disabled', 'disabled');
        $('#number_males').attr('disabled', 'disabled');
        $('#number_females').attr('disabled', 'disabled');
        $('#number_childrens').attr('disabled', 'disabled');
    }

    $('#number_males').change(function(){
        malenumber = Number($(this).val())
        femalenumber = Number($('#number_females').val());
        childrennumber = Number($('#number_childrens').val());
        temp = basenumber - (malenumber + femalenumber + childrennumber)
        $('#basenumber').val(temp)
        temp = 0
        current_basenumber = Number($('#basenumber').val())
        if (malenumber > 0 || femalenumber > 0) {
            $('#book_now').removeAttr('disabled');
            $('#number_childrens').removeAttr('disabled');
        }else{
            $('#book_now').attr('disabled', 'disabled');
            $('#number_childrens').attr('disabled', 'disabled');
        }
        if (current_basenumber == 0) {
            $(this).attr('max', malenumber)
            $('#number_females').attr('max', femalenumber);
            $('#number_childrens').attr('max', childrennumber);
        }else{
            $(this).removeAttr('max')
            $('#number_females').removeAttr('max')
            $('#number_childrens').removeAttr('max')
        }
    })

    $('#number_females').change(function(){
        femalenumber = Number($(this).val())
        malenumber = Number($('#number_males').val());
        childrennumber = Number($('#number_childrens').val());
        temp = basenumber - (malenumber + femalenumber + childrennumber)

        $('#basenumber').val(temp)
        temp = 0
        current_basenumber = Number($('#basenumber').val())
        if (malenumber > 0 || femalenumber > 0) {
            $('#book_now').removeAttr('disabled');
            $('#number_childrens').removeAttr('disabled');
        }else{
            $('#book_now').attr('disabled', 'disabled');
            $('#number_childrens').attr('disabled', 'disabled');
        }
        if (current_basenumber == 0) {
            $(this).attr('max', femalenumber)
            $('#number_males').attr('max', malenumber);
            $('#number_childrens').attr('max', childrennumber);
        }else{
            $(this).removeAttr('max')
            $('#number_males').removeAttr('max')
            $('#number_childrens').removeAttr('max')
        }
    })

    $('#number_childrens').change(function(){
        childrennumber = Number($(this).val())
        femalenumber = Number($('#number_females').val());
        malenumber = Number($('#number_males').val());
        temp = basenumber - (malenumber + femalenumber + childrennumber)

        $('#basenumber').val(temp)
        temp = 0
        current_basenumber = Number($('#basenumber').val())
        if (malenumber > 0 || femalenumber > 0) {
            $('#book_now').removeAttr('disabled');
        }else{
            $('#book_now').attr('disabled', 'disabled');
        }
        if (current_basenumber == 0) {
            $(this).attr('max', femalenumber)
            $('#number_males').attr('max', malenumber);
            $('#number_childrens').attr('max', childrennumber);
        }else{
            $(this).removeAttr('max')
            $('#number_males').removeAttr('max')
            $('#number_childrens').removeAttr('max')
        }
    })

    $('#book_now').click(function(e){
        e.preventDefault()
        let auth = $('#auth').val();
        if ($('#number_females').val() > 0 || $('#number_males').val() > 0) {
            let number_male = Number($('#number_males').val())
            let number_female = Number($('#number_females').val())
            let number_children = Number($('#number_childrens').val())
            let total = number_male + number_female + number_children
            $('#bookingModal p.male_number span').text(number_male)
            $('#bookingModal p.female_number span').text(number_female)
            $('#bookingModal p.children_number span').text(number_children)
            $('#bookingModal p.total_number span').text(total)
            $('#bookingModal p.price span:first-child').text(total * $('#booking_price').val())
            if (auth == '1') {
                $('#bookingModal').modal({backdrop: "static"});
            }else{
                $('#login_pass').modal({backdrop: "static"});
            }
            
        }
    })

    $('.to_verify').click(function(){
        $('#verify_form').modal({backdrop: "static"})
        $('#login_pass').modal("hide");
    })
    $('.to_password').click(function(){
        $('#verify_form').modal("hide")
        $('#confirm_form').modal("hide")
        $('#login_pass').modal({backdrop: "static"});
    })     
    
    // ----------------- Login With Password ---------------------
    $('#login_with_pass').click(function(){
        let _this = $(this)
        let mobile = $('#login_pass .mobile_input').val()
        let password = $('#login_pass .password').val()
        if (mobile == '') {
            $('#login_pass .mobile_input').addClass('border-red')
            return false;
        }else if(password == ''){
            $('#login_pass .password').addClass('border-red')
            return false;
        }
        $.ajax({
            url: '/login',
            type: 'post',
            data: {mobile: mobile, password: password, _token: $('#login_pass').find('input[type=hidden]').val()},
            beforeSend: function () { $('.loader_container').removeClass('display_none'); },
            success: function(data){
                $('#login_pass .error').addClass('display_none');
                $('#login_pass').modal("hide")
                $('#bookingModal').modal({backdrop: "static"});

            },
            error: function(xhr, status, error) {
                $('#login_pass .error').removeClass('display_none');
                $('.loader_container').addClass('display_none');
            }
        }).done(function () {
            $('.loader_container').addClass('display_none');
        })
    })

    $('#booking_confirm').click(function(){
        $('.loader_container').removeClass('display_none')
        $('#booking_form').submit()
    })

    if($('#success_message').val() != ''){
        toast_call('Success', $('#success_message').val(), false)
    }


    $('#to_signUp_pass').click(function(){
        $('#register_verify_form').modal({backdrop: "static"})
        $('#login_pass').modal('hide')
    })
    $('#to_signUp_verify').click(function(){
        $('#register_verify_form').modal({backdrop: "static"})
        $('#verify_form').modal('hide')
    })
    $('#to_signIn').click(function(){
        $('#register_verify_form').modal('hide')
        $('#register_confirm_form').modal('hide')
        $('#login_pass').modal({backdrop: "static"})
    })
    

    function formatDate(d) {
        var day = String(d.getDate())
        //add leading zero if day is is single digit
        if (day.length == 1)
            day = '0' + day
        var month = String((d.getMonth()+1))
        //add leading zero if month is is single digit
        if (month.length == 1)
            month = '0' + month
        return d.getFullYear() + "-" + month + "-" + day;
    }
    function phonenumber(inputtxt)
    {
        var phoneno = /^\+[1-9]{1}[0-9]{3,14}$/;
        if(inputtxt.match(phoneno))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
})
</script>
<script src="{{ asset('frontend/scripts/sms_login.js') }}"></script>
<script src="{{ asset('frontend/scripts/sms_register.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key={{config('app.googlemap_key')}}&callback=initMap" async defer></script>
<script defer>
    function initMap() {
        var lat = Number($('#lat').val())
        var lot = Number($('#lot').val())
        // Create the map.
        var map = new google.maps.Map(document.getElementById('googleMap'), {
          zoom: 16,
          center: {lat: lat, lng: lot},
          mapTypeId: 'terrain'
        });

        var cityCircle = new google.maps.Circle({
            strokeColor: '#ffc600',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: '#a7662f',
            fillOpacity: 0.7,
            map: map,
            center: {lat: lat, lng: lot},
            radius: 400
        });
    }
</script>

@endsection