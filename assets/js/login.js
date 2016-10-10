$(function() {
    // DOM ready

    // Test data
    /*
     * To test the script you should discomment the function
     * testLocalStorageData and refresh the page. The function
     * will load some test data and the loadProfile
     * will do the changes in the UI
     */
    // testLocalStorageData();
    // Load profile if it exits
    loadProfile();
    $('#signin').submit(onSubmit);
});

/**
 * Function that gets the data of the profile in case
 * thar it has already saved in localstorage. Only the
 * UI will be update in case that all data is available
 *
 * A not existing key in localstorage return null
 *
 */
function getLocalProfile(callback) {
    var profileImgSrc = localStorage.getItem('PROFILE_IMG_SRC');
    var profileName = localStorage.getItem('PROFILE_NAME');
    var profileReAuthIdNumber = localStorage.getItem('PROFILE_REAUTH_ID_NUMBER');

    if (profileName !== null &&
        profileReAuthIdNumber !== null &&
        profileImgSrc !== null) {
        callback(profileImgSrc, profileName, profileReAuthIdNumber);
    }
}

/**
 * Main function that load the profile if exists
 * in localstorage
 */
function loadProfile() {
    if (!supportsHTML5Storage()) { return false; }
    // we have to provide to the callback the basic
    // information to set the profile
    getLocalProfile(function(profileImgSrc, profileName, profileReAuthIdNumber) {
        //changes in the UI
        $('#profile-img').attr('src', profileImgSrc);
        $('#profile-name').html(profileName);
        $('#reauth-user-id').html(profileReAuthIdNumber);
        $('#input-user-id').hide();
        $('#remember').hide();
    });
}

/**
 * function that checks if the browser supports HTML5
 * local storage
 *
 * @returns {boolean}
 */
function supportsHTML5Storage() {
    try {
        return 'localStorage' in window && window['localStorage'] !== null;
    } catch (e) {
        return false;
    }
}

function onSubmit(event) {
    var userId = $('#input-user-id').val();
    $.post(
        location.href, {
            user_id: userId
        },
        function(data) {
            onRespond(data);
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
    event.preventDefault();
}

function onRespond(data) {
    switch (data) {
        case '0':
            location.reload(true);
            break;
        case '1':
            $('#error-msg').insertAfter('#input-user-id')
                .removeClass('hidden')
                .text('ID number incorrect!');
            break;
        case '2':
            $('#error-msg').insertAfter('#input-password')
                .removeClass('hidden')
                .text('Password incorrect!');
            break;
        case '3':
            $('#error-msg').insertAfter('#input-password')
                .removeClass('hidden')
                .text('Tried too many times!');
            break;
        case '-1':
            location.replace('/include/helloworld.html');
            break;
        default:
            Cookies.set('salt', data);
            break;
    }
}