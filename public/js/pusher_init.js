$(document).ready(function(){
    var app_key = '';
    var user_id = '';
    app_key = $('#pusher_app_key').val();
    // Initiate the Pusher JS library
    var pusher = new Pusher(app_key, {
        encrypted: true,
        cluster: 'ap2',
        forceTLS: true
    });
    Pusher.logToConsole = true;

    // Subscribe to the channel we specified in our Laravel Event
    var channel = pusher.subscribe('channel-wajba');

    // Bind a function to a Event (the full Laravel class)
    channel.bind('App\\Events\\WajbaEvent', function(data) {
        let temp = `
            <a href="${data.link}" class="media-list-link read">
                <div class="media">
                    <div class="media-body">
                        <p class="noti-text">${data.message}</p>
                    </div>
                </div>
            </a>
        `
        let new_notify = `<span class="square-8 bg-danger pos-absolute t-15 r-5 rounded-circle"></span>`
        if ($('#notify_content' + data.user_id + ' .media-list-link.read').hasClass('empty_notify')) {
            $('#new_notify').append(new_notify)
            $('#notify_content' + data.user_id).empty()
            $('#notify_content' + data.user_id).prepend(temp)
        } else {
            $('#notify_content' + data.user_id).prepend(temp)
        }

        if ($('#notify_content' + data.user_id).hasClass('notify_content' + data.user_id)) {
            toast_call('Info', data.message, 'info')
        }
    });

    $('#mark_read').click(function(e){
        e.preventDefault();
        $.ajax({
            url: '/admin/mark_read',
            type: 'get',
            success: function(data){
                if(data == 'success'){
                    location.reload();
                }
            }
        })
    })
})