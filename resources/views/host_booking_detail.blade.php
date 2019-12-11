@extends('layouts.app')

@section('title', 'Dashboard')
@section('css')
    <style>
        body {background-color: #F0F0F0;}
        .invalid-feedback {display: block;}
        .booking_detail p {font-weight: bold;}
        .booking_detail p span{font-weight: normal;}
    </style>
@endsection
@php
    $side_bar = session('side_bar');
    $user = auth()->user();
    $status_string = array('Approved', 'Pending', 'Rejected');
@endphp
@section('content')
<section>
    <div class="page-banner">
        <div class="container">
            <div class="page-banner__tittle">
                <h1>Once Upon a house</h1>
                <p> <span></span> </p>                
            </div>
        </div>
    </div>
</section>

<section class="user_dashboard mt-5 mb-5">
    <div class="container p-3">        
        <div class="row">
            <div class="col-md-3 col-12 side_bar p-4">
                <div class="row">
                    <div class="col-md-12 text-center">
                        @if ($user->photo()->exists())
                            <img src="{{ asset($user->photo->url) }}" class="custom_avatar_image" alt="User Photo" width="150" id="avatar" height="150" srcset="">
                        @else
                            <div class="custom_avatar_large m-auto">{{ $user->avatar }}</div>
                        @endif
                    </div>
                </div>
                <div class="row mt-3 side_bar_content">
                    @include('side_for_home')
                </div>
            </div>
            <div class="col-md-1 col-12"></div>
            <div class="col-md-8 col-12 user_content p-4">                
                <h3 class="text-center">"{{ $booking->wajba->title }}"</h3>
                <div class="row booking_detail">
                    <div class="col-md-6 col-12 mt-4">
                        <p>Booking Date: <span>{{ $booking->date->date }} {{ $booking->wajba->time->fromTime }} ~ {{ $booking->wajba->time->toTime }}</span></p>
                        <p>Number Of Males: <span>{{ $booking->numberOfMales }}</span></p>
                        <p>Number Of Females: <span>{{ $booking->numberOfFemales }}</span></p>
                        <p>Number Of Childrens: <span>{{ $booking->numberOfChildren }}</span></p>
                        <p>Total Amount: <span>{{ $booking->totalAmount }} SAR</span></p>
                    </div>
                    <div class="col-md-6 col-12 mt-4">
                        <p>Guest Name: <span>{{ $booking->user->full_name }}</span></p>
                        <p>Guest Email: <span>{{ $booking->user->email }}</span></p>
                        <p>Guest Gender: <span>{{ $booking->user->gender }}</span></p>
                        
                        <div class="dropdown">Status: 
                            <a href="" class="tx-gray-800 d-inline-block guest_status" data-toggle="dropdown">
                                <div class="ht-45 pd-x-20 bd d-flex align-items-center justify-content-center">
                                <span class="mg-r-10 tx-13 tx-medium">
                                    {{ $status_string[$booking->status_id - 1] }}
                                </span>
                                <i class="fa fa-angle-down mg-l-10"></i>
                                </div>
                            </a>
                            <div class="dropdown-menu pd-0 wd-50">
                                <nav class="nav nav-style-1 flex-column">
                                    @for ($i = 0; $i < count($status_string); $i++)
                                        @if ($i != $booking->status->id - 1)
                                            <form action="{{ route('booking_status_change') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                                                <input type="hidden" name="status_id" value="{{ $i + 1 }}">
                                                <a href="javascript::void(0)" class="nav-link change_status"> {{ $status_string[$i] }}</a>
                                            </form>
                                        @endif
                                    @endfor
                                </nav>
                            </div><!-- dropdown-menu -->
                        </div><!-- dropdown -->
                    
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-info text-center" role="alert">
                            By accepting booking request you agree to HiHome <a href="{{route('terms')}}">Terms and Conditions.</a>
                        </div>
                    </div>
                </div>
                
            </div>            
        </div>
    </div>
</section>

@endsection

@section('script')
    <script type="text/javascript" language="javascript" src="{{asset('DataTables/js/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript" language="javascript" src="{{asset('DataTables/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>
    <script>
        $('#booking').DataTable();
        if($('#success_message').val() != ''){
            toast_call('Success', $('#success_message').val(), false)
        }

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
    </script>
@endsection