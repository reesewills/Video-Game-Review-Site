/**
 * Created by davidflast on 4/23/17.
 */
function add_review(game_id, username, stars, review ) {
    $.ajax({
        url: "add_review.php",
        data: {
            game_id: game_id,
            username: username,
            stars: stars,
            review: review
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
            result.usernames;
            result.stars;
            result.reviews;

        },
        method: "POST",
        dataType: "json"
    });
}