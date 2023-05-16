<?php
//mysql 서버에 접속하기 
$server = 'localhost'; # '127.0.0.1'
$user = 'root';
$passwd = '';
$dbname = 'jooboo';

$conn = new mysqli($server,$user,$passwd,$dbname);
if($conn->connect_error) die ("데이터베이스 서버 접속 오류"); # 메세지 출력후 종료  
else echo "접속성공" ;

?>