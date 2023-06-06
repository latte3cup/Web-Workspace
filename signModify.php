<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<style>
	
		.container {
			padding-bottom: 50px;
		}

		input[name="uname"] {
			cursor: none;
			background-color: rgba(1, 1, 1, 0.2);
		}

		#pro_Photo {
			cursor: pointer;
			max-width:200px; 
			border:1px solid black;
			border-radius: 5px;
		}

		* {

/*
			border: 1px solid black;
*/
		}

	</style>
</head>

<body>
	<?php
        session_start(); 
        include_once('dbconn.php');
        $id = $_SESSION['current_uid'];  # 세션데이터에서 로그인한 회원의 아이디 읽음
        $sql = "select * from member where id = '$id'";
        $result = $conn->query($sql);
        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();
			if($row['gender']="1"){
				$gender="남";
			}else{
				$gender="여";
			}

        }
        ?>
	<h1 class="mt-2">회원 정보 수정</h1>
	<div class="container mt-5 bg-white">
		<form class="row" action="signModproc.php" method="post" enctype="multipart/form-data">
			<div></div>
			<div class="col-6 ">
				<div class="row mb-2 mt-3">
					<div class="col-6">
						<label for="lname">이름</label>
					</div>
					<div class="col-6">
						<input type="text" name="uname" value="<?= $row['name'] ?>" readonly>
					</div>
				</div>
				<div class="row mb-2">
					<div class="col-6">
						<label for="pwd">비밀번호</label>
					</div>
					<div class="col-6">
						<input type="password" name="pwd" value="">
					</div>
				</div>
				<div class="row mb-2">
					<div class="col-6">
						<label for="pwd">비밀번호 확인</label>
					</div>
					<div class="col-6">
						<input type="password" name="confirm_pwd" value=""  onblur="checkPWD()">
					</div>
				</div>
				<p class="alert alert-danger" id="checkPWD" style="display:none"></p>
				<div class="row mb-2">
					<div class="col-6">
						<label for="gender">성별</label>
					</div>
					<div class="col-6">
						<input type="text" name="gender" value="<?= $gender ?>" readonly>
					</div>
				</div>
				
				<div></div>
				<div></div>
				<div></div>

			</div>
			<div class="col-6 ">
				<div class="text-center">
					<img class="img" id="pro_Photo" src="IMG/<?= $row['profile_img'] ?>">
					<input type="file" class="upload-btn" accept="image/* " required style="display: none;" name="profile_IMG">
				</div>
				<div class="text-center mt-3"> * 클릭 시 프로필 이미지 변경 가능</div>
			</div>

			<div class="d-flex flex-row-reverse mt-5">
				<input type="reset" value="취소">
				<input  type="submit" value="변경">
			</div>
		</form>
	</div>




</body>

</html>
