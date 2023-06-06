<?php
session_start();
$id = $_SESSION['current_uid'];
include_once('dbconn.php'); 
$sql = "delete from member where id = '$id'";
if($conn->query($sql)) {
    session_destroy();
    echo "<script>alert('회원탈퇴가 성공하였습니다.');</script>";
    echo "<script>location.replace('index.php')</script>";
}
else {
    echo "<script>alert('회원탈퇴가 실패하였습니다.');</script>";
    echo "<script>location.replace('mypage.php')</script>";
}

$conn->close();   # DB disconnection 연결해제 
?>

