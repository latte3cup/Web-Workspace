<?php

session_start();
$id = $_SESSION['current_uid'];
include_once('dbconn.php');
$sub_id = $_GET['id'];

try {
    $sql_upSubs = "INSERT INTO subusers (id, subscribedUser) VALUES ('$id', '$sub_id')";
	if ($conn->query($sql_upSubs)) { // 조회 결과 반환 (JSON 형식)
		$response = array('succ' => true);
		echo json_encode($response);
	}
} catch (mysqli_sql_exception $e) {
    $response = array('succ' => 'duplication');
	   echo json_encode($response);
}


?>