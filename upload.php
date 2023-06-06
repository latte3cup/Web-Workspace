<?php
session_start();
include_once('dbconn.php');
$conn->autocommit(false);   // 한 게시물에 3개 테이블을 사용하므로 트랜잭션 처리
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


/*이미지 파일 유효성 검사*/
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
		if(!$imageUpload == true){
			$conn->rollback();
            die('이미지 업로드 중에 오류가 발생하였습니다. error#1' . $conn->error);
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
/*이미지 파일 유효성 검사 end*/

$sql = "INSERT INTO post(title, recipe_name, posted_ID, posted_name, posted_date, likes, cg_type, cg_material, cg_method, serving, cook_time, image)
values ('$title', '$recipe_name','$id','$uname','$today', 0,$cg_type, $cg_material, $cg_method, $serving , $cook_time, '$newName')";

if (!$conn->query($sql)) {
    $conn->rollback();
    die('장바구니 데이터 삭제 중에 오류가 발생하였습니다.' . $conn->error);
} 
?>

<!------------------------------------------------------------------------------->
<?php
/*ingredient 테이블에 들어갈 정보*/
//각 필드에 대한 데이터를 배열형태로 저장할 배열 // 인덱스와 번호 1 차이 나는 것 주의
$main_array =array();
$sub_array = array();

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
$main_serialize = serialize($main_array);
$sub_serialize =  serialize($sub_array);

$sql_to_ing = "INSERT INTO INGREDIENT values($recipe_No,'$main_serialize','$sub_serialize')";

if (!$conn->query($sql_to_ing)) {
    $conn->rollback();
    die('장바구니 데이터 삭제 중에 오류가 발생하였습니다.' . $conn->error);
}

/*ingredient 테이블에 들어갈 정보 END */
?>

<!------------------------------------------------------------------------------->

<?php
//단계별 요리방법 정보 
$info_array = array();
$image_array = array();
for ($i=1; $i<11; $i++){
  /*설명문 처리*/
  if(isset($_POST['info' .$i])){
    $info_array[] = $_POST['info' .$i];
  }else{
    $info_array[] = null;
  }
  
  /*이미지 파일 처리*/
  if(isset($_FILES['step_img'.$i])){
    $fileTypeExt = explode("/", $_FILES['step_img'.$i]['type']);
    $img_temp = $_FILES['step_img'.$i]["tmp_name"];
    $fileType = $fileTypeExt[0]; //이미지인지 확인
    $fileExt = $fileTypeExt[1];  //이미지의 확장자 확인
    $superFolder = "./IMG/stepImages/" . $recipe_No ."/";
    
    /*폴더 생성 과정*/
    if (!is_dir($superFolder)) { // 폴더가 이미 존재하는지 확인
      if (!mkdir($superFolder, 0777, true)) { // 폴더 생성 //0777은 폴더 접근권한
          $conn->rollback();
          die('폴더 생성중에 오류가 발생하였습니다.' . $conn->error);
      } 
    } 
    /*폴더 생성 과정 END*/
    $newName = $i.".".$fileExt;
		$resFile = $superFolder ."". $newName;
		// 임시 저장된 파일을 우리가 저장할 디렉토리 및 파일명으로 옮김
		$imageUpload = move_uploaded_file($img_temp, $resFile);
		// 업로드 성공 여부 확인
		if(!($imageUpload)){
			$conn->rollback();
            die('이미지 업로드 중에 오류가 발생하였습니다. error#2' . $conn->error);
		}else{
          $image_array[] = $newName;
        }
  }else{
    //처리할 이미지가 없음
    $image_array[] = null;
  }
}
$info_serialize =  serialize($info_array);
$image_serialize = serialize($image_array);

$sql_to_steps = "insert into steps value($recipe_No, '$info_serialize', '$image_serialize')";
if(!($conn->query($sql_to_steps))){
  $conn->rollback();
  die('요리순서 정보 삽입에 오류가 발생하였습니다.' . $conn->error);
}


$conn->commit();
$conn->autocommit(true);
echo "<script>alert('게시물 등록이 완료되었습니다.');";
echo "location.href= 'index.php'; </script>";
?>