<?php
header("Content-Type: application/json");
require "database_login.php";
if($mysqli->connect_errno) {
    printf("Connection Failed: %s\n", $mysqli->connect_error);
    exit();
}
ini_set("session.cookie_httponly", 1);
session_start();
// var_dump($_POST);
// die();
$title = (string)$_GET['title'];
$description =  (string)$_GET['description'];
$picture =  (string)$_GET['picture'];
$stmt = $mysqli->prepare("insert into games (title, description, picture) values (?,?,?)");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}
$stmt->bind_param('sss', $title, $description, $picture);
if($stmt->execute()){
    $stmt->close();
    echo $_GET['callback'] . '(' .json_encode(array(
        'success' => TRUE)).')';
    exit();
}
else {
    $stmt->close();
    echo $_GET['callback'] . '(' .json_encode(array(
            'success' => FALSE)).')';
    exit();
	}


?>