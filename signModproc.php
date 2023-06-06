<?php
session_start();
$id = $_SESSION['current_uid'];
$image = $_FILES['profile_IMG']["tmp_name"];
$fileTypeExt = explode("/", $_FILES['profile_IMG']['type']);
$fileType = $fileTypeExt[0]; //이미지인지 확인
$fileExt = $fileTypeExt[1];  //이미지의 확장자 확인



if($fileType == 'image'){
	$newName = "profile_img/". $id .".".$fileExt;
	$resFile = "./IMG/{$newName}";
	// 임시 저장된 파일을 우리가 저장할 디렉토리 및 파일명으로 옮김
	$imageUpload = move_uploaded_file($image, $resFile);

	if(!$imageUpload == true){// 업로드 성공 여부 확인
		die('이미지 업로드 중에 오류가 발생하였습니다. error#1' . $conn->error);
	}
}else {
    echo "<script>alert('이미지 파일이 아닙니다.')</script>";
	exit;
}

$new_password = $_POST['pwd'];
$new_password_confirm = $_POST['confirm_pwd'];

//비밀번호는 한번더 유효성 검사
if(!($new_password === $new_password_confirm)){
	echo "<script>alert('비밀번호 확인에 문제가 발생했습니다!!!')";
	echo "location.href='index.php';</script>";
	
}

$sql = "UPDATE MEMBER SET pwd='$new_password_confirm', profile_img='$newName' where id='$id'";

include_once('dbconn.php');
if ($conn->query($sql)) {
   echo "<script>alert('회원정보 수정 완료!');";
	echo "location.href='mypage.php';</script>";
}else{
	 die('회원정보 수정 중에 오류가 발생하였습니다.' . $conn->error);
}




?>
