@php
  $page = session('page');
  $user_page_item = [
    'all_user',
    'host_user',
    'guest_user'
  ];
  $exp_page_item = [
    'all_exp',
    'approved_exp',
    'non_exp',
    'reject_exp'
  ];
  $booking_page_item = [
    'approve_booking',
    'pending_booking',
    'rejected_booking',
];
@endphp
  <div class="br-logo">
    <a href="{{route('welcome')}}">
      <img src="{{asset('img/logo.png')}}" width="55" alt="logo">
    </a>
  </div>

  <div class="br-sideleft sideleft-scrollbar">
    <label class="sidebar-label pd-x-10 mg-t-20 op-3">Navigation</label>
    <ul class="br-sideleft-menu">

      <li class="br-menu-item">
        <a href="{{route('admin.home')}}" class="br-menu-link {{ $page==='home' ? 'active' : null }}">
          <i class="menu-item-icon icon ion-ios-home-outline tx-24"></i>
          <span class="menu-item-label">{{ __('custom.dashboard') }}</span>
        </a>
      </li>

      <li class="br-menu-item">
        <a href="#" class="br-menu-link with-sub {{ $page == in_array($page, $booking_page_item) ? 'active show-sub' : null }}">
          <i class="menu-item-icon icon ion-flag tx-20"></i>
          <span class="menu-item-label">{{ __('custom.booking_manage') }}</span>
        </a>
        <ul class="br-menu-sub">
          <li class="sub-item"><a href="{{ route('admin.booking_manage_approve') }}" class="sub-link {{ $page == 'approve_booking' ? 'active' : null }}">{{ __('custom.approve_booking') }}</a></li>
          <li class="sub-item"><a href="{{ route('admin.booking_manage_pending') }}" class="sub-link {{ $page == 'pending_booking' ? 'active' : null }}">{{ __('custom.pending_booking') }}</a></li>
          <li class="sub-item"><a href="{{ route('admin.booking_manage_rejected') }}" class="sub-link {{ $page == 'rejected_booking' ? 'active' : null }}">{{ __('custom.rejected_booking') }}</a></li>
        </ul>
      </li>
      
      <li class="br-menu-item">
        <a href="#" class="br-menu-link with-sub {{ $page == in_array($page, $user_page_item) ? 'active show-sub' : null }}">
          <i class="menu-item-icon icon ion-person-stalker tx-20"></i>
          <span class="menu-item-label">{{ __('custom.user_manage') }}</span>
        </a>
        <ul class="br-menu-sub">
          <li class="sub-item"><a href="{{ route('admin.user_manage') }}" class="sub-link {{ $page == 'all_user' ? 'active' : null }}">{{ __('custom.all_user') }}</a></li>
          <li class="sub-item"><a href="{{ route('admin.user_manage_host') }}" class="sub-link {{ $page == 'host_user' ? 'active' : null }}">{{ __('custom.all_host') }}</a></li>
          <li class="sub-item"><a href="{{ route('admin.user_manage_guest') }}" class="sub-link {{ $page == 'guest_user' ? 'active' : null }}">{{ __('custom.all_guest') }}</a></li>
        </ul>
      </li>

      <li class="br-menu-item">
        <a href="#" class="br-menu-link with-sub {{ $page == in_array($page, $exp_page_item) ? 'active show-sub' : null }}">
          <i class="menu-item-icon icon ion-coffee tx-20"></i>
          <span class="menu-item-label">{{ __('custom.exp_manage') }}</span>
        </a>
        <ul class="br-menu-sub">
          <li class="sub-item"><a href="{{ route('admin.wajba_manage') }}" class="sub-link {{ $page == 'all_exp' ? 'active' : null }}">{{ __('custom.all_exp') }}</a></li>
          <li class="sub-item"><a href="{{ route('admin.wajba_manage_approve') }}" class="sub-link {{ $page == 'approved_exp' ? 'active' : null }}">{{ __('custom.approved_exp') }}</a></li>
          <li class="sub-item"><a href="{{ route('admin.wajba_manage_pending') }}" class="sub-link {{ $page == 'non_exp' ? 'active' : null }}">{{ __('custom.non_exp') }}</a></li>
          <li class="sub-item"><a href="{{ route('admin.wajba_manage_reject') }}" class="sub-link {{ $page == 'reject_exp' ? 'active' : null }}">{{ __('custom.reject_exp') }}</a></li>
        </ul>
      </li>

      <li class="br-menu-item">
        <a href="{{route('admin.history')}}" class="br-menu-link {{ $page==='history' ? 'active' : null }}">
          <i class="menu-item-icon icon ion-search tx-24"></i>
          <span class="menu-item-label">{{ __('custom.history') }}</span>
        </a>
      </li>

      <li class="br-menu-item">
        <a href="{{route('admin.setting')}}" class="br-menu-link {{ $page==='set' ? 'active' : null }}">
          <i class="menu-item-icon icon ion-gear-b tx-24"></i>
          <span class="menu-item-label">{{ __('custom.setting') }}</span>
        </a>
      </li>

    </ul>
    <br>
  </div>