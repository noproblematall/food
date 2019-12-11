@extends('admin.layouts.app')
@section('css')
    <link rel="stylesheet" href="{{asset('select2/css/select2.min.css')}}">
    <style>
        .select2 {
            margin-bottom: 8px;
            margin-right: 8px;
        }
    </style>
@endsection
@section('content')
@php
    $page_range = array('10', '25', '50', '100');
@endphp
    <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
        <div class="br-pagetitle">
            <i class="icon ion-pizza"></i>
            <div>
            <h4>Approved Experience</h4>
            {{-- <p class="mg-b-0">Approved All Wajbas</p> --}}
        </div>            
    </div><!-- d-flex -->
    <div class="br-pagebody" id="app">            
        <div class="row row-sm mg-t-20 card card-body">
            <div class="col-md-12">
                <div class="search-form">
                    <form action="{{ route('admin.wajba_manage_approve') }}" method="POST" class="form-inline float-left" id="searchForm">
                        @csrf
                        <label for="pagesize" class="control-label ml-3 mb-2">Show :</label>
                        <select class="form-control form-control-sm mx-2 mb-2" name="pagesize" id="pagesize">
                            <option value="10" @if($pagesize == '10') selected @endif>10</option>
                            <option value="25" @if($pagesize == '25') selected @endif>25</option>
                            <option value="50" @if($pagesize == '50') selected @endif>50</option>
                            <option value="100" @if($pagesize == '100') selected @endif>100</option>
                            <option value="all" @if(!in_array($pagesize, $page_range)) selected @endif>All</option>
                        </select>
                        <input type="text" class="form-control form-control-sm mr-sm-2 mb-2" name="title" id="search_title" value="{{ $title }}" placeholder="Title">
                        
                        <select name="place_id" id="search_place" class="form-control form-control-sm mx-2 mb-2">
                            <option value="">Place Type</option>
                            @foreach ($place_category as $item)
                                @if ($item->id == $place_id)
                                    <option value="{{ $item->id }}" selected>{{ $item->name }}</option>                                    
                                @else
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        <select name="food_id" id="search_food" class="form-control form-control-sm mx-2 mb-2">
                            <option value="">Food Type</option>
                            @foreach ($food_category as $item)
                                @if ($item->id == $food_id)
                                    <option value="{{ $item->id }}" selected>{{ $item->name }}</option>                                    
                                @else
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endif                                
                            @endforeach
                        </select>
                        <select name="door_type" id="search_door" class="form-control form-control-sm mr-2 mb-2">
                            <option value="">Door Type</option>
                            <?php
                                if($door_type == 'in_door'){                                    
                            ?>
                                <option value="in_door" selected>In Door</option>
                            <?php
                                }else{
                            ?>
                                <option value="in_door">In Door</option>
                            <?php
                                }
                                if($door_type == 'out_door'){
                            ?>
                                <option value="out_door" selected>Out Door</option>                                
                            <?php
                                }else{
                            ?>
                                <option value="out_door">Out Door</option> 
                            <?php
                                }
                            ?>
                            
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
                            <th>Title</th>
                            <th>Place Type</th>
                            <th>Food Type</th>
                            <th>Door Type</th>
                            <th>Host Name</th>
                            <th>Status</th>
                            <th>Detail</th>
                        </thead>
                        <tbody>
                            @foreach ($wajba as $item)
                            <tr>
                                <td>{{ (($wajba->currentPage() - 1 ) * $wajba->perPage() ) + $loop->iteration }}</td>
                                <td>{{ $item->title }}</td>
                                <td>{{ $item->place_category->name }}</td>
                                <td>{{ $item->food_category->name }}</td>
                                <td>{{ $item->door_type }}</td>
                                <td>{{ $item->host->user->firstName }}&nbsp;{{ $item->host->user->lastName }}</td>
                                <td>
                                    <span class="badge badge-primary pd-y-3 pd-x-10 tx-white tx-11 tx-roboto">{{ $item->status->type }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.wajba_detail', $item->id) }}">&nbsp;<i class="fa fa-eye" style="color:#50aa5b;">&nbsp;</i></a>
                                </td>
                            </tr>
                            @endforeach                        
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-12">
                <div class="clearfix mt-2">
                    <div class="float-left" style="margin: 0;">
                        <p>Total <strong style="color: red">{{ $wajba->total() }}</strong> entries</p>
                    </div>
                    <div class="float-right" style="margin: 0;">
                        {{ $wajba->appends(['title' => $title, 'place_id' => $place_id, 'food_id' => $food_id, 'door_type' => $door_type, 'pagesize' => $pagesize])->links() }}
                    </div>
                </div>
            </div>
        </div><!-- row -->
    </div><!-- br-pagebody -->
    
@endsection

@section('script')
<script src="{{asset('select2/js/select2.min.js')}}"></script>
    <script>
        $(document).ready(function(){
            $('#search_place').select2();
            $('#search_food').select2();

            $("#pagesize").change(function(){
                $("#searchForm").submit();
            });

            $("#search_place").select2({
                placeholder: 'Place Type'
            });
            $("#search_food").select2({
                placeholder: 'Food Type'
            });
            $("#btn-reset").click(function(){
                $("#search_title").val('');
                $("#search_place").val([]).trigger('change');
                $("#search_food").val([]).trigger('change');
                $("#search_door").val('');
            });
        })
    </script>
@endsection