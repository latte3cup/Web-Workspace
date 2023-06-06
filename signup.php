<?php
include_once('dbconn.php');   

$id = $_POST['uid'];
$pwd = $_POST['pwd'];
$uname = $_POST['uname'];
$gender = $_POST['gender'];
$regdate = date('y/m/d');


$sql = "INSERT INTO MEMBER(id,pwd,name,gender,pdate) VALUES('$id','$pwd','$uname','$gender','$regdate')";

if($conn -> query($sql)){ 
  echo "<script> alert('회원가입 성공') </script>";
  echo "<script> location.replace('login.html') </script>";
}
else {
  echo "회원가입 실패";
  echo "<script> location.replace('login.html') </script>";
}

?>