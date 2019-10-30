<?php
require "database_login.php";
ini_set("session.cookie_httponly", 1);
session_start();

$title = $_GET['title'];

$stmt = $mysqli->prepare("SELECT game_id FROM games WHERE title=$title");

$stmt->execute();

$stmt->bind_result($game_id);
$stmt->fetch();


$stmt = $mysqli->prepare("SELECT username, stars, review FROM reviews WHERE game_id = $game_id");
if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }


$stmt->execute();

$result = $stmt->get_result();

$usernames = array();
$stars = array();
$reviews = array();

while($row = $result->fetch_assoc()) {
    array_push($usernames, $row["username"]);
    array_push($stars, $row["stars"]);
    array_push($reviews, $row["review"]);
}

$stmt->close();

echo $_GET['callback'] . '(' .json_encode(array(
        "usernames"=>$usernames,
        "reviews"=>$reviews,
        "stars" => $stars
    )).')';



?>