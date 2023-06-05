<?php
session_start();
$id = $_SESSION['current_uid'];
include_once('dbconn.php');
$recipe_No = intval($_GET['no']);

try {
    $sql_upfav = "INSERT INTO likes (id, likedPosts) VALUES ('$id', $recipe_No)";
	if ($conn->query($sql_upfav)) { // 조회 결과 반환 (JSON 형식)
		$response = array('succ' => true);
		$sql_uplikes = "UPDATE post SET likes = likes + 1 WHERE recipe_No=$recipe_No";
		$conn->query($sql_uplikes);
		echo json_encode($response);
	}else{
	   $response = array('succ' => false);
	   echo json_encode($response);
	}
} catch (mysqli_sql_exception $e) {
    $response = array('succ' => 'duplication');
	   echo json_encode($response);
}



?>
