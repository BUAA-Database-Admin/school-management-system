var btnNames = ['default', 'primary', 'success', 'danger', 'warning', 'info'];
$(function() {
    $('div.nav-bar').children('a').each(function() {
        var rnd;
        do {
            rnd = btnNames[Math.floor(Math.random() * 6)];
        }
        while (rnd == $(this).prev().attr('data-rnd'));
        $(this).attr('data-rnd', rnd);
        $(this).addClass('btn-' + rnd);
    });
});