<div class="br-header">
    <input type="hidden" name="" id="pusher_app_key" value="{{ config('app.pusher_app_key') }}">
    <div class="br-header-left">
        <div class="navicon-left hidden-md-down"><a id="btnLeftMenu" href=""><i class="icon ion-navicon-round"></i></a></div>
        <div class="navicon-left hidden-lg-up"><a id="btnLeftMenuMobile" href=""><i class="icon ion-navicon-round"></i></a></div>
        @php
            $notify_flag = Auth::user()->notifications()->where('is_new', 1)->exists();
        @endphp
    </div><!-- br-header-left -->
    <div class="br-header-right">
        <nav class="nav">
            {{-- <div class="dropdown">
                <a href="" class="nav-link pd-x-7 pos-relative" data-toggle="dropdown" aria-expanded="false" id="new_notify">
                    <i class="icon ion-ios-bell-outline tx-24"></i>
                @if ($notify_flag)
                    <span class="square-8 bg-danger pos-absolute t-15 r-5 rounded-circle"></span>
                @endif
                    
                </a>
                <div class="dropdown-menu dropdown-menu-header" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-83px, 52px, 0px);">
                    <div class="dropdown-menu-label">
                        <label>Notifications</label>
                        <a href="javascript::void(0);" id="mark_read">Mark All as Read</a>
                    </div><!-- d-flex -->
    
                    <div class="media-list">
                        <div class="notify_content notify_content{{ Auth::id() }}" id="notify_content{{ Auth::id() }}">
                            @if ($notify_flag)
                                @foreach (Auth::user()->notifications()->where('is_new', 1)->get() as $item)
                                    @if ($item->link != null)
                                        <!-- loop starts here -->
                                        <a href="{{ $item->link }}" class="media-list-link read">
                                            <div class="media">
                                                <div class="media-body">
                                                    @if (App::isLocale('ar'))
                                                        <p class="noti-text">{!! $item->comment_ar !!}</p>
                                                    @else
                                                        <p class="noti-text">{!! $item->comment_en !!}</p>
                                                    @endif
                                                </div>
                                            </div><!-- media -->
                                        </a>
                                        <!-- loop ends here -->                                        
                                    @else
                                        <!-- loop starts here -->
                                        <div class="media-list-link read">
                                            <div class="media">
                                                <div class="media-body">
                                                    @if (App::isLocale('ar'))
                                                        <p class="noti-text">{!! $item->comment_ar !!}</p>
                                                    @else
                                                        <p class="noti-text">{!! $item->comment_en !!}</p>
                                                    @endif
                                                </div>
                                            </div><!-- media -->
                                        </div>
                                        <!-- loop ends here -->    
                                    @endif
                                @endforeach                                
                            @else
                                <div href="javascript::void(0);" class="media-list-link read empty_notify">
                                    <div class="media">
                                        <div class="media-body">
                                            <p class="noti-text">No notifications</p>
                                        </div>
                                    </div><!-- media -->
                                </div>
                            @endif
                            
                        </div>
                        <!--<div class="dropdown-footer">
                            <a href=""><i class="fa fa-angle-down"></i> Show All Notifications</a>
                        </div>-->
                    </div><!-- media-list -->
                </div>
            </div> --}}
            <div class="dropdown">
                <a href="javascript:void(0);" class="nav-link nav-link-profile" data-toggle="dropdown">
                    <span class="logged-name hidden-md-down">{{$user->username}}</span>
                    @if ($user->photo()->exists())
                        <img src="{{asset($user->photo->url)}}" class="wd-32 rounded-circle" alt="">                        
                    @else
                        <img src="{{asset('img/avatar.png')}}" class="wd-32 rounded-circle" alt="">
                    @endif
                    <span class="square-10 bg-success"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-header wd-250">
                <div class="tx-center">
                    @if ($user->photo()->exists())
                        <img src="{{asset($user->photo->url)}}" class="wd-32 rounded-circle" alt="">                        
                    @else
                        <img src="{{asset('img/avatar.png')}}" class="wd-32 rounded-circle" alt="">     
                    @endif
                    <h6 class="logged-fullname">{{$user->username}}</h6>
                    <p>{{$user->email}}</p>
                </div>
                <hr>
                <ul class="list-unstyled user-profile-nav">
                    <li id="profile"><a href="javascript:void(0);"><i class="icon ion-ios-person"></i> Edit Profile</a></li>
                    <li id="password_change"><a href="javascript:void(0);"><i class="icon ion-unlocked"></i> Change Password</a></li>
                    <li>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();"><i class="icon ion-power"></i> Sign Out</a>
                    </li>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>

                </ul>
                </div><!-- dropdown-menu -->
            </div><!-- dropdown -->
        </nav>
    </div><!-- br-header-right -->
</div><!-- br-header -->