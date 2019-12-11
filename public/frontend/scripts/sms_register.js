$(document).ready(function(){
    let register_sid = '';
    let register_mobile = '';
    $('#register_verify').click(function(){
        init_validate()
        let _this = $(this)
        mobile = $('#register_phone_code').val() + $('#register_mobile_verify').val()
        if(!phonenumber(mobile)){
            $('#register_empty_mobile').removeClass('display_none')
            $('#register_mobile_verify').addClass('is-invalid')
            $('#register_mobile_verify').focus();
            return false
        }
        formdata = new FormData()
        formdata.append('mobile', mobile);
        $.ajax({
            url: '/api/phone_verify',
            type: 'post',
            data: formdata,
            contentType: false,
            processData: false,
            beforeSend: function () {$('.loader_container').removeClass('display_none'); },
            success: function(data){
                $('.loader_container').addClass('display_none');
                if(data.mobile == mobile) {
                    register_sid = data.service_sid
                    register_mobile = data.mobile
                    $('#register_verify_form').modal("hide")
                    $('#register_confirm_form').modal({backdrop: "static"});
                    $('#register_code_confirm').focus();
                    setTimeout(function() {
                        $('.resend').removeClass('display_none')
                    }, 10000);
                }else if(data.error_code == 429){
                    $('#register_many_mobile').removeClass('display_none')
                    $('#register_mobile_verify').addClass('is-invalid')
                }else if(data.error_code == 400){
                    $('#register_empty_mobile').removeClass('display_none')
                    $('#register_mobile_verify').addClass('is-invalid')
                }else {
                    $('#register_mobile_verify').addClass('is-invalid')
                    $('#register_unique_mobile').removeClass('display_none')
                }
            },
            error: function(data){
                $('.loader_container').addClass('display_none');
                console.log(data)
                
            }
        }).done(function () {
            $('.loader_container').addClass('display_none');
        })
    })

    $('.resend').click(function(){
        formdata = new FormData()
        formdata.append('mobile', mobile);
        $.ajax({
            url: '/api/phone_verify',
            type: 'post',
            data: formdata,
            contentType: false,
            processData: false,
            beforeSend: function () { $('.loader_container').removeClass('display_none'); },
            success: function(data){
                if(data.mobile == mobile){
                    sid = data.service_sid
                    mobile = data.mobile
                    $('#empty_alert').removeClass('display_none');
                }
            },
            error:function(xhr, status, error){
                var err = eval("(" + xhr.responseText + ")");
                console.log(err.errors)
                $('.loader_container').addClass('display_none');
            }
        }).done(function () {
            $('.loader_container').addClass('display_none');
        }) 
    })

    $('#register_confirm').click(function(){
        let _this = $(this);
        init_validate()
        let code = $('#register_code_confirm').val()
        if (code == '') {
            $('#register_code_confirm').addClass('is-invalid')
            $('#register_empty_code').removeClass('display_none')
            return false;
        }
        $.ajax({
            url: '/api/phone_confirm',
            type: 'post',
            data: {code: code, sid: register_sid, mobile: register_mobile},
            beforeSend: function () { $('.loader_container').removeClass('display_none'); },
            success: function(data){
                $('.loader_container').addClass('display_none');
                if (data.mobile == mobile) {
                    $('#register_confirm_form').modal('hide')
                    $('#register_form').modal({backdrop: "static"})
                    $('#mobile_number').val(data.mobile)
                }else if(error) {
                    $('#register_invaild_code').removeClass('display_none')
                    $('#register_confirm_code').addClass('is-invalid')
                }
            },
            error: function(data){
                $('.loader_container').addClass('display_none');
                $('#register_confirm_form').addClass('is-invalid')
                $('#register_server_mobile').removeClass('display_none')
            }
        }).done(function () {
            $('.loader_container').addClass('display_none');
        })
    })

    $('#final_to_signIn').click(function(){
        $('#register_form').modal('hide')
        $('#login_pass').modal({backdrop: 'static'})
    })
    $('#to_signIn').click(function(){
        $('#register_confirm_form').modal('hide')
        $('#login_pass').modal({backdrop: 'static'})
    })

    $('#signup_submit').click(function(){
        init_for_register()
        let first_name = $('#first_name').val()
        let last_name = $('#last_name').val()
        let register_email = $('#register_email').val()
        let mobile_number = $('#mobile_number').val()
        let register_password = $('#register_password').val()
        let register_confirmation_password = $('#register_confirmation_password').val()
        let city = $('#city').val()
        let register_gender = $('#register_gender').val()
        if(first_name == '' || last_name == '' || register_email == '' || register_password == '' || register_confirmation_password == '' || city == ''){
            $('#empty_alert').removeClass('display_none')
            return
        }
        if(!ValidateEmail(register_email)){
            $('#register_email_validation').removeClass('display_none')
            return
        }
        if(register_confirmation_password != register_password){
            $('#register_password_confirm').removeClass('display_none')
            return
        }
        init_for_register()
        $.ajax({
            url: '/register',
            type: 'post',
            data: {firstName: first_name, lastName: last_name, email: register_email, mobile: mobile_number,password_confirmation: register_confirmation_password, password: register_password, city: city, gender: register_gender,_token: $('input[name=_token]').val()},
            beforeSend: function () { $('.loader_container').removeClass('display_none'); },
            success: function(data){
                $('#bookingModal').modal({backdrop: 'static'})
                $('#register_form').modal('hide')
                $('.loader_container').addClass('display_none');
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
                    console.log(err.errors)
                }
                $('.loader_container').addClass('display_none');
            }
        }).done(function () {
            $('.loader_container').addClass('display_none');
        }) 
    })

    function init_for_register(){
        $('#empty_alert').addClass('display_none')
        $('#register_email_validation').addClass('display_none')
        $('#register_password_confirm').addClass('display_none')

    }

    function phonenumber(inputtxt)
    {
        var phoneno = /^\+[1-9]{1}[0-9]{3,14}$/;
        if(inputtxt.match(phoneno))
        {
            return true;      
        }
        else
        {
            return false;
        }
    }

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

    function init_validate() {
        // $('#mobile_input').removeClass('is-invalid')
        // $('#password').removeClass('is-invalid')
        $('#register_mobile_verify').removeClass('is-invalid')
        $('#register_not_mobile').addClass('display_none')
        $('#register_empty_mobile').addClass('display_none')
        $('#register_many_mobile').addClass('display_none')
        $('#register_code_confirm').removeClass('is-invalid')
        $('#register_empty_code').addClass('display_none')
        $('#register_invaild_code').addClass('display_none')
    }
})