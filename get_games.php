<?php
/**
 * Created by PhpStorm.
 * User: davidflast
 * Date: 4/15/17
 * Time: 2:10 PM
 */


$stmt = $mysqli->prepare("SELECT game_id, title, description, picture FROM games ORDER BY title");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}

$stmt->execute();

$result = $stmt->get_result();

$game_ids = array();
$titles = array();
$descriptions = array();
$pictures = array();

while($row = $result->fetch_assoc()) {
    array_push($game_ids, $row["game_id"]);
    array_push($titles, $row["title"]);
    array_push($descriptions, $row["description"]);
    array_push($pictures, $row["picture"]);
}
$stmt->close();

echo $_GET['callback'] . '(' .json_encode(array(
    "game_ids"=>$game_ids,
    "titles"=>$titles,
    "descriptions" => $descriptions,
    "pictures"=>$pictures
)).')';
?>