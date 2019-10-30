<?php
session_unset();
session_destroy();
require 'database_login.php';


$username = (string)$_GET['username'];
$password = (string) $_GET['password'];
$hash_password = password_hash($password, PASSWORD_DEFAULT);
//insert the new user into the database
$stmt = $mysqli->prepare("insert into users (username, password) values (?, ?)");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}

$stmt->bind_param('ss', $username, $hash_password);

if ($stmt->execute()){
    echo $_GET['callback'] . '(' .json_encode(array(
        "success" => true)).')';
} else {
    $stmt->close();
    echo $_GET['callback'] . '(' .json_encode(array(
        "success" => false,
        "message" => "Incorrect Username or Password"
    )).')';
}

exit;
?>