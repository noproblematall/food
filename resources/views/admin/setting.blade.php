@extends('admin.layouts.app')
@section('css')    
    <style>
        .select2 {
            width:100%!important;
        }
        .br-section-label {
            margin-top: 20px;
        }
        .category_container {
            border: .5px solid #e4e3e3
        }
    </style>
@endsection
@section('content')
    @if(Session::has('success'))
        <input type="hidden" name="" id="success_message" value="{{ Session::get('success') }}">
    @else
        <input type="hidden" name="" id="success_message" value="">
    @endif

    <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
        <div class="br-pagetitle">
            <i class="icon ion-gear-a"></i>
            <div>
            <h4>Settings</h4>
            <p class="mg-b-0">Setting For Wajba</p>
        </div>            
    </div><!-- d-flex -->
    
    <div class="br-pagebody">
        <div class="row row-sm mg-t-20 card card-body">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-6 category_container">
                        <h6 class="br-section-label">Place Category</h6>
                        <form action="{{ route('admin.delete_place') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-8 col-6">
                                    <select name="place_id" id="search_place" class="form-control form-control-sm mx-2 mb-2">
                                        <option value="">Place Type</option>
                                        @foreach ($place_category as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 col-6 text-right">
                                    <button type="submit" class="btn btn-warning mb-2"><i class="fa fa-eraser"></i>&nbsp;&nbsp;Delete</button>
                                </div>
                            </div>
                        </form>
                        <form action="{{ route('admin.add_place') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-8 col-6">
                                    <input class="form-control @error('new_place') is-invalid @enderror" name="new_place" placeholder="Add Place" type="text">
                                    @error('new_place')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-4 col-6 text-right">
                                    <button type="submit" class="btn btn-primary mb-2"><i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Add</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-6 category_container">
                        <h6 class="br-section-label">Food Category</h6>
                        <form action="{{ route('admin.delete_food') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-8 col-6">
                                    <select name="food_id" id="search_food" class="form-control form-control-sm mx-2 mb-2">
                                        <option value="">Food Type</option>
                                        @foreach ($food_category as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 col-6 text-right">
                                    <button type="submit" class="btn btn-warning mb-2"><i class="fa fa-eraser"></i>&nbsp;&nbsp;Delete</button>
                                </div>
                            </div>
                        </form>
                        <form action="{{ route('admin.add_food') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-8 col-6">
                                    <input class="form-control @error('new_food') is-invalid @enderror" name="new_food" placeholder="Add Food" type="text">
                                    @error('new_food')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-4 col-6 text-right">
                                    <button type="submit" class="btn btn-primary mb-2"><i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Add</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script src="{{asset('select2/js/select2.min.js')}}"></script>
<script>
    $(document).ready(function(){
        
        $("#search_place").select2({
            placeholder: 'Place Type'
        });
        $("#search_food").select2({
            placeholder: 'Food Type'
        });
        $("#btn-reset").click(function(){
            $("#search_place").val([]).trigger('change');
            $("#search_food").val([]).trigger('change');
        });

        if($('#success_message').val() != ''){
            toast_call('Success', $('#success_message').val())
        }

    })
    


</script>
@endsection