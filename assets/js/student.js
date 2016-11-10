$(function() {
    $('#select-courses tr').click(function() {
        toggleTr($(this));
    });
    $('#select-courses-form a[name="view-course-info"]').click(function() {
        toggleTr($(this).parents('tr'));
    });
    $('#select-courses-form').submit(function(e) {
        var c = [],
            d = {};
        $('#select-courses tr.table-active').each(function() {
            c.push(parseInt($(this).find('th').text()));
        })
        d['method'] = 'select-courses';
        d[d['method']] = c;
        $.post(
            location.href,
            d,
            function(d) {
                var a = $($('link[rel="import"]')[0].import).find('.alert').clone();
                switch (d) {
                    case '0':
                        a.addClass('alert-success')
                            .append('<strong>Success!</strong> You have successfully selected courses.');
                        break;
                    case '1':
                        a.addClass('alert-danger')
                            .append('<strong>Ooops!</strong> You failed to select courses. Please try agin.');
                        break;
                    default:
                        break;
                }
                $('#select-courses').prepend(a);
                $('#select-courses-form')[0].reset();
            },
            'text'
        );
        e.preventDefault();
    });
});

function toggleTr(e) {
    if (e.hasClass('table-active')) {
        e.removeClass('table-active');
    } else {
        e.addClass('table-active');
    }
}