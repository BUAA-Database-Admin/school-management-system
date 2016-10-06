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
    $("#signin").submit(function(event) {
        $.post(
            location.href, {
                stu_number: $("#input-student-number").val(),
                password: $("#input-password").val()
            },
            function(data) {
                switch (data) {
                    case "0":
                        location.reload(true);
                        break;
                    case "1":
                        $("#error-msg").insertAfter("#input-student-number")
                            .removeClass("hidden")
                            .text("Student number incorrect!");
                        break;
                    case "2":
                        $("#error-msg").insertAfter("#input-password")
                            .removeClass("hidden")
                            .text("Password incorrect!");
                        break;
                    case "3":
                        $("#error-msg").insertAfter("#input-password")
                            .removeClass("hidden")
                            .text("Tried too many times!");
                        break;
                    default:
                        location.replace("/include/helloworld.html");
                        break;
                }
            },
            "text"
        );
        event.preventDefault();
    });
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
    var profileImgSrc = localStorage.getItem("PROFILE_IMG_SRC");
    var profileName = localStorage.getItem("PROFILE_NAME");
    var profileReAuthStuNumber = localStorage.getItem("PROFILE_REAUTH_STU_NUMBER");

    if (profileName !== null &&
        profileReAuthStuNumber !== null &&
        profileImgSrc !== null) {
        callback(profileImgSrc, profileName, profileReAuthStuNumber);
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
    getLocalProfile(function(profileImgSrc, profileName, profileReAuthStuNumber) {
        //changes in the UI
        $("#profile-img").attr("src", profileImgSrc);
        $("#profile-name").html(profileName);
        $("#reauth-student-number").html(profileReAuthStuNumber);
        $("#input-student-number").hide();
        $("#remember").hide();
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
        return "localStorage" in window && window["localStorage"] !== null;
    } catch (e) {
        return false;
    }
}