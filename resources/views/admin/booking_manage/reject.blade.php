@extends('admin.layouts.app')
@section('css')
    <style>
        
    </style>
@endsection
@section('content')
@php
    $page_range = array('10', '25', '50', '100');
@endphp
    <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
        <div class="br-pagetitle">
            <i class="icon fa fa-eye-slash"></i>
            <div>
            <h4>Rejected Booking</h4>
            {{-- <p class="mg-b-0">Registed Rejected Bookings</p> --}}
        </div>            
    </div><!-- d-flex -->
    <div class="br-pagebody">
        <div class="row row-sm mg-t-20 card card-body">
            <div class="col-md-12">
                <div class="search-form">
                    <form action="{{ route('admin.booking_manage_rejected') }}" method="POST" class="form-inline float-left" id="searchForm">
                        @csrf
                        <label for="pagesize" class="control-label ml-3 mb-2">Show :</label>
                        <select class="form-control form-control-sm mx-2 mb-2" name="pagesize" id="pagesize">
                            <option value="10" @if($pagesize == '10') selected @endif>10</option>
                            <option value="25" @if($pagesize == '25') selected @endif>25</option>
                            <option value="50" @if($pagesize == '50') selected @endif>50</option>
                            <option value="100" @if($pagesize == '100') selected @endif>100</option>
                            <option value="all" @if(!in_array($pagesize, $page_range)) selected @endif>All</option>
                        </select>
                        {{-- <input type="text" class="form-control form-control-sm mr-sm-2 mb-2" name="fullName" id="search_name" value="{{ $fullName }}" placeholder="User Name">                         --}}
                        {{-- <input type="text" class="form-control form-control-sm mr-sm-2 mb-2" name="mobile" id="search_phone" value="{{ $mobile }}" placeholder="Mobile">
                        <input type="text" class="form-control form-control-sm mr-sm-2 mb-2" name="email" id="search_email" value="{{ $email }}" placeholder="Email"> --}}
                        <select name="payment_status" id="search_payment_status" class="form-control form-control-sm mr-2 mb-2">
                            <option value="">Please select.</option>
                            @if ($payment_status == "0")
                                <option value="0" selected>Not Paid</option>
                            @else
                                <option value="0">Not Paid</option>
                            @endif
                            @if ($payment_status == "1")
                                <option value="1" selected>Paid</option>
                            @else
                                <option value="1">Paid</option>
                            @endif
                        </select>
                        
                        <button type="submit" class="btn btn-sm btn-primary mb-2"><i class="fa fa-search"></i>&nbsp;&nbsp;Search</button>
                        <button type="button" class="btn btn-sm btn-info mb-2 ml-1" id="btn-reset"><i class="fa fa-eraser"></i>&nbsp;&nbsp;Reset</button>
                    </form>
                    <div class="clearfix"></div>
                </div>
                <div class="bd bd-gray-300 rounded table-responsive">
                    <table class="table table-bordered mg-b-0">
                        <thead>
                            <th>No</th>
                            <th>Experience Title</th>
                            <th>Guest Name</th>
                            <th>Number Of Booked People</th>
                            <th>Status</th>
                            <th>Detail</th>
                        </thead>
                        <tbody>
                            @if ($booking->total() > 0)
                                @foreach ($booking as $item)
                                    <tr>
                                        <td>{{ (($booking->currentPage() - 1 ) * $booking->perPage() ) + $loop->iteration }}</td>
                                        <td>{{ $item->wajba->title }}</td>
                                        <td>{{ $item->user->firstName }}&nbsp;{{ $item->user->lastName }}</td>
                                        <td>{{ $item->numberOfFemales + $item->numberOfMales + $item->numberOfChildren }}</td>
                                        <td>
                                            <span class="badge badge-danger pd-y-3 pd-x-10 tx-white tx-11 tx-roboto">{{ $item->status->type }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.booking_detail', $item->id) }}">&nbsp;<i class="fa fa-eye" style="color:#50aa5b;">&nbsp;</i></a>
                                        </td>
                                    </tr>
                                @endforeach                                
                            @else
                                <tr>
                                    <td colspan="5">No Booking</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-12">
                <div class="clearfix mt-2">
                    <div class="float-left" style="margin: 0;">
                        <p>Total <strong style="color: red">{{ $booking->total() }}</strong> entries</p>
                    </div>
                    <div class="float-right" style="margin: 0;">
                        {{ $booking->appends(['pagesize' => $pagesize])->links() }}
                    </div>
                </div>
            </div>
        </div><!-- row -->
    </div><!-- br-pagebody -->
    
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $("#pagesize").change(function(){
                $("#searchForm").submit();
            });

            $("#btn-reset").click(function(){
                $("#search_payment_status").val('');
                // $("#search_email").val('');
                // $("#search_phone").val('');
            });
        })
    </script>
@endsection