<?PHP

// receives username and password,
require 'database_login.php';
session_unset();
session_destroy();
session_start();

$stmt = $mysqli->prepare("SELECT COUNT(*), username, password FROM users WHERE username=?");

$stmt->bind_param('s', $user);
$user = (string) $_GET['username'];
$stmt->execute();

$stmt->bind_result($cnt, $user_id, $pwd_hash);
$stmt->fetch();

$pwd_guess = (string) $_GET['password'];



if($cnt == 1 && password_verify($pwd_guess, $pwd_hash)){

    $_SESSION['username'] = $user_id;
    echo $_GET['callback'] . '(' .json_encode(array(
        "success" => true,
        "username" => htmlentities($user_id)
    )).')';
} else{
    echo $_GET['callback'] . '(' .json_encode(array(
        "success" => false,
    )).')';
}


exit;
?>