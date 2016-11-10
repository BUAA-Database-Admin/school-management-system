$(function() {
    $('form').submit(function(e) {
        var d = {};
        $(this).find('input, select').each(function() {
            d[$(this).prop('id').split('-')[1]] = $(this).val();
        });
        var l = $(this).prop('id').split('-');
        d['method'] = l.slice(0, 2).join('-');
        if (d['password']) {
            d['password'] = md5(d['password']);
        } else {
            delete d['password'];
        }
        $.post(
            location.href,
            d,
            function(d) {
                var r = $('div.active.in').prop('id').split('-')[1];
                var a = $($('link[rel="import"]')[0].import).find('.alert').clone();
                switch (d) {
                    case '0':
                        a.addClass('alert-success')
                            .append('<strong>Success!</strong> You have successfully added a ' + r + '.');
                        break;
                    case '1':
                        a.addClass('alert-danger')
                            .append('<strong>Ooops!</strong> You failed to add a ' + r + '. Please try agin.');
                        break;
                    default:
                        break;
                }
                $('div.active.in').prepend(a);
                $('div.fade.in form')[0].reset();
            },
            'text'
        );
        e.preventDefault();
    });
});