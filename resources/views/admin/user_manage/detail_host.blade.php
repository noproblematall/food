@extends('admin.layouts.app')

@section('css')
{{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css"> --}}
    <style>
        .user_detail img {
            margin-bottom: 20px;
        }
        .user_profile_img span {
            border-radius: 5px;
        }
        .bg-light {
            background-color: #a0a0a0 !important;
        }
        .user_detail h5 {
            margin-bottom: 15px;
        }
        .user_info {
            /* border: 1px solid grey; */
        }
        footer {
            margin-top: 0 !important;
        }
        .dropdown-menu {
            min-width: 8rem;
        }
        .br-pagetitle {
            justify-content: space-between;
        }
        .br-pagetitle > div {
            padding-left: 0px;
            display: flex;
            margin-top: 0;
            align-items: center;
        }
        .br-pagetitle > div > div {
            padding-left: 20px;
            margin-top: 0;
        }
        .rate-base-layer
        {
            color: #aaa;
        }
        .rate-select-layer
        {
            color: orange;
        }
        .rating
        {
            font-size: 20px;
        }
        .user_rate > span {
            font-size: 20px;
            font-weight: bold;
            color: #ff4343;
            margin-left: 5px;
        }
    </style>
@endsection

@section('content')

    <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
        <div class="br-pagetitle">
            <div>
                <i class="icon ion-person"></i>
                <div>
                <h4>User Detail</h4>
                <p class="mg-b-0">User detailed page</p>
            </div>  
        </div>
        <div class="">
            <a href="{{ URL::previous() }}" class="btn btn-primary">Previous Page</a>
        </div>
    </div><!-- d-flex -->
    @php
        // $helper = new Helper();
        $status_string = array('Approved', 'Pending', 'Suspended');
    @endphp
    <div class="br-pagebody user_detail" id="app">            
        <div class="mg-t-20 card card-body">
            <div class="row">
                <div class="col-md-6 text-center">
                    <div class="text-center user_profile_img mg-b-50">
                        @if ($user->photo()->exists())
                            <img src="{{ asset($user->photo->url) }}" alt="User Image" srcset="" width="200" height="200" class="rounded-circle">
                        @else
                            <img src="{{ asset('img/avatar.png') }}" alt="User Image" srcset="" width="200" height="200" class="rounded-circle">                      
                        @endif
                        @if (Helper::isOnline($user->id))
                            <h6>I am online&nbsp;&nbsp;<span class="square-10 bg-success"></span></h6>
                        @else
                            <h6>I am offline&nbsp;&nbsp;<span class="square-10 bg-light"></span></h6>                        
                        @endif
                        <h3>{{ $user->host->nameId }}</h3>
                    </div>
                    
                    <div class="row text-left user_info">
                        <div class="col-6">
                            <h5>Role</h5>
                            <h5>Name</h5>
                            <h5>Mobile</h5>
                            <h5>Email</h5>
                            <h5>Gender</h5>
                        </div>
                        <div class="col-6">
                            <h5>The {{ $user->role->type }}</h5>
                            <h5>{{ $user->firstName }}&nbsp;{{ $user->lastName }}</h5>
                            <h5>{{ $user->mobile }}</h5>
                            <h5>{{ $user->email }}</h5>
                            <h5>{{ $user->gender }}</h5>                            
                        </div>
                    </div>
                    <table class="table">
                        <thead>
                            <th>Host Status</th>
                            <th>User Status</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="dropdown">
                                        <a href="" class="tx-gray-800 d-inline-block host_status" data-toggle="dropdown">
                                            <div class="ht-45 pd-x-20 bd d-flex align-items-center justify-content-center">
                                            <span class="mg-r-10 tx-13 tx-medium">
                                                {{ $user->host->status }}
                                            </span>
                                            <i class="fa fa-angle-down mg-l-10"></i>
                                            </div>
                                        </a>
                                        <div class="dropdown-menu pd-0">
                                            <nav class="nav nav-style-1 flex-column">
                                                <a href="{{ route('admin.host_status_change', $user->id) }}" class="nav-link guest_status_change">
                                                    @if (!$user->host->status)
                                                        Approved
                                                    @else
                                                        Pending
                                                    @endif
                                                </a>
                                            </nav>
                                        </div><!-- dropdown-menu -->
                                    </div><!-- dropdown -->
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <a href="" class="tx-gray-800 d-inline-block guest_status" data-toggle="dropdown">
                                            <div class="ht-45 pd-x-20 bd d-flex align-items-center justify-content-center">
                                            <span class="mg-r-10 tx-13 tx-medium">
                                                {{ $status_string[$user->status_id - 1] }}
                                            </span>
                                            <i class="fa fa-angle-down mg-l-10"></i>
                                            </div>
                                        </a>
                                        <div class="dropdown-menu pd-0 wd-50">
                                            <nav class="nav nav-style-1 flex-column">
                                                @for ($i = 0; $i < count($status_string); $i++)
                                                    @if ($i != $user->status->id - 1)
                                                        <form action="{{ route('admin.user_status_change') }}" method="post">
                                                            @csrf
                                                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                                                            <input type="hidden" name="status_id" value="{{ $i + 1 }}">
                                                            <a href="javascript::void(0)" class="nav-link change_status"> {{ $status_string[$i] }}</a>
                                                        </form>
                                                    @endif
                                                @endfor
                                                {{-- <a href="" class="nav-link"> Pending</a>
                                                <a href="" class="nav-link"> Suspended</a> --}}
                                            </nav>
                                        </div><!-- dropdown-menu -->
                                    </div><!-- dropdown -->
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <div class="about_host mg-b-20">
                        <h2 class="mg-t-30">About Host</h2>
                        <p>{{ $user->host->aboutYou }}</p>
                    </div>
                    <h5 class="mg-t-20">- Rate & Reviews</h5>
                    @php
                        $rate = 0;
                        $review_number = 0;
                        $i = 0;
                        foreach ($user->host->wajbas as $items) {
                            $review_number += $items->reviews()->count();
                            $rate += $items->reviews()->sum('rate');
                        }
                    @endphp
                    <div class="user_rate">
                        @if ($review_number > 0)
                            <div class="rating float-left" data-rate-value={{ ($rate/$review_number) }}></div>
                            <span class="float-left">{{ round(($rate/$review_number), 2) }}&nbsp;&nbsp;|&nbsp;&nbsp;<a href="#">{{ $review_number }}&nbsp;<span style="font-size: 15px;">entries</span></a></span>
                        @else
                            <span>No feedback</span>
                        @endif
                        <div class="clearfix"></div>
                    </div>
                <h5 class="mg-t-20">- Balance of host&nbsp;(<span>{{ $user->host->balance }}</span>)</h5>
                    
                    <h5 class="mg-t-20">- Experience of host</h5>
                    @if ($user->host->wajbas()->count() > 0)
                        <div class="wajba bd rounded">
                            <table class="table table-bordered mg-b-0">
                                <thead>
                                    <th>No</th>
                                    <th>title</th>
                                    <th>Detail</th>
                                </thead>
                                <tbody>
                                    @foreach ($user->host->wajbas as $item)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $item->title }}</td>
                                            <td><a href="{{ route('admin.wajba_detail', $item->id) }}">&nbsp;<i class="fa fa-eye" style="color:#50aa5b;">&nbsp;</i></a></td>
                                        </tr>
                                    @endforeach
                                    
                                </tbody>
                            </table>
                        </div>
                    @else
                        <span>No Experience yet</span>
                    @endif
                    
                </div>

            </div>
        </div>
    </div>

