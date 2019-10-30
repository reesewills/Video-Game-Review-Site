/**
 * Created by davidflast on 4/23/17.
 */


function add_game(title, description, picture) {
    $.ajax({
        url: "add_game.php",
        data: {
            title: title,
            description: description,
            picture: picture
        },
        success: function (result) {
            // attach to some value
            result.success;

        },
        method: "POST",
        dataType: "json"
    });
}

function get_games() {
    $.ajax({
        url: "get_games.php",
        data: {
        },
        success: function (result) {
            // attach to some value
            // returns an array of all these values
            result.game_ids;
            result.titles;
            result.descriptions;
            result.pictures;

        },
        method: "GET",
        dataType: "jsonp"
    });
}