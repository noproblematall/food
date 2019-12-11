@extends('admin.layouts.app')
<link rel="stylesheet" href="{{asset('slick/slick.css')}}">
<link rel="stylesheet" href="{{asset('slick/slick-theme.css')}}">
@section('css')
    <style>
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
        footer {
            margin-top: 0 !important;
        }
        .slick-prev {
            left: 15px;
            z-index: 1;
        }
        .slick-next {
            right: 15px;
            z-index: 1;
        }
        .slick-prev:hover {
            left: 15px;
            z-index: 1;
        }
        .slick-next:hover {
            right: 15px;
            z-index: 1;
        }
        .slick-dots {
            bottom: 2px;
        }
        .slick-dotted.slick-slider {
            margin-bottom: 0px;
        }
        .slick-dots li {
            margin: 0;
        }
        table tr td {
            text-align: left !important;
        }
    </style>
@endsection

@section('content')

    <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
        <div class="br-pagetitle">
            <div>
                <i class="icon ion-coffee"></i>
                <div>
                <h4>Experience Detail</h4>
                {{-- <p class="mg-b-0">Wajba detailed page</p> --}}
            </div>  
        </div>
        <div class="">
            <a href="{{ URL::previous() }}" class="btn btn-primary">Previous Page</a>
        </div>
    </div><!-- d-flex -->
    @php
        $status_string = array('Approved', 'Pending', 'Rejected');
    @endphp
    <div class="br-pagebody user_detail">            
        <div class="mg-t-20 card card-body">
            <div class="row">
                <div class="col-md-6 text-center">
                    <div class="row">
                        <div class="col-md-12">
                            @if ($wajba->photos()->where('type', 2)->exists())
                                <div class="slider-for">
                                    {{-- @foreach ($wajba->photos as $item) --}}
                                        @foreach ($wajba->photos()->where('type', 2)->get() as $item)
                                            <img src="{{ asset($item->url) }}" alt="First slide">                                            
                                        @endforeach
                                    {{-- @endforeach --}}
                                </div>
                            @else
                                <div class="slider-for">
                                    <img src="{{ asset('img/wajba/noimg1.png') }}" alt="No Image" srcset="">
                                    <img src="{{ asset('img/wajba/noimg2.png') }}" alt="No Image" srcset="">
                                </div>                        
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table">
                                <tr>
                                    <td>Owner</td>
                                    <td><a href="{{ route('admin.user_detail', $wajba->host->user->id) }}">{{ $wajba->host->user->firstName }}&nbsp;{{ $wajba->host->user->lastName }}</a></td>
                                </tr>
                                <tr>
                                    <td>Place</td>
                                    <td>{{ $wajba->place_category->name }}</td>
                                </tr>
                                <tr>
                                    <td>Food</td>
                                    <td>{{ $wajba->food_category->name }}</td>
                                </tr>
                                <tr>
                                    <td>Door Type</td>
                                    <td>
                                        @if ($wajba->door_type == 'in_door')
                                            Indoor
                                        @else
                                            Outdoor
                                        @endif    
                                    </td>
                                </tr>
                                <tr>
                                    <td>City</td>
                                    <td>{{ $wajba->city }}</a></td>
                                </tr>
                                <tr>
                                    <td><h5>Status</h5></td>
                                    <td>
                                        <div class="dropdown">
                                            <a href="" class="tx-gray-800 d-inline-block wajba_status" data-toggle="dropdown">
                                                <div class="ht-45 pd-x-20 bd d-flex align-items-center justify-content-center">
                                                <span class="mg-r-10 tx-13 tx-medium">
                                                    {{ $status_string[$wajba->status_id - 1] }}
                                                </span>
                                                <i class="fa fa-angle-down mg-l-10"></i>
                                                </div>
                                            </a>
                                            <div class="dropdown-menu pd-0 wd-50">
                                                <nav class="nav nav-style-1 flex-column">
                                                    @for ($i = 0; $i < count($status_string); $i++)
                                                        @if ($i != $wajba->status->id - 1)
                                                            <form action="{{ route('admin.wajba_status_change') }}" method="post">
                                                                @csrf
                                                                <input type="hidden" name="wajba_id" value="{{ $wajba->id }}">
                                                                <input type="hidden" name="status_id" value="{{ $i + 1 }}">
                                                                <a href="javascript::void(0)" class="nav-link change_status"> {{ $status_string[$i] }}</a>
                                                            </form>
                                                        @endif
                                                    @endfor
                                                </nav>
                                            </div><!-- dropdown-menu -->
                                        </div><!-- dropdown -->
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                                   
                </div>
                <div class="col-md-6">
                    <h3>{{ $wajba->title }}</h3>                   
                    <p>{{ $wajba->description }}</p>
                    <h5>- price ({{ $wajba->price }}$)</h5>
                    <div class="user_rate">
                        @if ($wajba->totalRate > 0)
                        <div class="rating float-left" data-rate-value={{ $wajba->totalRate }}></div>
                        <span class="float-left">{{ round(($wajba->totalRate), 2) }}&nbsp;&nbsp;|&nbsp;&nbsp;<a href="#">{{ $wajba->reviews()->count() }}&nbsp;<span style="font-size: 15px;">entries</span></a></span>
                        @else
                        <h5>- No Review yet.</h5>
                        @endif
                    </div>
                    <h5>- Health, Conditions And Warnings</h5>
                    <p>{{ $wajba->healthConditionsAndWarnings }}</p>
                    <h5>- Available Dates</h5>
                    <div id="app" class="mg-t-20">
                        <div class="row">
                            <div class="col-md-12 pd-l-30 pd-r-30">
                                <v-calendar :attributes='attrs' :min-date='new Date()' is-expanded/>
                            </div>
                        </div>
                    </div>
                   
                </div>

            </div>
        </div>
    </div>

@endsection

@section('script')
    <script src="{{ asset('js/admin/wajba_date.js') }}"></script>
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('js/rater.min.js') }}"></script>
    <script src="{{ asset('slick/slick.min.js') }}"></script>

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

        $('.slider-for').slick({
            infinite: true,
            autoplay: true,
            autoplaySpeed: 2000,
            dots: true,
            // fade: true,
        });

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

            $('.wajba_status span').removeClass('user_active user_warning')
            if($('.wajba_status span').text().trim() == 'Approved'){
                $('.wajba_status').addClass('user_active')
            }else{
                $('.wajba_status').addClass('user_warning')
            }
        })

    </script>
@endsection