@extends('layouts.app')

@section('title', 'Dashboard')
@section('css')
    <style>
        body {background-color: #F0F0F0;}
        .invalid-feedback {display: block;}
    </style>
@endsection
@php
    $side_bar = session('side_bar');
    $user = auth()->user();
@endphp
@section('content')
<section>
    <div class="page-banner">
        <div class="container">
            <div class="page-banner__tittle">
                @if ($user->role->type == 'host')
                    <h1>Once Upon a house</h1>
                    <p> <span></span> </p>                    
                @else
                    <h1>Once Upon a house</h1>
                    <p> <span></span> </p>
                @endif
            </div>
        </div>
    </div>
</section>

<section class="user_dashboard mt-5 mb-5">
    <div class="container p-3">
        <div class="row">
            <div class="col-3 side_bar p-4">
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
            <div class="col-1"></div>
            <div class="col-8 user_content p-4">
                <table class="table table-hover table-striped table-bordered text-center " id="notify">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>CONTENT</th>
                            <th>CREATED TIME</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $n = 0;
                        @endphp
                        @forelse ($user->notifications as $item)
                            @php
                                $n += 1;
                            @endphp
                            <tr>
                                <td>{{ $n }}</td>
                                <td>{{ $item->comment_en }}
                                <td>{{ $item->created_at }}
                            </tr>
                        @empty
                            <tr>
                                <td></td>
                                <td>There is no notification.</td>
                                <td></td>
                            </tr>
                        @endforelse
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

@endsection

@section('script')
    <script type="text/javascript" language="javascript" src="{{asset('DataTables/js/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript" language="javascript" src="{{asset('DataTables/js/dataTables.bootstrap4.min.js')}}"></script>
    <script>
        $('#notify').DataTable();
    </script>
@endsection