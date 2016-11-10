$(function() {
    $('#signin').submit(function(e) {
        var userId = $('#input-user-id').val();
        $.post(
            location.href, {
                user_id: userId
            },
            function(d) {
                onRespond(d);
                var password = md5(md5(md5($('#input-password').val()) + md5(Cookies.get('salt'))), Cookies.get('key'));
                Cookies.remove('salt');
                $.post(
                    location.href, {
                        user_id: userId,
                        password: password
                    },
                    onRespond,
                    'text'
                );
            },
            'text'
        );
        e.preventDefault();
    });
});

function onRespond(d) {
    switch (d) {
        case '0':
            window.location.href = '/index.php';
            break;
        case '1':
            $('#error-msg').insertAfter('#input-user-id')
                .removeAttr('hidden')
                .text('ID number incorrect!');
            break;
        case '2':
            $('#error-msg').insertAfter('#input-password')
                .removeAttr('hidden')
                .text('Password incorrect!');
            break;
        case '3':
            $('#error-msg').insertAfter('#input-password')
                .removeAttr('hidden')
                .text('Tried too many times!');
            break;
        case '-1':
            $('#error-msg').insertAfter('#input-user-id')
                .removeAttr('hidden')
                .text('ID number is not of admin!');
            break;
        default:
            Cookies.set('salt', d);
            break;
    }
}