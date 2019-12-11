$(document).ready(function(){
    // let height = window.innerHeight;
    let sid = ''
    let mobile = ''
    // $('.loader_container .sk-three-bounce').css('margin-top', height/2) 
    
    $('#verify').click(function(){
        init_validate()
        mobile = $('#phone_code').val() + $('#mobile_verify').val()
        if(!phonenumber(mobile)){
            $('#empty_mobile').removeClass('display_none')
            $('#mobile_verify').addClass('is-invalid')
            $('#mobile_verify').focus();
            return false
        }
        formdata = new FormData()
        formdata.append('mobile', mobile);
        $.ajax({
            url: '/api/phone_verify_login',
            type: 'post',
            data: formdata,
            contentType: false,
            processData: false,
            beforeSend: function () { $('.loader_container').removeClass('display_none'); },
            success: function(data){
                $('.loader_container').addClass('display_none');
                if(data.mobile == mobile) {
                    sid = data.service_sid
                    mobile = data.mobile
                    $('#verify_form').modal("hide")
                    $('#confirm_form').modal({backdrop: "static"});
                    $('#code_confirm').focus();
                    setTimeout(function() {
                        $('.resend').removeClass('display_none')
                    }, 10000);
                }else if(data.error_code == 429){
                    $('#many_mobile').removeClass('display_none')
                    $('#mobile_verify').addClass('is-invalid')
                }else if(data.error_code == 400){
                    $('#empty_mobile').removeClass('display_none')
                    $('#mobile_verify').addClass('is-invalid')
                }else {
                    $('#not_mobile').removeClass('display_none')
                    $('#mobile_verify').addClass('is-invalid')
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
            url: '/api/phone_verify_login',
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

    $('#confirm').click(function(){
        init_validate()
        let code = $('#code_confirm').val()
        if (code == '') {
            $('#code_confirm').addClass('is-invalid')
            $('#empty_code').removeClass('display_none')
            return false;
        }
        $.ajax({
            url: '/phone_confirm_login',
            type: 'get',
            data: {code: code, sid: sid, mobile: mobile},
            beforeSend: function () { $('.loader_container').removeClass('display_none'); },
            success: function(data){
                $('.loader_container').addClass('display_none');
                if (data.success == 'success') {
                    $('#bookingModal').modal({backdrop: "static"});
                    $('#confirm_form').modal('hide');
                }else {
                    $('#invaild_code').removeClass('display_none')
                    $('#confirm_code').addClass('is-invalid')
                }
            },
            error: function(xhr, status, error){
                $('.loader_container').addClass('display_none');
                var err = eval("(" + xhr.responseText + ")");
                console.log(err.errors)
            }
        }).done(function () {
            $('.loader_container').addClass('display_none');
        })
    })
})

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
function init_validate() {
    $('#mobile_input').removeClass('is-invalid')
    $('#password').removeClass('is-invalid')
    $('#mobile_verify').removeClass('is-invalid')
    $('#not_mobile').addClass('display_none')
    $('#empty_mobile').addClass('display_none')
    $('#many_mobile').addClass('display_none')
    $('#code_confirm').removeClass('is-invalid')
    $('#empty_code').addClass('display_none')
    $('#invaild_code').addClass('display_none')
}