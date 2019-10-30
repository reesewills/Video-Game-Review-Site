<?php
require "database_login.php";
ini_set("session.cookie_httponly", 1);
session_start();

$username = (string)$_SESSION['username'];
$game_id = $_GET['game_id'];
$stars =  $_GET['stars'];
$review =  (string)$_GET['review'];
$url_pattern = '^((http[s]?|ftp):\/)?\/?([^:\/\s]+)((\/\w+)*\/)([\w\-\.]+[^#?\s]+)(.*)?(#[\w\-]+)?$';

$stmt = $mysqli->prepare("SELECT username FROM users");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}

$stmt->execute();
$result = $stmt->get_result();
$usernames = array();
while($row = $result->fetch_assoc()) {
    array_push($usernames, $row["username"]);
}


//regexs to check for links and usernames

preg_replace($url_pattern, "links not allowed", $review );
preg_replace($usernames, "do not reference other users", $review );

$

$stmt = $mysqli->prepare("insert into reviews (game_id, username, stars, review) values (?, ?,?,?)");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}

$stmt->bind_param('ssss', $game_id, $username, $stars, $review);

if($stmt->execute()){
    $stmt->close();
    echo $_GET['callback'] . '(' .json_encode(array(
            'success' => TRUE)).')';
}else {
    $stmt->close();
    echo $_GET['callback'] . '(' . json_encode(array(
            'success' => FALSE)) . ')';
}
exit;



?>