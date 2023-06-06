<?php
session_start();
$id = $_SESSION['current_uid'];
$pwd_input = $_POST['pwd'];
include_once('dbconn.php');
$sql = "select pwd from member where id = '$id'";
$result = $conn->query($sql);
if ($result->num_rows > 0){// 검색된 레코드가 있으면 
    $pwd = ($result->fetch_assoc())['pwd'];
}


if($pwd_input === $pwd){
	echo "<script>
		if (confirm('정말 회원탈퇴하시겠습니까?')) {
			location.href = 'withdrawal.php';
		}else{
			history.go(-1);
		}
		  </script>";
}else{
	echo "<script>alert('잘못된 비밀 번호 입니다.');";
	echo "history.go(-1);</script>";
}


?>