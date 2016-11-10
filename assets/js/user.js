$(function() {
    $('#person-info-form').submit(function(e) {
        var d = {};
        $(this).find('input, select').each(function() {
            d[$(this).prop('id').split('-')[2]] = $(this).val();
        });
        d['method'] = 'modify-personal-info';
        if (d['password']) {
            d['password'] = md5(d['password']);
        } else {
            delete d['password'];
        }
        $.post(
            location.href,
            d,
            function(d) {
                var a = $($('link[rel="import"]')[0].import).find('.alert').clone();
                switch (d) {
                    case '0':
                        a.addClass('alert-success')
                            .append('<strong>Success!</strong> You have successfully modified personal information.');
                        break;
                    case '1':
                        a.addClass('alert-danger')
                            .append('<strong>Ooops!</strong> You failed to modify personal information. Please try agin.');
                        break;
                    default:
                        break;
                }
                $('#person-info').prepend(a);
                $('#person-info-form')[0].reset();
            },
            'text'
        );
        e.preventDefault();
    });
    $('a[name="view-course-info"]').click(function(e) {
        var d = {};
        d['method'] = 'view-course-info';
        d[d['method']] = $(this).parent().siblings('th').text();
        $.post(
            location.href,
            d,
            function(d) {
                if (!d) {
                    $('#course-info').modal('hide');
                    e.preventDefault();
                } else {
                    $('#course-info th[name="id"]').text(d.id);
                    $('#course-info td[name="name"]').text(d.name);
                    $('#course-info td[name="teacher"]').text(d.teacher);
                    $('#course-info td[name="credit"]').text(d.credit);
                }
            },
            'json'
        );
    });
});