@endsection

@section('script')
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('js/rater.min.js') }}"></script>
    <script>
        var options = {
            max_value: 5,
            step_size: 0.25,
            initial_value: 0,
            // selected_symbol_type: 'fontawesome_star', // Must be a key from symbols
            cursor: 'default',
            readonly: true,
            change_once: false, // Determines if the rating can only be set once
            // ajax_method: 'POST',
            // url: 'http://localhost/test.php',
            // additional_data: {} // Additional data to send to the server
        }

        $(".rating").rate(options);

        $(document).ready(function(){
            $('.change_status').click(function(e){
                e.preventDefault();
                swal({
                    title: "Warning",
                    text: "Are you sure ?",
                    icon: "warning",
                    buttons: {
                        cancel: "Cancel",                
                        default: 'Ok',
                    },
                }).then((value)=>{
                    switch(value) {
                        case "default" :
                            $(this).parent().submit();
                            break;
                        case "cancel" :
                            break;
                    }
                });
                
            })

            $('.guest_status_change').click(function(e){
                e.preventDefault();
                swal({
                    title: "Warning",
                    text: "Are you sure ?",
                    icon: "warning",
                    buttons: {
                        cancel: "Cancel",                
                        default: 'Ok',
                    },
                }).then((value)=>{
                    switch(value) {
                        case "default" :
                            location.href = ($(this).attr('href'));
                            break;
                        case "cancel" :
                            break;
                    }
                });
            })

            $('.host_status span').removeClass('user_active user_warning')            
            if(parseInt($('.host_status span').text())){
                $('.host_status').addClass('user_active')
                $('.host_status span').text('Approved')
            }else{
                $('.host_status').addClass('user_warning')
                $('.host_status span').text('Pending')
            }

            $('.guest_status span').removeClass('user_active user_warning')
            if($('.guest_status span').text().trim() == 'Approved'){
                $('.guest_status').addClass('user_active')
            }else{
                $('.guest_status').addClass('user_warning')
            }
        })

    </script>
@endsection