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
            url: '/api/phone_verify',
            type: 'post',
            data: formdata,
            contentType: false,
            processData: false,
            beforeSend: function () { $('.loader_container').removeClass('display_none'); },
            success: function(data){
                if(data.mobile == mobile) {
                    sid = data.service_sid
                    mobile = data.mobile
                    $('#verify_form').addClass('display_none')
                    $('#confirm_form').removeClass('display_none');
                    $('#code_confirm').focus();
                    setTimeout(function() {
                        $('#resend').removeClass('display_none')
                    }, 10000);
                } else if(data.error){
                    $('#mobile_verify').addClass('is-invalid')
                    $('#unique_mobile').removeClass('display_none')
                } else if(data.error_code == 429) {
                    $('#many_mobile').removeClass('display_none')
                    $('#mobile_verify').addClass('is-invalid')
                } else{
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

    $('#resend').click(function(){
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

    $('#confirm').click(function(){
        init_validate()
        let code = $('#code_confirm').val()
        if (code == '') {
            $('#code_confirm').addClass('is-invalid')
            $('#empty_code').removeClass('display_none')
            return false;
        }
        $.ajax({
            url: '/api/phone_confirm',
            type: 'post',
            data: {code: code, sid: sid, mobile: mobile},
            beforeSend: function () { $('.loader_container').removeClass('display_none'); },
            success: function(data){
                console.log(data)
                if (data.mobile == mobile) {
                    $('#confirm_form').addClass('display_none')
                    $('#register_form').removeClass('display_none')
                    $('#mobile_number').val(data.mobile)
                }else if(data.error == 'pending') {
                    $('#invaild_code').removeClass('display_none')
                    $('#confirm_code').addClass('is-invalid')
                }
            },
            error: function(){
                $('#invaild_code').removeClass('display_none')
                $('#confirm_code').addClass('is-invalid')
                $('.loader_container').addClass('display_none');
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
    $('#unique_mobile').addClass('display_none')
    $('#empty_mobile').addClass('display_none')
    $('#many_mobile').addClass('display_none')
    $('#code_confirm').removeClass('is-invalid')
    $('#empty_code').addClass('display_none')
    $('#invaild_code').addClass('display_none')
}