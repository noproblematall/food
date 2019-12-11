<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Password Reset | {{ config('app.name', 'Hihome') }}</title>

    <!-- Bracket CSS -->
    <link rel="stylesheet" href="{{asset('frontend/styles/css/animate.css')}}">
    <link rel="stylesheet" href="{{asset('css/admin/spinkit.css')}}">
    <link rel="stylesheet" href="{{asset('css/admin/bracket.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/custom.css')}}">
  </head>

  <body>

    <div class="d-flex align-items-center justify-content-center bg-gray-200 ht-100v">
        <img src="{{asset('frontend/images/login_banner.jpg')}}" class="wd-100p ht-100p object-fit-cover" alt="">
        <div class="overlay-body bg-black-6 d-flex align-items-center justify-content-center">
            
            <form action="{{ route('password.email') }}" method="post" id="reset_submit">
                @csrf
                
                <div class="login-wrapper wd-300 wd-xs-350 pd-25 pd-xs-40 bg-white rounded shadow-base animated zoomIn" id="login_form">
                    <div class="signin-logo tx-center tx-28 tx-bold tx-inverse"><a href="{{ asset('/') }}"><img src="{{asset('img/logo.png')}}" width="75" alt="logo"></a></div>
                    @if (session('status'))
                        <div class="alert alert-success mg-t-20" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="tx-center mg-t-20 mg-b-10" style="color:#a7662f;">{{ __('Reset Password') }}</div>                    
                    <div class="form-group">
                        <label for="email">{{ __('E-Mail Address') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div><!-- form-group -->
                    <button type="button" class="btn btn-custom btn-block" id="reset">{{ __('Send Password Reset Link') }}</button>

                    <div class="mg-t-20 tx-center">Not yet a member? <a href="{{ route('register') }}" class="tx-info">Sign Up</a></div>
                </div><!-- login-wrapper -->
            </form>
    </div><!-- d-flex -->

    <div class="loader_container display_none">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1 bg-gray-800"></div>
            <div class="sk-child sk-bounce2 bg-gray-800"></div>
            <div class="sk-child sk-bounce3 bg-gray-800"></div>
        </div>
    </div>
    <script src="{{asset('js/jquery-3.4.1.min.js')}}"></script>
    <script>
        $(document).ready(function(){
            $('#reset').click(function(){
                $('.loader_container').removeClass('display_none')
                $('#reset_submit').submit();
            })
        })
    </script>
  </body>
</html>
