
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>{{config('app.name')}}</title>

  <link rel="stylesheet" href="{{asset('frontend/styles/css/all.min.css')}}">
  <link rel="stylesheet" href="{{asset('css/app.css')}}">
  <link rel="stylesheet" href="{{asset('frontend/styles/css/animate.css')}}">
  <link rel="stylesheet" href="{{asset('frontend/styles/style.css')}}">
  <link rel="stylesheet" href="{{asset('frontend/custom.css')}}">
</head>
<body>
<header id="header-1">
    <div class="wand-container">
        <div class="header-content1">
            <div class="header-content1__logo">
                <a class="header-logo" href="{{route('welcome')}}"><img src="{{asset('img/logo1.png')}}" width="100" alt="logo"></a>
            </div>
            <nav class="header-1-nav">
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
                        {{-- <li class="notify">
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
                        @if (auth()->user()->photo)
                            <li>
                                <div><img src="{{ auth()->user()->photo->url }}" alt="User Photo" class="custom_avatar_image" srcset="" width="40" height="40" style="vertical-align: middle;"></div>
                                <ul class="sub-menu" style="right:0;">
                                    <li><a href="{{ route('home') }}">Dashboard</a></li>
                                    <li><a href="javascript:void(0);" id="change_password">Change Password</a></li>
                                    <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form1').submit();">Log out</a></li>
                                    <form id="logout-form1" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </ul>
                            </li>
                        @else
                            <li>
                                <div class="custom_avatar">{{ auth()->user()->avatar }}</div>
                                <ul class="sub-menu" style="right:0;">
                                    <li><a href="{{ route('home') }}">Dashboard</a></li>
                                    <li><a href="javascript:void(0);" id="change_password">Change Password</a></li>
                                    <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form2').submit();">Log out</a></li>
                                    <form id="logout-form2" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </ul>
                            </li>
                        @endif
                    @endguest
                </ul>
            </nav> 
            <nav class="header-nav-mobile">
                <ul>
                    <li>
                        <a href="{{ asset('/') }}">HOME</a>
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
                        <li>
                            <a href="{{ route('home') }}">DASHBOARD</a>
                        </li>
                        <li><a href="javascript:void(0);" id="change_password">CHANGE PASSWORD</a></li>
                        <li>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form3').submit();">LOG OUT</a>
                        </li>
                        <form id="logout-form3" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @endguest
                </ul>
            </nav>

            <div class="header-content1__hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
        <div class="header-tittle1">
            {{-- <img src="{{asset('frontend/images/uploads/pagebanner/header1-tittle.png')}}" alt="header-1tittle">      --}}
            <h1 style="color: #fff;text-transform: uppercase;" class="mb-5">Eat and Engage with Saudis in their homes</h1>
            <a href="{{route('about_us')}}" class="text-center read_more">Read More</a>
        </div>
    </div>    
</header>

<section id="col-3-tours">
    <div class="container">
        <div class="trending-tour__tittle">
        <!-- section tittle -->            
            <div class="section-tittle">
                <h2>Hi home</h2>
                <div class="section-tittle__line-under"></div>
                <p>Food <span>Experience</span></p>
            </div>
        </div>
        <div class="row">
            @forelse ($wajba as $item)
                <div class="col-lg-4 col-sm-6 col-12">
                    <a href="{{ route('wajba_detail', $item->id) }}" class="trending-tour-item">
                        {{-- <div class="trending-tour-item__sale"></div> --}}
                        @if ($item->photos()->where('type', 0)->exists())
                            <img class="trending-tour-item__thumnail" src="{{asset($item->photos()->where('type', 0)->first()->url)}}" alt="tour1">
                        @else
                            <img class="trending-tour-item__thumnail" src="{{asset('frontend/images/uploads/tours/sample3.jpg')}}" alt="tour1">                            
                        @endif
                        <div class="trending-tour-item__info">
                            <h3 class="trending-tour-item__name ellipsis">
                                {{ $item->title }}
                            </h3>
                            <div class="trending-tour-item__group-infor">
                                <div class="trending-tour-item__group-infor--left">
                                    {{-- <span class="trending-tour-item__group-infor__rating"></span> --}}
                                    
                                    <div class="trending-tour-item__group-infor__lasting"><i class="fas fa-map-marker-alt" style="color: #a7662f"></i>&nbsp;&nbsp;{{ $item->city_name == '' ? $item->city : $item->city_name }}</div>
                                </div>

                                <span class="trending-tour-item__group-infor__sale-price">Estimated</span>
                                <span class="trending-tour-item__group-infor__price">SR&nbsp;{{ $item->price }}</span>
                
                            </div>
                        </div>
                    </a>
                </div>                
            @empty
            <div class="col-12">
                <h3>Cooming Soon...</h3>
            </div>
            @endforelse
            

            <div class="col-md-12">
                <div class="clearfix mt-2">
                    <div class="float-left" style="margin: 0;">
                        <p>Total <strong style="color: #a7662f">{{ $wajba->total() }}</strong> entries</p>
                    </div>
                    <div class="float-right" style="margin: 0;">
                        {{ $wajba->links() }}
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</section>

<div class="scroll-top">
    <i class="fas fa-angle-up"></i>
</div>

<footer id="footer-1">
    <div class="scroll-top">
        <i class="fas fa-angle-up"></i>
    </div>
    <div class="container">        
        <div class="row">
            <div class="col-lg-6 col-md-5">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="footer-widget-1 footer-widget-1--margin ">
                            <a href="{{ asset('/') }}"><img src="{{asset('img/logo1.png')}}" width="80" alt="footerlogo"></a>
                            <div class="footer-widget-1__text">
                                <p>
                                         
                                </p>
                            </div>   
                        </div>
                    </div>
                </div>
            </div>
            <div id="remove-padding" class="col-lg-6 col-md-7">
                <div class="footer-widget-1">
                    <div class="footer-widget-1__lists">
                                                
                        <div class="footer-widget-1__list">
                            <div class="footer-widget-1__tittle">
                                <h5>quick links</h5>
                                <div class="footer-widget-1__tittle__line-under"></div>                   
                            </div>
                            <ul>
                                <li><a href="{{route('welcome')}}">HOME</a></li>
                                <li><a href="{{route('about_us')}}">ABOUT US</a>  </li>
                                <li><a href="{{route('contact_us')}}">CONTACT US</a></li>
                                @guest
                                    <li>
                                        <a href="{{ route('login') }}">LOGIN</a>
                                    </li>                                                         
                                @else
                                    <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">LOG OUT</a></li>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                @endguest
                            </ul>
                        </div>

                        <div class="footer-widget-1__list">
                            <div class="footer-widget-1__tittle">
                                <h5>resources</h5>
                                <div class="footer-widget-1__tittle__line-under"></div>                   
                            </div>
                            <ul>
                                <li><a href="{{route('terms')}}">Terms And Conditions</a></li>
                                <li><a href="{{route('privacy')}}">Privacy Policy</a></li>
                                <li><a href="{{route('faq')}}">FAQ</a></li>
                                {{-- <li><a href="#">Information</a></li> --}}
                            </ul>
                        </div>
                    </div>                  
                </div>
            </div>
        </div>
    </div>
    <div class="copyright">
        <div class="container">
            <div class="copyright__area">
                <div class="copyright__license">
                    Copyright <i class="far fa-copyright"></i> 2019 {{ config('app.name') }}. All Rights Reserved.
                </div>
                <div class="copyright__social">
                    <a href="https://www.instagram.com/hihome.sa/"><i class="fab fa-instagram"></i></a>
                    <a href="https://www.facebook.com/hihome.sa/"><i class="fab fa-facebook"></i></a>
                    <a href="https://twitter.com/Hihome_sa"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
        </div>
    </div>
        
</footer>
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
<script src="{{asset('frontend/scripts/jquery.datepicker2.js')}}"></script>
<script src="{{asset('frontend/scripts/isotope.pkgd.min.js')}}"></script>


<script src="{{asset('frontend/scripts/app.js')}}"></script>
<script>
    $(document).ready(function(){
            $('#password_close').click(function(){
                $('#old_password').val('');
                $('#new_password').val('');
                $('#confirm_password').val('');
                $('#alert1').addClass('display_none');
                $('#alert2').addClass('display_none');
            })
            $('#change_password').click(function(){
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
</body>

</html>
