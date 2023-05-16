<?php
session_start();
include_once('dbconn.php');
$id = $_POST['id'];
$pwd = $_POST['pwd'];

$SQL="select * from member where id='$id' and pwd='$pwd'";
$set = $conn -> query($SQL);

if($set->num_rows > 0 ){

  $row = $set->fetch_assoc(); # 검색결과 레코드 하나를 연관배열 형태로 반환 
  #echo "로그인 성공";
  #세션 데이터 생성  = 연관배열 형태 
  $_SESSION['current_uid'] = $id;
  $_SESSION['current_uname'] = $row['name'];
  
  echo "<script> alert('".$_SESSION['current_uname']."님 환영합니다.') </script>";
  echo "<script> location.replace('index.php') </script>";
}
else {
  echo "<script> alert(' 로그인 실패 하였습니다. ') </script>";
  echo "<script> location.replace('login.html') </script>";
}




?>