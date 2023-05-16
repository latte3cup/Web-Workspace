<?php
session_start();
  echo '<script>
    var result = window.confirm("로그아웃 하시겠습니까?");
    if (result) {
      alert("로그아웃 하였습니다.");
      
    } else {
      // Handle the cancellation or do nothing
      alert("You clicked Cancel");
    }
  </script>';
echo "<script> alert('로그아웃 하였습니다.')";
session_destroy(); #세션 데이터 모두 삭제
echo "<script> location.replace('index.php') </script>";

#header("location: index.php");
?>