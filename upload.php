<?php
session_start();

include_once('dbconn.php');
$sql = "select max(recipe_no) as recipe_No from post";
 $result= $conn->query($sql);
if($result->num_rows>0){
  $row = $result->fetch_assoc();
  $recipe_No = intval($row['recipe_No']);
}


// post 테이블에 들어갈 정보 
$id= $_SESSION['current_uid'];
$uname = $_SESSION['current_uname'];


$title = $_POST['title'];
$recipe_name = $_POST['recipe_name'];
$today = date("Y/m/d");
$cg_type = $_POST['cg_type'] +0;
$cg_material = $_POST['cg_material'] + 0;
$cg_method = $_POST['cg_method'] + 0;
$serving =  $_POST['serving'] + 0;
$cook_time = $_POST['cook_time'] + 0;
$thumb_temp = $_FILES['thumbIMG']["tmp_name"];
$fileTypeExt = explode("/", $_FILES['thumbIMG']['type']);
$fileType = $fileTypeExt[0]; //이미지인지 확인
$fileExt = $fileTypeExt[1];  //이미지의 확장자 확인
$extStatus = false; //확장자 검사용 참/거짓

switch($fileExt){// 허용할 확장자를 jpg, bmp, gif, png로 정함, 그 외에는 업로드 불가
	case 'jpeg':
	case 'jpg':
	case 'gif':
	case 'bmp':
	case 'png':
		$extStatus = true;
		break;
	default:
		echo "이미지 전용 확장자(jpg, bmp, gif, png)외에는 사용이 불가합니다."; 
		exit;
		break;
}

if($fileType == 'image'){
	if($extStatus){
		// 임시 파일 옮길 디렉토리 및 파일명
        $newName = "thumbnail/". ++$recipe_No .".".$fileExt;
		$resFile = "./IMG/{$newName}";
		// 임시 저장된 파일을 우리가 저장할 디렉토리 및 파일명으로 옮김
		$imageUpload = move_uploaded_file($thumb_temp, $resFile);
		
		// 업로드 성공 여부 확인
		if($imageUpload == true){
			echo "파일이 정상적으로 업로드 되었습니다. <br>";
		}else{
			echo "파일 업로드에 실패하였습니다.";
		}
	}
	else {
		echo "<script>alert('파일 확장자는 jpg, bmp, gif, png 이어야 합니다.')</script>";
		exit;
	}	
}	
else {
    echo "<script>alert('이미지 파일이 아닙니다.')</script>";
	exit;
}

/*$sql = "INSERT INTO post(title, recipe_name, posted_ID, posted_name, posted_date, likes, cg_type, cg_material, cg_method, serving, cook_time, image)
values ('$title', '$recipe_name','$id','$uname','$today', 0,$cg_type, $cg_material, $cg_method, $serving , $cook_time, '$newName')";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('게시물 등록이 완료되었습니다.')</script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}*/


/*Material 테이블에 들어갈 정보*/

//각 필드에 대한 데이터를 배열형태로 저장할 배열 // 인덱스와 번호 1 차이 나는 것 주의
$main_array =array_fill(0, 10, null);
$sub_array = array_fill(0, 10, null);

//주재료
for ($i=1; $i<11; $i++){
  if(!isset($_POST['main'.$i])){
    ${"main$i"} = null;
  }else{
    ${"main$i"} = $_POST['main'.$i];
  }
  
  if(!isset($_POST['main_amount'.$i])){
    ${"main_amount$i"} = null;
  }else{
    ${"main_amount$i"} = $_POST['main_amount'.$i];
  }
  $main_array[]= array(${"main$i"},${"main_amount$i"});
}
//부재료 변수
for ($i=1; $i<11; $i++){
  if(!isset($_POST['sub'.$i])){
    ${"sub$i"} = null;
  }else{
    ${"sub$i"} = $_POST['sub'.$i];
  }
  if(!isset($_POST['sub_amount'.$i])){
    ${"sub_amount$i"} = null;
  }else{
    ${"sub_amount$i"} = $_POST['sub_amount'.$i];
  }
  $sub_array[]= array(${"sub$i"},${"sub_amount$i"});
}












?>