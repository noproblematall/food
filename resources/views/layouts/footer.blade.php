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
                                {{-- <li><a href="#"></a></li> --}}
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