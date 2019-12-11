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
                <table class="table table-hover table-striped table-bordered text-center " id="booking">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>Experience</th>
                            {{-- <th>BOOKING DATE</th> --}}
                            <th>STATUS</th>
                            <th>CREATED DATE</th>
                            <th>DETAIL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $n = 0;
                        @endphp
                        @forelse ($user->bookings as $item)
                        @php
                            $n += 1;
                        @endphp
                            <tr>
                                <td>{{ $n }}</td>
                                <td>{{ $item->wajba->title }}</td>
                                {{-- <td>{{ $item->time->date->date }} {{ $item->time->fromTime }}~{{ $item->time->toTime }}</td> --}}
                                <td>
                                    @if ($item->status_id == 1)
                                        <span class="badge badge-primary">{{ $item->status->type }}</span>
                                    @endif
                                    @if ($item->status_id == 2)
                                        <span class="badge badge-warning">{{ $item->status->type }}</span>
                                    @endif
                                    @if ($item->status_id == 3)
                                        <span class="badge badge-danger">{{ $item->status->type }}</span>
                                    @endif
                                </td>
                                <td>{{ $item->created_at }}</td>
                                <td>
                                    <a href="{{ route('booking_edit', ['id' => $item->id]) }}" class="text-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            
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
        $('#booking').DataTable();
        if($('#success_message').val() != ''){
            toast_call('Success', $('#success_message').val(), false)
        }
    </script>
@endsection