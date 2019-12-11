@extends('admin.layouts.app')

@section('content')
@php
    $page_range = array('10', '25', '50', '100');
@endphp
    <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
        <div class="br-pagetitle">
            <i class="icon ion-search"></i>
            <div>
            <h4>History</h4>
            {{-- <p class="mg-b-0">History For Administrator</p> --}}
        </div>            
    </div><!-- d-flex -->

    <div class="br-pagebody">
        <div class="row row-sm mg-t-20 card card-body">
            <div class="col-md-12">
                <div class="search-form">
                    <form action="{{ route('admin.history') }}" method="POST" class="form-inline float-left" id="searchForm">
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
                        
                        {{-- <button type="submit" class="btn btn-sm btn-primary mb-2"><i class="fa fa-search"></i>&nbsp;&nbsp;Search</button> --}}
                        {{-- <button type="button" class="btn btn-sm btn-info mb-2 ml-1" id="btn-reset"><i class="fa fa-eraser"></i>&nbsp;&nbsp;Reset</button> --}}
                    </form>
                    <div class="clearfix"></div>
                </div>
                <div class="bd bd-gray-300 rounded table-responsive">
                    <table class="table table-bordered mg-b-0">
                        <thead>
                            <th>No</th>
                            <th>User</th>
                            <th>Content</th>
                            <th>Date</th>
                            {{-- <th>Detail</th> --}}
                        </thead>
                        <tbody>
                            @if ($logs->total() > 0)
                                @foreach ($logs as $item)
                                    <tr>
                                        <td>{{ (($logs->currentPage() - 1 ) * $logs->perPage() ) + $loop->iteration }}</td>
                                        <td>{{ $item->causer->full_name }}</td>
                                        <td>
                                            @if ($item->log_name == 'wajba')
                                                @if ($item->description == 'created')                                                    
                                                    @if ($item->subject)
                                                        New experience "<strong>{{ $item->subject->title }}</strong>" created.
                                                    @else
                                                        New experience created, but the experience already was deleted. So, can't show it.
                                                    @endif
                                                @endif
                                                @if ($item->description == 'updated')
                                                    @if ($item->subject)
                                                        The experience "<strong>{{ $item->subject->title }}</strong>" updated.
                                                    @else
                                                        This experience updated, but the experience already was deleted. So, can't show it.
                                                    @endif
                                                @endif
                                                @if ($item->description == 'status_changed')
                                                    @if ($item->subject)
                                                        The status of the experience "<strong>{{ $item->subject->title }}</strong>" changed to "<strong>{{ $item->getExtraProperty('status') }}</strong>".
                                                    @else
                                                        The status of this experience changed, but the experience deleted. So, can't show it.
                                                    @endif
                                                @endif
                                                @if ($item->description == 'deleted')
                                                    The experience ID"<strong>{{ $item->changes['attributes']['id'] }}</strong>" deleted.
                                                @endif
                                            @else
                                                @if ($item->description == 'created')                                                    
                                                    @if ($item->subject)
                                                        "<strong>{{ $item->causer->full_name }}</strong>" booked the experience "<strong>{{ $item->subject->wajba->title }}</strong>"
                                                    @else
                                                        New booking created, but the booking already was deleted. So, can't show it.
                                                    @endif
                                                @endif
                                                @if ($item->description == 'updated')
                                                    @if ($item->subject)
                                                        The experience "<strong>{{ $item->subject->title }}</strong>" updated.
                                                    @else
                                                        This experience updated, but the experience already was deleted. So, can't show it.
                                                    @endif
                                                @endif
                                                @if ($item->description == 'status_changed')
                                                    @if ($item->subject)
                                                        The status of the booking "<strong>{{ $item->subject->id }}</strong>" changed to "<strong>{{ $item->getExtraProperty('status') }}</strong>".
                                                    @else
                                                        The status of this experience changed, but the experience deleted. So, can't show it.
                                                    @endif
                                                @endif
                                                @if ($item->description == 'payment_status_changed')
                                                    @if ($item->subject)
                                                        The payment status of the booking "<strong>{{ $item->subject->id }}</strong>" changed to 
                                                        "<strong>
                                                            @if ($item->getExtraProperty('status') == 1)
                                                                Paid
                                                            @else
                                                                Not Paid
                                                            @endif
                                                        </strong>".
                                                    @else
                                                        The status of this experience changed, but the experience deleted. So, can't show it.
                                                    @endif
                                                @endif
                                                @if ($item->description == 'deleted')
                                                    The experience ID"<strong>{{ $item->changes['attributes']['id'] }}</strong>" deleted.
                                                @endif
                                            @endif    
                                        </td>
                                        <td>{{ $item->created_at }}</td>
                                        {{-- <td>
                                            <a href="{{ route('admin.booking_detail', $item->id) }}">&nbsp;<i class="fa fa-eye" style="color:#50aa5b;">&nbsp;</i></a>
                                        </td> --}}
                                    </tr>
                                @endforeach                                
                            @else
                                <tr>
                                    <td colspan="5">No History</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-12">
                <div class="clearfix mt-2">
                    <div class="float-left" style="margin: 0;">
                        <p>Total <strong style="color: red">{{ $logs->total() }}</strong> entries</p>
                    </div>
                    <div class="float-right" style="margin: 0;">
                        {{ $logs->appends(['pagesize' => $pagesize])->links() }}
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

            // $("#btn-reset").click(function(){
            //     $("#search_payment_status").val('');
            //     // $("#search_email").val('');
            //     // $("#search_phone").val('');
            // });
        })
    </script>
@endsection