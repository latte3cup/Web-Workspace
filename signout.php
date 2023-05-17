<?php
session_start();
session_destroy(); #세션 데이터 모두 삭제
echo "<script>alert('로그아웃 완료') </script>";
echo "<script> location.replace('index.php') </script>";
?>