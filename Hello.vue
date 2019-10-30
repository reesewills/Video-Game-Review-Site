<template>

    <div class="hello">
        <div id="reviews_page" v-if="reviews_page">
            <input name = "review" id = "review" type = "text"/>
            <select id = "stars" name="stars">
                <option value = "1">1</option>
                <option value = "2">2</option>
                <option value = "3">3</option>
                <option value = "4">4</option>
                <option value = "5">5</option>
            </select>
            <button v-on:click="add_review">Add Review</button>
        </div>
        <div id="logged_in" v-if="logged_in">
            <h2>The Armchair Gamer</h2>
            <input id ="game_review" name = "game_title"/> <br>
            <button v-on:click="get_review">Get Review</button><br>
            <input id="title" name="title" type="text" placeholder="Game Title"/><br>
            <input id="description" name="description" type="text" placeholder="Description"/><br>
            <select id = "picture" name="picture">
                <option value = "M">M</option>
                <option value = "T">T</option>
                <option value = "E10">E10+</option>
                <option value = "E">E</option>
                <option value = "RP">RP</option>
            </select>
            <button v-on:click="add_game">Add Game</button>
            <div id="games">
                Games: <br>
            </div>
            <!--<ul>
                <li v-for="description in this.descriptions">{{description.valueOf()}}</li>
            </ul>-->
            <button id="load_games" v-on:click="get_games">Load Games</button>
            <button v-on:click="logout">Logout</button>
        </div>
        <div id="logged_out" v-else>
            <h1>The Armchair Gamer</h1>
            <br><br><br>Put username as "default" with no password to use default user<br>
            Login:
            <input id="username_login" type="text" placeholder="Username"/>
            <input id="password_login" type="password" placeholder="Password"/>
            <button v-on:click="login" id="login_button">Login</button>
            <br><br><br>
            Register:
            <input id="username_register" type="text" placeholder="Username"/>
            <input id="password_register" type="text" placeholder="Password"/>
            <button v-on:click="register" id="create_user_button">Register</button>
        </div>
    </div>
</template>


