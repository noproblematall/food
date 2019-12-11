<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') | {{ config('app.name') }}</title>

    <link rel="stylesheet" href="{{asset('frontend/styles/css/slick.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/styles/css/slick-theme.css')}}">
    {{-- <link rel="stylesheet" href="{{asset('frontend/styles/css/jquery.datepicker2.css')}}"> --}}
    <link rel="stylesheet" href="{{asset('frontend/styles/css/animate.css')}}">
    <link href="{{ asset('jquery_toast/jquery.toast.min.css') }}" rel="stylesheet">
    
    <link rel="stylesheet" href="{{asset('frontend/styles/style.css')}}">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/custom.css')}}">
    <link rel="stylesheet" href="{{asset('css/admin/spinkit.css')}}">
    @yield('css')
</head>
<body>
    <header id="header-2">
        <div class="wand-container">
            <div class="header-content2">
                <div class="header-content2__logo">
                    <a class="header-content2__logo__sitename" href="{{route('welcome')}}"><img src="{{asset('img/logo.png')}}" width="75" alt="logo"></a>
                </div>
                
                <nav class="header-2-nav">
                    <ul>
                        <li>
                            <a href="{{route('welcome')}}">HOME</a>                        
                        </li>
                        <li>
                            <a href="{{route('about_us')}}">ABOUT US</a>                        
                        </li>
                        <li><a href="{{route('contact_us')}}">CONTACT US</a></li>
                        @guest
                            <li>
                                <a href="{{ route('login') }}">LOGIN</a>
                            </li>
                            <li>
                                <a href="{{ route('register') }}">REGISTER</a>
                            </li>                        
                        @else
                            @if (auth()->user()->role->type == 'guest')
                                <li>
                                    <a href="{{ route('become_host') }}">BECOME A HOST</a>
                                </li>
                            @endif
                            {{-- <li class="notify" id="">
                                <i class="far fa-bell fa-lg"></i>
                                <span class="notify_light"></span>
                                <ul class="sub-menu" style="right:0;">
                                    <li>
                                        <span class=""><b>Notifications</b></span>
                                        <span class="mark_all">Mark All As Read</span>
                                    </li>
                                    <div class="noti_container">
                                        <li><a href="">you created new wajba.</a></li>
                                    </div>
                                </ul>
                            </li> --}}
                            <li style="margin-left: 20px;">
                                @if (auth()->user()->photo)
                                    <div><img src="/{{ auth()->user()->photo->url }}" class="custom_avatar_image" alt="User Photo" srcset="" width="40" height="40" ></div>
                                @else
                                    <div class="custom_avatar">{{ auth()->user()->avatar }}</div>
                                @endif
                                    <ul class="sub-menu" style="right:0;">
                                        <li><a href="{{ route('home') }}">Dashboard</a></li>
                                        <li><a href="javascript:void(0);" class="change_password">Change Password</a></li>
                                        <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form1').submit();">Log out</a></li>
                                        <form id="logout-form1" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </ul>
                            </li>                                
                        @endguest
                            
                    </ul>
                </nav>    
                
                <nav class="header-nav-mobile">
                    <ul>
                        <li>
                            <a href="{{route('about_us')}}">HOME</a>
                        </li>
                        <li>
                            <a href="{{route('about_us')}}">ABOUT US</a>
                        </li>
                        <li>
                            <a href="{{route('contact_us')}}">CONTACT US</a>
                        </li>
                        @guest
                            <li>
                                <a href="{{ route('login') }}">LOGIN</a>
                            </li>
                            <li>
                                <a href="{{ route('register') }}">REGISTER</a>
                            </li>
                        @else
                            @if (auth()->user()->role->type == 'guest')
                                <li>
                                    <a href="{{ route('become_host') }}">BECOME A HOST</a>
                                </li>
                            @endif
                            <li>
                                <a href="{{ route('home') }}">DASHBOARD</a>
                            </li>
                            <li><a href="javascript:void(0);" class="change_password">CHANGE PASSWORD</a></li>
                            <li>
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form2').submit();">LOG OUT</a>
                            </li>
                            <form id="logout-form2" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        @endguest
                    </ul>
                </nav> 
    
                <div class="header-content2__hamburger">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div> 
        </div>
    </header>
    @if(Session::has('success'))
        <input type="hidden" name="" id="success_message" value="{{ Session::get('success') }}">
    @else
        <input type="hidden" name="" id="success_message" value="">
    @endif

    @yield('content')

    @include('layouts.footer')
    <div class="loader_container display_none">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1 bg-gray-800"></div>
            <div class="sk-child sk-bounce2 bg-gray-800"></div>
            <div class="sk-child sk-bounce3 bg-gray-800"></div>
        </div>
    </div>
    <!-- The Password Change Modal -->
    <div class="modal fade" id="password_modal">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">        
                <div class="modal-body">
                    <div class="alert alert-success display_none" id="alert1" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                        <div class="d-flex align-items-center justify-content-start">
                          <i class="icon ion-ios-checkmark alert-icon tx-32 mg-t-5 mg-xs-t-0"></i>
                          <span>{!! __('custom.admin_success', ['attribute' => 'password']) !!}</span>
                        </div><!-- d-flex -->
                    </div><!-- alert -->
                    <div class="alert alert-danger display_none" id="alert2" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <div class="d-flex align-items-center justify-content-start">
                            <i class="icon ion-ios-checkmark alert-icon tx-32 mg-t-5 mg-xs-t-0"></i>
                            <span><strong>Fail !</strong> The old password is incorrect.</span>
                        </div><!-- d-flex -->
                    </div><!-- alert -->
                    <div class="form-group mt-4">
                        <input class="form-control" id="old_password" placeholder="Old Password" type="password" autocomplete="off">
                        <small class="first">Please enter old password</small>
                    </div>
                    <div class="form-group">
                        <input class="form-control" id="new_password" placeholder="New Password" type="password">
                        <small class="second">Please enter new password</small>
                        <small class="third">Passwords must be match the confirmation.</small>
                    </div>
                    <div class="form-group">
                        <input class="form-control" id="confirm_password" placeholder="Confirm Password" type="password">
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-custom btn-block" id="password_save">Save</button>
                        <button type="button" id="password_close" class="btn btn-secondary btn-block" data-dismiss="modal">Close</button>
                    </div>                    
                </div>
            </div>
        </div>
    </div>
    {{-- <script src="{{asset('frontend/scripts/jquery-3.4.1.js')}}"></script> --}}
    <script src="{{asset('js/app.js')}}"></script>
    <script src="{{asset('frontend/scripts/slick.min.js')}}"></script>
    {{-- <script src="{{asset('frontend/scripts/jquery.datepicker2.js')}}"></script> --}}
    <script src="{{asset('frontend/scripts/isotope.pkgd.min.js')}}"></script>
    <script src="{{asset('frontend/scripts/app.js')}}"></script>
    <script src="{{ asset('jquery_toast/jquery.toast.min.js') }}"></script>
    <script>
        function toast_call(type, text, hideAfter = 5000, icon = 'success', bgColor = '#50aa5b') {
            $.toast({
                heading: type,
                text: text,
                showHideTransition: 'slide',
                icon: icon,
                position: 'bottom-right',
                bgColor: bgColor,
                hideAfter: hideAfter
            })
        }

        $(document).ready(function(){
            $('#password_close').click(function(){
                $('#old_password').val('');
                $('#new_password').val('');
                $('#confirm_password').val('');
                $('#alert1').addClass('display_none');
                $('#alert2').addClass('display_none');
            })
            $('.change_password').click(function(){
                $('#password_modal').modal({backdrop:'static'});
            })

            $('#password_save').click(function(){
                let old_password = $('#old_password').val();
                let new_password = $('#new_password').val();
                let confirm_password = $('#confirm_password').val();
                if(old_password == ''){
                    $('small.first').addClass('display_show');
                    return false;
                }
                if(new_password == ''){
                    $('small.first').removeClass('display_show');
                    $('small.second').addClass('display_show');
                    return false;
                }
                if(new_password != confirm_password){
                    $('small.second').removeClass('display_show');
                    $('small.third').addClass('display_show');
                    return false;
                }
                $('small.first').removeClass('display_show');
                $('small.second').removeClass('display_show');
                $('small.third').removeClass('display_show');
                $.ajax({
                    url: '/change_password',
                    type: 'get',
                    data: {old_password:old_password, new_password:new_password},
                    beforeSend: function () { $('.loader_container').removeClass('display_none'); },
                    success: function(data){
                    if(data.error){
                        $('#alert1').addClass('display_none');
                        $('#alert2').removeClass('display_none');
                    }else{
                        $('#alert2').addClass('display_none');
                        $('#alert1').removeClass('display_none');
                    }
                    }
                }).done(function () {
                    $('.loader_container').addClass('display_none');
                })
            })
        })
    
    </script>
    @yield('script')
</body>
</html>