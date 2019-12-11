<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>LogIn | {{ config('app.name', 'Hihome') }}</title>

    <!-- Bracket CSS -->
    <link href="{{asset('css/app.css')}}" rel="stylesheet">
    <link href="{{asset('css/ionicons.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('frontend/styles/css/animate.css')}}">
    <link rel="stylesheet" href="{{asset('css/admin/spinkit.css')}}">
    <link rel="stylesheet" href="{{asset('css/admin/bracket.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/custom.css')}}">
    <style>
        .ckbox b {cursor: pointer;color: #a7662f;}
        .form-group {margin-bottom: 5px;}
        #empty_alert, #error_alert {position: relative;padding: .15rem 1.25rem;margin-bottom: 7px;border: 1px solid transparent;border-radius: .25rem;font-size: 12px;}
        .custom-file-label{white-space: nowrap;overflow: hidden;}
    </style>
  </head>

  <body>
    
    <div class="d-flex align-items-center justify-content-center bg-gray-200 ht-100v">
        <img src="{{asset('frontend/images/login_banner.jpg')}}" class="wd-100p ht-100p object-fit-cover" alt="">
        <div class="overlay-body bg-black-6 d-flex align-items-center justify-content-center ">
            <div class="login-wrapper wd-300 wd-xs-350 pd-25 pd-xs-40 bg-white rounded shadow-base animated zoomIn" id="verify_form">
                <div class="signin-logo tx-center tx-28 tx-bold tx-inverse"><a href="{{ asset('/') }}"><img src="{{asset('img/logo.png')}}" width="75" alt="logo"></a></div>
                <div class="tx-center mg-t-20 mg-b-10">Please enter your phone number</div>
                <div class="form-group">
                    <div class="d-md-flex pd-y-20 pd-md-y-0">
                        <input type="text" class="form-control wd-60 mg-r-5" id="phone_code" value="+966" required>
                        <input type="text" class="form-control" placeholder="Enter your mobile" id="mobile_verify" value="" required autofocus>                        
                    </div>
                    <span class="custom-invalid-feedback display_none" id="empty_mobile" role="alert">
                        <strong>Please enter valid mobile.</strong>
                    </span>
                    <span class="custom-invalid-feedback display_none" id="many_mobile" role="alert">
                        <strong>Too many requests.</strong>
                    </span>
                    <span class="custom-invalid-feedback display_none" id="unique_mobile" role="alert">
                        <strong>The mobile has already been taken.</strong>
                    </span>
                </div><!-- form-group -->
                <label class="ckbox ckbox-success mg-t-15">
                    <input type="checkbox" id="terms"><span>I agree to the <b>Terms and Conditions</b></span>
                </label>
                <button type="button" class="btn btn-custom btn-block mg-t-10" id="verify" disabled>Verify</button>

                <div class="mg-t-20 tx-center">Already a member? <a href="{{ route('login') }}" class="tx-info">Sign In</a></div>
            </div><!-- login-wrapper -->

            <div class="login-wrapper wd-300 wd-xs-350 pd-25 pd-xs-40 bg-white rounded shadow-base display_none animated zoomIn" id="confirm_form">
                <div class="signin-logo tx-center tx-28 tx-bold tx-inverse"><a href="{{ asset('/') }}"><img src="{{asset('img/logo.png')}}" width="75" alt="logo"></a></div>
                <div class="alert alert-success display_none" id="empty_alert">
                    <strong>Success!</strong> Resent code successfully.
                </div>
                <div class="tx-center mg-b-30">Please enter your verification code</div>

                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Enter your code" id="code_confirm">
                    <span class="custom-invalid-feedback display_none" id="empty_code" role="alert">
                        <strong>Please enter confirm code.</strong>
                    </span>
                    <span class="custom-invalid-feedback display_none" id="invaild_code" role="alert">
                        <strong>The code you’ve entered is incorrect, please enter the correct code.</strong>
                    </span>
                </div><!-- form-group -->
                <button type="button" class="btn btn-info btn-block mg-t-20" id="confirm">Confirm</button>
                <button type="button" class="btn btn-custom btn-block mg-t-20 display_none" id="resend">Resend</button>
                <a href="{{ route('login') }}" class="tx-info tx-12 d-block mg-t-30 text-center">Login with mobile and password</a>

            </div><!-- login-wrapper -->

            
            <form action="{{ route('register') }}" method="post" id="user_register_form"  enctype="multipart/form-data">
                @csrf
                <div class="login-wrapper wd-300 wd-xs-350 pd-25 pd-xs-40 bg-white rounded shadow-base animated zoomIn display_none" id="register_form">
                    <div class="signin-logo tx-center tx-28 tx-bold tx-inverse"><a href="{{ asset('/') }}"><img src="{{asset('img/logo.png')}}" width="75" alt="logo"></a></div>
                    <div class="tx-center mg-b-20 mg-t-10">Please enter your info</div>

                    <div class="form-group text-center">
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="guest_check" checked name="check" value="guest">
                            <label class="custom-control-label" for="guest_check">Guest</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="host_check" name="check" value="host">
                            <label class="custom-control-label" for="host_check">Host</label>
                        </div>
                    </div>

                    <div class="alert alert-warning display_none" id="error_alert">
                        {{-- <ul>

                        </ul> --}}
                    </div>

                    <div id="for_guest">
                        <div class="form-group">
                            <input type="text" class="form-control" name="firstName" value="{{ old('firstName') }}" placeholder="Enter your first name" required autofocus>
                                <span class="invalid-feedback" role="alert" id="firstname_error">
                                    <strong>First Name Required</strong>
                                </span>
                        </div><!-- form-group -->
                        <div class="form-group">
                            <input type="text" class="form-control" name="lastName" value="{{ old('lastName') }}" placeholder="Enter your last name" required>
                                <span class="invalid-feedback" role="alert" id="lastname_error">
                                    <strong>Last Name Required</strong>
                                </span>
                        </div><!-- form-group -->
                        <div class="form-group">
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Enter your email" required>
                                <span class="invalid-feedback" role="alert" id="email_require_error">
                                    <strong>Email Required</strong>
                                </span>
                                <span class="invalid-feedback" role="alert" id="email_invalid">
                                    <strong>Invalid Email</strong>
                                </span>
                        </div><!-- form-group -->
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="mobile" value="{{ old('mobile') }}" id="mobile_number">
                        </div><!-- form-group -->
                        <div class="form-group">
                            <label class="d-block tx-11 tx-uppercase tx-medium tx-spacing-1">The password must be at least 8 characters.</label>
                            <input type="password" class="form-control" name="password" placeholder="Enter your password" required>
                                <span class="invalid-feedback" role="alert" id="password_error">
                                    <strong>The password must be at least 8 characters.</strong>
                                </span>                                
                        </div><!-- form-group -->
                        <div class="form-group">
                            <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm your password" required>
                            <span class="invalid-feedback" role="alert" id="password_match">
                                <strong>The password confirmation does not match.</strong>
                            </span>
                        </div><!-- form-group -->
                        <div class="form-group">
                            <input type="text" class="form-control" name="city" id="city" value="{{ old('city') }}" placeholder="Enter your city" required>
                                <span class="invalid-feedback" role="alert" id="city_error">
                                    <strong>City Required</strong>
                                </span>
                        </div><!-- form-group -->
                        <div class="form-group">
                            <label class="d-block tx-11 tx-uppercase tx-medium tx-spacing-1">Gender</label>
                            <select class="form-control select2" name="gender" data-placeholder="Gender" id="register_gender">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div><!-- form-group -->
                    </div>
                    
                    <div id="for_host" class="display_none">
                        <div class="form-group">
                            <label for="nameId">Nickname</label>
                            <input type="text" name="nameId" class="form-control" id="name_id"  value="{{ old('nameId') }}">
                            <span class="invalid-feedback" role="alert" id="name_id_error">
                                <strong>Nickname Required</strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="#">Photo</label>
                            <div class="custom-file">
                                <label for="photo" class="custom-file-label">Choose file</label>
                                <input type="file" class="custom-file-input" name="photo" id="photo">
                            </div>
                            <span class="invalid-feedback" role="alert" id="photo_error">
                                <strong>Photo Required</strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="about_you">About You</label>
                            <textarea name="aboutYou" id="about_you" class="form-control" cols="30" rows="5">{{old('aboutYou')}}</textarea>
                            <span class="invalid-feedback" role="alert" id="about_error">
                                <strong>About You Required</strong>
                            </span>
                        </div>
                    </div>
                    {{-- <div class="form-group tx-12">By clicking the Sign Up button below, you agreed to our privacy policy and terms of use of our website.</div> --}}
                    <button type="button" id="sign_submit" class="btn btn-info btn-block">Sign Up</button>
                    <button type="button" id="sign_next" class="btn btn-info btn-block display_none">Next</button>
                    <button type="button" id="sign_prev" class="btn btn-info btn-block display_none">Back</button>

                    <div class="mg-t-30 tx-center">Already a member? <a href="{{ route('login') }}" class="tx-info">Sign In</a></div>
                </div><!-- login-wrapper -->
            </form>
        </div>
    </div><!-- d-flex -->


    <div class="modal" id="term_modal">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
            
            <!-- Modal Header -->
            <div class="modal-header">
                <h1 class="modal-title">Terms And Conditions</h1>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            
            <!-- Modal body -->
            <div class="modal-body">
                @include('term')
            </div>
            
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-custom" data-dismiss="modal">Close</button>
            </div>
            
            </div>
        </div>
    </div>


    <div class="loader_container display_none">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1 bg-gray-800"></div>
            <div class="sk-child sk-bounce2 bg-gray-800"></div>
            <div class="sk-child sk-bounce3 bg-gray-800"></div>
        </div>
    </div>

    {{-- <script src="{{asset('js/jquery-3.4.1.min.js')}}"></script> --}}
    <script src="{{asset('js/app.js')}}"></script>
    <script src="{{ asset('js/frontend/register.js') }}"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{ config('app.googlemap_key') }}&libraries=places"></script>
    <script defer>
        $(document).ready(function(){

            $(".custom-file-input").on("change", function() {
                let fileName = $(this).val().split("\\").pop();
                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            });

            if (document.getElementById('host_check').checked) {
                $('#sign_submit').addClass('display_none')
                $('#sign_next').removeClass('display_none')
            }else{
                $('#sign_next').addClass('display_none')
                $('#sign_submit').removeClass('display_none')
            }
            
            $('label.ckbox').click(function(){
                if (document.getElementById('terms').checked) {
                    $('#verify').removeAttr('disabled');
                }else{
                    $('#verify').attr('disabled', 'disabled');
                }
            })

            $('input[type=radio]').click(function(){
                if (document.getElementById('host_check').checked) {
                    $('#sign_submit').addClass('display_none')
                    $('#sign_next').removeClass('display_none')
                }else{
                    $('#sign_next').addClass('display_none')
                    $('#sign_submit').removeClass('display_none')
                }
            })

            $('#sign_submit').click(function(){
                $('#error_alert ul').empty()
                let first_name = $('input[name="firstName"]').val()
                let last_name = $('input[name="lastName"]').val()
                let email = $('input[name="email"]').val()
                let city = $('input[name="city"]').val()
                let mobile = $('#mobile_number').val()
                let password = $('input[name="password"]').val()
                let password_confirm = $('input[name="password_confirmation"]').val()
                let gender = $('#register_gender').val()
                let check = document.querySelector('input[name="check"]:checked').value;

                if (document.getElementById('host_check').checked) {
                        let name_id = $('#name_id').val()
                        let photo = $('#photo').val()
                        let about_you = $('#about_you').val()
                        if (name_id == '') {
                            init_validate()
                            $('#name_id_error').addClass('display_show')
                            return
                        }
                        // if (photo == '') {
                        //     init_validate()
                        //     $('#photo_error').addClass('display_show')
                        //     return
                        // }
                        if (about_you == '') {
                            init_validate()
                            $('#about_error').addClass('display_show')
                            return
                        }
                        $('loader_container').removeClass('display_none')
                        var user_register_form = document.getElementById("user_register_form")
                        var formData = new FormData(user_register_form);

                        $.ajax({
                            url: '/register',
                            type: 'post',
                            data: formData,
                            contentType: false,
                            cache: false,
                            processData:false,
                            beforeSend: function () { $('.loader_container').removeClass('display_none'); },
                            success: function(data){
                                // console.log(data)
                                location.reload();
                            },
                            error: function(xhr, status, error){
                                var err = eval("(" + xhr.responseText + ")");
                                if(!$.isEmptyObject(err.errors)){
                                    let txt = ''
                                    $.each( err.errors, function( key, value ) {
                                        txt += "<li>"+ value +"</li>";
                                    });
                                    $('#error_alert').append(txt);
                                    $('#error_alert').removeClass('display_none')
                                    // console.log(err.errors)
                                }
                                $('.loader_container').addClass('display_none');
                            }
                        }).done(function () {
                            $('.loader_container').addClass('display_none');
                        })


                }else{
                    
                    if(first_name == ''){
                        init_validate()
                        $('#firstname_error').addClass('display_show')
                        return
                    }
                    if(last_name == ''){
                        init_validate()
                        $('#lastname_error').addClass('display_show')
                        return
                    }
                    if(email == ''){
                        init_validate()
                        $('#email_require_error').addClass('display_show')
                        return
                    }
                    if(!ValidateEmail(email)){
                        init_validate()
                        $('#email_invalid').addClass('display_show')
                        return
                    }
                    if (password == '' || password.length < 8) {
                        init_validate()
                        $('#password_error').addClass('display_show')
                        return
                    }
                    if (password != password_confirm) {
                        init_validate()
                        $('#password_match').addClass('display_show')
                        return
                    }
                    if (city == '') {
                        init_validate()
                        $('#city_error').addClass('display_show')
                        return
                    }
                    $('loader_container').removeClass('display_none')
                    $.ajax({
                        url: '/register',
                        type: 'post',
                        data: {firstName: first_name, lastName: last_name, email: email, mobile: mobile, password: password, city: city, gender: gender,_token: $('input[name=_token]').val(), check: check},
                        beforeSend: function () { $('.loader_container').removeClass('display_none'); },
                        success: function(data){
                            location.reload();
                        },
                        error: function(xhr, status, error){
                            var err = eval("(" + xhr.responseText + ")");
                            if(!$.isEmptyObject(err.errors)){
                                let txt = ''
                                $.each( err.errors, function( key, value ) {
                                    txt += "<li>"+ value +"</li>";
                                });
                                $('#error_alert').append(txt);
                                $('#error_alert').removeClass('display_none')
                                // console.log(err.errors)
                            }
                            $('.loader_container').addClass('display_none');
                        }
                    }).done(function () {
                        $('.loader_container').addClass('display_none');
                    }) 
                    
                }  
                
            })

            $('#sign_next').click(function(){
                init_validate()
                let first_name = $('input[name="firstName"]').val()
                let last_name = $('input[name="lastName"]').val()
                let email = $('input[name="email"]').val()
                let city = $('input[name="city"]').val()                
                let password = $('input[name="password"]').val()
                let password_confirm = $('input[name="password_confirmation"]').val()
                if(first_name == ''){
                    init_validate()
                    $('#firstname_error').addClass('display_show')
                    return
                }
                if(last_name == ''){
                    init_validate()
                    $('#lastname_error').addClass('display_show')
                    return
                }
                if(email == ''){
                    init_validate()
                    $('#email_require_error').addClass('display_show')
                    return
                }
                if(!ValidateEmail(email)){
                    init_validate()
                    $('#email_invalid').addClass('display_show')
                    return
                }
                if (password == '' || password.length < 8) {
                    init_validate()
                    $('#password_error').addClass('display_show')
                    return
                }
                if (password != password_confirm) {
                    init_validate()
                    $('#password_match').addClass('display_show')
                    return
                }
                if (city == '') {
                    init_validate()
                    $('#city_error').addClass('display_show')
                    return
                }
                $('#for_guest').addClass('display_none')
                $('#for_host').removeClass('display_none')
                $(this).addClass('display_none')
                $('#sign_submit').removeClass('display_none')
                $('#sign_prev').removeClass('display_none')
            })

            $('#sign_prev').click(function(){
                $(this).addClass('display_none')
                $('#sign_submit').addClass('display_none')
                $('#sign_next').removeClass('display_none')
                $('#for_guest').removeClass('display_none')
                $('#for_host').addClass('display_none')
            })
            

            $('.ckbox b').click(function(e){
                e.preventDefault();
                $('#term_modal').modal({backdrop: false})
            })

            function ValidateEmail(input)
            {
                var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
                if(input.match(mailformat))
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
            function validate_all(){

            }
            function init_validate(){
                $('#firstname_error').removeClass('display_show')
                $('#lastname_error').removeClass('display_show')
                $('#email_require_error').removeClass('display_show')
                $('#email_invalid').removeClass('display_show')
                $('#password_error').removeClass('display_show')
                $('#password_match').removeClass('display_show')
                $('#city_error').removeClass('display_show')
                $('#name_id_error').removeClass('display_show')
                $('#photo_error').removeClass('display_show')
                $('#about_error').removeClass('display_show')
            }

            // console.log(document.getElementById('terms').checked)

            let mobile = $('#mobile_number').val();
            if (mobile != '') {
                $('#register_form').removeClass('display_none');
                $('#verify_form').addClass('display_none');

            }

            let city = document.getElementById('city')
            var autocomplete = new google.maps.places.Autocomplete(city, {componentRestrictions: {country: "sa"}});
            autocomplete.setFields(['address_components', 'geometry', 'icon', 'name']);
            autocomplete.addListener('place_changed', function() {
                var place = autocomplete.getPlace();
                if (!place.geometry) {
                    // User entered the name of a Place that was not suggested and
                    // pressed the Enter key, or the Place Details request failed.
                    window.alert("No details available for input: '" + place.name + "'");
                    return;
                }
                // console.log(place.geometry.location.lat())
                // console.log(place.geometry.location.lng()) 
                // city.value = place.name
            })
            google.maps.event.addDomListener(city, 'keydown', function(event) { 
                if (event.keyCode === 13) { 
                    event.preventDefault(); 
                }
            });
        })
    </script>
  </body>
</html>