<script>
    export default {
        name: 'hello',
        data () {
            return {
                logged_in: false,
                reviews_page: false,
                msg: 'Welcome to Your Vue.js App',
                games: [],
                descriptions: [],
                pictures: [],
                game_ids: [],
                current_game_id: 0,
                reviews: [],
                stars: [],
                username_reviews: [],
            }
        },
        methods: {
            add_game: function () {
                //event.preventDefault();
                var title = $("#title").val();
                var description = document.getElementById('description').value;
                var picture = document.getElementById('picture').value;
                console.log(title);
                console.log(description);
                console.log(picture);
                $.ajax({
                    url: "http://ec2-54-89-131-3.compute-1.amazonaws.com:80/VideoGameReview/VideoGameWebsite/src/add_game.php",
                    data: {
                        title: title,
                        description: description,
                        picture: picture
                    },
                    jsonpCallback: "YAY",
                    method: "GET",
                    dataType: "jsonp"
                }).then(function (result) {
                    // attach to some value
                    console.log(result.title);
                });
            },
            login: function (event) {
                event.preventDefault();
                var username = $("#username_login").val();
                var password = $("#password_login").val();
                var self = this;
                $.ajax({
                    url: "http://ec2-54-89-131-3.compute-1.amazonaws.com:80/VideoGameReview/VideoGameWebsite/src/login.php",
                    data: {
                        username: username,
                        password: password,
                    },
                    jsonpCallback: "YAY",
                    method: "GET",
                    dataType: "jsonp"
                }).then(function (result) {
                    self.logged_in = result.success;
                    if (result.success) {
                        document.documentElement.style.backgroundImage = "url('https://s-media-cache-ak0.pinimg.com/originals/82/e2/a7/82e2a722d8896e2c570bbc4bc7e0268f.jpg')";
                    }
                });
            },
            logout: function () {
                this.logged_in = false;
                document.documentElement.style.backgroundImage = "url('/static/img/BOTW-Share_icon.0d79d57.jpg')";
            },
            register: function (event) {
                event.preventDefault();
                var username = $("#username_register").val();
                var password = $("#password_register").val();
                var self = this;
                $.ajax({
                    url: "http://ec2-54-89-131-3.compute-1.amazonaws.com:80/VideoGameReview/VideoGameWebsite/src/register.php",
                    data: {
                        username: username,
                        password: password,
                    },
                    jsonpCallback: "YAY",
                    method: "GET",
                    dataType: "jsonp"
                }).then(function (result) {
                    console.log(result.success);
                    self.logged_in = result.success;
                    if (result.success) {
                        document.documentElement.style.backgroundImage = "url('https://s-media-cache-ak0.pinimg.com/originals/82/e2/a7/82e2a722d8896e2c570bbc4bc7e0268f.jpg')";
                    }
                });
            },
            get_review: function () {
                var self = this;
                var game_title = $("#game_review").val();
                $.ajax({
                    url: "http://ec2-54-89-131-3.compute-1.amazonaws.com:80/VideoGameReview/VideoGameWebsite/src/get_reviews.php",
                    data: {
                        title: game_title,
                    },
                    success: function (result) {
                        console.log("biiitch");
                        self.reviews = result.reviews;
                        self.username_reviews = result.usernames;
                        self.stars = result.stars;
                        self.reviews_page = true;
                        self.current_game_id = result.game_id;

                    },
                    jsonpCallback: "YAY",
                    method: "GET",
                    dataType: "jsonp"
                })
            },
                add_review: function () {
                    var self = this;
                    $.ajax({
                        url: "http://ec2-54-89-131-3.compute-1.amazonaws.com:80/VideoGameReview/VideoGameWebsite/src/add_review.php",
                        data: {
                            game_id: self.current_game_id,
                            stars: document.getElementById('stars').value,
                            review: document.getElementById('review').value,
                        },
                        success: function (result) {

                        },
                        jsonpCallback: "YAY",
                        method: "GET",
                        dataType: "jsonp"
                    });
            },
            get_games: function () {
                var self = this;
                $.ajax({
                    url: "http://ec2-54-89-131-3.compute-1.amazonaws.com:80/VideoGameReview/VideoGameWebsite/src/get_games.php",
                    data: {},
                    success: function (result) {
                        // attach to some value
                        // returns an array of all these values
                        //result.game_ids;
                        self.games = result.title;
                        self.descriptions = result.descriptions;
                        document.getElementById("games").innerHTML = "Games: <br>";
                        for (var i = 0; i < result.descriptions.length; ++i) {
                            var temp_div = document.createElement("div");
                            //var temp_button = document.createElement("button");
                            //temp_button.onclick(self.get_review(result.game_ids[i]));
                            //temp_div.appendChild(temp_button);
                            temp_div.id = "div " + i;
                            var temp_title = document.createElement("h1");
                            temp_title.id = "title " + i;
                            temp_title.appendChild(document.createTextNode(result.titles[i] + " (" + result.pictures[i] + ") "));
                            temp_div.appendChild(temp_title);
                            var temp_p = document.createElement("p");
                            temp_p.id = "p " + i;
                            temp_p.appendChild(document.createTextNode(result.descriptions[i]));
                            temp_div.appendChild(temp_p);
                            for(var j = 0; j < result.review_game_ids.length; ++j){
                                if(result.review_game_ids[j] === result.game_ids[i]){
                                    var temp_review = document.createElement("p");
                                    temp_review.id = "review " + j + " " + i;
                                    temp_review.appendChild(document.createTextNode(result.reviews[j]));
                                    temp_review.appendChild(document.createTextNode(" (" + result.stars[j] + ") - " + result.usernames[j] ));
                                    temp_div.appendChild(temp_review);
                                }
                            }
                            document.getElementById("games").appendChild(temp_div);
                        }
                        this.pictures = result.pictures;
                    },
                    jsonpCallback: "YAY",
                    method: "GET",
                    dataType: "jsonp"
                });
            }
        }
    }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
    h1, h2 {
        font-weight: bold;
    }

    ul {
        list-style-type: none;
        padding: 0;
    }

    li {
        display: inline-block;
        margin: 0 10px;
    }

    a {
        color: #42b983;
    }
</style>
