$(function() {
    $('#vis > button').click(function() {
        var i = $(this).children('i');
        var input = $(this).parent().parent().children('input');
        if (i.hasClass('fa-eye')) {
            i.removeClass('fa-eye').addClass('fa-eye-slash');
            input.prop('type', 'text');
        } else {
            i.removeClass('fa-eye-slash').addClass('fa-eye');
            input.prop('type', 'password');
        }
    });
});