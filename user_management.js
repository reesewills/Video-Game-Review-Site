/**
 * Created by davidflast on 4/23/17.
 */


function login(username, password) {
    $.ajax({
        url: "login.php",
        data: {
            username: username,
            password: password
        },
        success: function (result) {
           app.logged_in = result.success;

        },
        method: "POST",
        dataType: "json"
    });
}

function register(username, password) {
    $.ajax({
        url: "register.php",
        data: {
            username: username,
            password: password
        },
        success: function (result) {
            // attach to some value
            result.success;

        },
        method: "POST",
        dataType: "json"
    });
}

function logout() {
    $.ajax({
        url: "logout.php",
        data: {
        },
        success: function (result) {
            // attach to some value
            result.success;

        },
        method: "POST",
        dataType: "json"
    });
}