$(function() {
    $('#modify-grade a.dropdown-item').click(function() {
        $('#dropdown-courses').text($(this).text());
        $('#modify-grade a.dropdown-item').each(function() {
            $(this).removeClass('active');
        })
    });
    $('form[name="modify-grade-form"]').submit(function(e) {
        var s = [],
            d = {},
            c = $(this).parent().prop('id').split('-')[1];
        $(this).find('tbody tr').each(function() {
            s.push({
                'course_id': c,
                'user_id': parseInt($(this).find('th').text()),
                'grade': parseInt($(this).find('input').val())
            });
        });
        d['method'] = 'modify-grades';
        d[d['method']] = s;
        $.post(
            location.href,
            d,
            function(d) {
                var a = $($('link[rel="import"]')[0].import).find('.alert').clone();
                var f = $('div.fade.in[name^="course-"] > form');
                switch (d) {
                    case '0':
                        a.addClass('alert-success')
                            .append('<strong>Success!</strong> You have successfully modified grades.');
                        break;
                    case '1':
                        a.addClass('alert-danger')
                            .append('<strong>Ooops!</strong> You failed to modify grades. Please try agin.');
                        break;
                    default:
                        break;
                }
                f.parent().$('#select-courses').prepend(a);
                f[0].reset();
            },
            'text'
        );
        e.preventDefault();
    });
});