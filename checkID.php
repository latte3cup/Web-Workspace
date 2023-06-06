<?php
include_once('dbconn.php');
$uid = $_GET['uid'];

$sql = "SELECT COUNT(*) AS count FROM member WHERE id = '$uid'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $count = $row['count'];

    // 조회 결과 반환 (JSON 형식)
    if ($count > 0) {
        $response = array('succ' => true);
    } else {
        $response = array('succ' => false);
    }

    echo json_encode($response);
}

?>