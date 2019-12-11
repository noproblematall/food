@extends('admin.layouts.app')

@section('css')
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
                            <h5>{{ $user->role->type }}</h5>
                           <td>{{ $user->full_name }}</td>
                            <h5>{{ $user->mobile }}</h5>
                            <h5>{{ $user->email }}</h5>
                            <h5>{{ $user->gender }}</h5>
                            
                        </div>
                    </div>
                    <table class="table">
                        <thead>
                            <th>User Status</th>
                        </thead>
                        <tbody>
                            <tr>                                
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
                        <h2 class="mg-t-30">About Customer</h2>
                        <p></p>
                    </div>
                    
                    <h5 class="mg-t-20">- Balance of host&nbsp;(<span>$ 3500</span>)</h5>
                    
                    
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


            $('.guest_status span').removeClass('user_active user_warning')
            if($('.guest_status span').text().trim() == 'Approved'){
                $('.guest_status').addClass('user_active')
            }else{
                $('.guest_status').addClass('user_warning')
            }
        })

    </script>
@endsection