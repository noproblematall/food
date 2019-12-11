<div class="col-md-12">
    <ul>
        <li class="{{ $side_bar == 'profile' ? 'side_bar_active' : '' }}"><a href="{{ route('home') }}">Profile</a></li>
        @if (auth()->user()->host()->exists())
            <li class="{{ $side_bar == 'get_host_booking' ? 'side_bar_active' : '' }}"><a href="{{ route('get_host_booking') }}">Host Booking</a></li>
            <li class="{{ $side_bar == 'get_guest_booking' ? 'side_bar_active' : '' }}"><a href="{{ route('get_guest_booking') }}">Guest Booking</a></li>
        @else
            <li class="{{ $side_bar == 'get_guest_booking' ? 'side_bar_active' : '' }}"><a href="{{ route('get_guest_booking') }}">Guest Booking</a></li>
        @endif
        {{-- <li class="{{ $side_bar == 'get_notify' ? 'side_bar_active' : '' }}"><a href="{{ route('get_notify') }}">My Notification</a></li> --}}
        @if ($user->role->type == 'host')
            @if ($user->host->status == 1)
                <li class="{{ $side_bar == 'get_experience' ? 'side_bar_active' : '' }}"><a href="{{ route('get_experience') }}">My Experiences</a></li>
            @else
                <li style="background-color:#ccc;"><a href="javascript:void(0);"><span style="color:red;">(Host is pending now...)</span></a></li>
            @endif
        @endif
        
    </ul>
</div>