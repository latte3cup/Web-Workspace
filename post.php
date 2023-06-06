<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Nanum+Gothic&display=swap" rel="stylesheet">
	<!--부트스트랩 cdn 정의-->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
	<!--부트스트랩 아이콘 CDN-->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<!-- Jquery CDN 정의-->
	<script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
	<!--기본 프레임 css-->
	<link rel="stylesheet" href="css/base.css">

	<title>main_bootstrap</title>
	<style>
		* {
/*
			border: 1px solid black;
*/
		}

		#thumb_img {
			max-width: 350px;
		}

		.data {
			font-size: 0.9em;
		}

	</style>
</head>

<body>
	<?php
    session_start();
    $login= false;
    if(isset($_SESSION['current_uid'])){
        $uname = $_SESSION['current_uname'];
        $login = true;
    }
    ?>
	<header>
		<div class="container-fluid mt-2 mb-2 d-flex" style="max-width: 800px;">
			<div class="input-group">
				<a href="index.php">
					<img src="IMG/LOGO.png" class="img-fluid">
				</a>
				<input type="text" id="searchInput" class="form-control h-50 align-self-center shadow" placeholder="검색할 레시피를 입력하세요." maxlength=15 onkeypress="searchEnter(event)">
				<div class="input-group-append align-self-center shadow">
					<button class="btn btn-outline-secondary" type="submit" onclick="searchRecipe()">검색</button>
				</div>
			</div>
			<ul class="list-unstyled d-flex align-items-end" style="padding-left: 10px;">
				<div class="circle-icon">
					<?php if($login){ ?>
					<a href="mypage.php"><span class="bi bi-person-fill fs-2"></span></a>
					<?php }else { ?>
					<a href="login.html"><span class="bi bi-person-fill fs-2"></span></a>
					<?php } ?>
				</div>
				<div class="circle-icon">
					<?php if($login){ ?>
					<a href="insert.php"><span class="bi bi-pencil fs-4"></span></a>
					<?php }else { ?>
					<a href="login.html"><span class="bi bi-pencil fs-4"></span></a>
					<?php } ?>
				</div>
			</ul>
		</div>
	</header>
	<nav>
		<ul class="container list-unstyled d-flex justify-content-around mb-0 pt-2 pb-2 ">
			<li class="nav-item selected"><a href="index.php" class="nav-link">HOME</a></li>
			<li class="nav-item"><a href="recipe.php?sort=date&t=0&m=10&h=20" class="nav-link">레시피</a></li>
			<li class="nav-item"><a href="ranking.php?date=weekly" class="nav-link">랭킹</a></li>
			<li class="nav-item"><a href="community.php" class="nav-link">커뮤니티</a></li>
		</ul>
	</nav>

	<?php
	//검색 처리
	include_once('dbconn.php');
	$recipe_No = intval($_GET['no']);
	$sql = "select * from post where recipe_NO=$recipe_No";
	$result= $conn->query($sql);
	if($result->num_rows>0){
		$row = $result->fetch_assoc();
		$title = $row['title'];
		$recipe_name = $row['recipe_name'];
		$posted_ID = $row['posted_ID'];
		$posted_name = $row['posted_name'];
		$posted_date = $row['posted_date'];
		$likes = $row['likes'];
		$cg_type = $row['cg_type'];
		$cg_material = $row['cg_material'];
		$cg_method = $row['cg_method'];
		$serving = $row['serving'];
		$cook_time = $row['cook_time'];
		$thumb_img = $row['image'];
	}
	?>
	<?php
	$sql_user = "select profile_img from member where id='$posted_ID'";
	$result2 = $conn->query($sql_user);
	if($result2-> num_rows>0){
		$profile_img = ($result2->fetch_assoc())['profile_img'];
	}
	?>

	<section class="container mt-2 bg-gray mb-5">
		<div class="text-center bg-white container p-0" style="max-width: 1000px;">
			<div class=" text-center container ">
				<div style="position:relative;" id=img_part class="">
					<img src="IMG/<?= $thumb_img ?>" class="mt-3 mb-3" id="thumb_img">
					<div style="position:absolute; bottom: -30px;" id="pro_img">
						<img src="IMG/<?= $profile_img?>" style="width:80px; border-radius:40px; border : 1px solid gray; border-width: 3px;">
					</div>
				</div>
				<div class="mt-4"><?=$posted_name?></div>
				<h3 class="mt-3 mb-5"><?= $title ?></h3>
				<div class="container row mb-2">
					<div class="col-3"></div>
					<div class="col-2">
						<p class="data mb-0" id="cg_type"></p>
					</div>
					<div class="col-2">
						<p class="data mb-0" id="cg_material"></p>
					</div>
					<div class="col-2">
						<p class="data mb-0" id="cg_method"></p>
					</div>
					<div class="col-3"></div>
				</div>
				<div class="container row">
					<div class="col-3"></div>
					<div class="col-3 d-flex flex-column" style="transform: scaleX(-1);">
						<i class="bi bi-people-fill" style="font-size:50px;"></i>
						<p class="data mb-0" style="transform: scaleX(-1);" id="serving">></p>
					</div>
					<div class="col-3 d-flex flex-column">
						<i class="bi bi-stopwatch" style="font-size:50px;"></i>
						<p class="data mb-0" id="cook_time"></p>
					</div>
					<div class="col-3"></div>
				</div>
				<hr>
				<div class="container d-flex justify-content-between">
					<p class="mt-auto"><?= $posted_date?></p>
					<a onclick="updateLike()" class="d-flex" style="font-size:30px; text-decoration: none;">
						<i class="bi bi-heart-fill " style="color:pink;"></i>
						<p style="color:black; min-width:20px; padding-left:10px;"><?= $likes?></p>
					</a>
				</div>

			</div>

		</div>

		<?php
		$sql_ingredient = "select main_ing, sub_ing from ingredient where recipe_No = $recipe_No";
		$result4 = $conn->query($sql_ingredient);
		if($result4-> num_rows>0){
			$row = $result4->fetch_assoc();
			$main_ing_array = unserialize($row['main_ing']);
			$sub_ing_array = unserialize($row['sub_ing']);
		} //재료 배열의 원소는 [재료, 양]인 또하나의 배열
		?>


		<div class="text-center bg-white container p-0" style="max-width: 1000px;">
			<div class=" text-center container ">
				<div class="container row mt-2">
					<p class="col-2 fw-bold" style="font-size:1.4em;">
						재료
					</p>
					<hr>
				</div>
				<div class="container row d-flex">
					<div class="col-6">
						<p style="font-size:1.1em;">메인재료</p>
						<hr>
						<div class="px-5">
							<?php
							$num=0;
							while($main_ing_array[$num]!=array(null,null)){
							?>
							<div class="d-flex justify-content-between  mb-2">
								<p class="data mb-0"><?=$main_ing_array[$num][0]?></p>
								<p class="data mb-0"><?=$main_ing_array[$num][1]?></p>
							</div>
							<?php
							$num++;
							}
							?>
						</div>
					</div>


					<div class="col-6">
						<p style="font-size:1.1em;">부재료</p>
						<hr>
						<div class="px-5">
							<?php
							$num=0;
							while($sub_ing_array[$num]!=array(null,null)){
							?>
							<div class="d-flex justify-content-between  mb-2">
								<p class="data mb-0"><?=$sub_ing_array[$num][0]?></p>
								<p class="data mb-0"><?=$sub_ing_array[$num][1]?></p>
							</div>
							<?php
							$num++;
							}
							?>
						</div>
					</div>
				</div>

			</div>
		</div>


		<?php
		$sql_steps = "select info,step_images from steps where recipe_No=$recipe_No";
		$result3 = $conn->query($sql_steps);
		if($result3-> num_rows>0){
			$row = $result3->fetch_assoc();
			$info_array = unserialize($row['info']);
			$image_array = unserialize($row['step_images']);
		}
	


	
		?>
		<div class="text-center bg-white container p-0 mt-3" style="max-width: 1000px;">
			<div class=" text-center container pt-2 ">

				<div class="container row mt-2">
					<p class="col-2 fw-bold" style="font-size:1.4em;">
						요리 순서
					</p>
					<hr>
				</div>
				<?php
				$num=0;
				while($info_array[$num]!=null){
				?>
				<div class="row mb-4" style="border:1px solid rgba(0, 0, 0, 0.2); border-radius:10px;">
					<p class="col-1" style="font-size:1.3em;">Step<?= $num+1?></p>
					<div class="col-6">
						<p class="pt-0 mt-1" style="font-size:1.1em; font-weight: 700;"><?=$info_array[$num]?></p>
					</div>
					<div class="col-5">
						<img src="IMG/stepImages/<?=$recipe_No . "/" . $image_array[$num] ?>" class="img-fluid" style="max-height:200px;">
					</div>
				</div>
				<?php
					$num++;
				}
				?>
			</div>

		</div>

		<div class="text-center bg-white container p-0 mt-3" style="max-width: 1000px;">

		</div>
	</section>
	<footer>
		<pre>(주)주부들의 쉼터 : 경기도 포천시 호국로 1007
      제작자 : 오준걸 | t. ##-###-#### | F. 010-####-###
      Fax. ##-###-#### | 사업자 번호 : ###-###-### <address>20181165@daejin.ac.kr</address>
      </pre>
	</footer>

	<!--프로필 이미지 CSS 적용-->
	<script>
		function imgCenter() {
			let superWidth = document.getElementById('img_part').offsetWidth;
			let pro_img = document.getElementById('pro_img');
			pro_img.style.left = (superWidth / 2) + 'px';
			pro_img.style.transform = "translateX(-50%) translateY(-10%)";
		};
		imgCenter();
		window.addEventListener('resize', imgCenter);

	</script>
	<script> /*좋아요 버튼 클릭시 추천수가 오르면서 즐겨찾기에 추가*/
		function updateLike() {
			if(! <?= $login ?>){
				alert('*좋아요* 하려면 로그인이 필요합니다.');
				return;
			}
			let recipe_No = <?= $recipe_No ?>;
			const xhs = new XMLHttpRequest();
			xhs.onreadystatechange = function() {
			  if (xhs.readyState === xhs.DONE) {
				if (xhs.status === 200) {
				  const result = JSON.parse(xhs.responseText);
				  if (result.succ === true){
					  alert('*좋아요*를 눌렀습니다!!');
				  }else if(result.succ == 'duplication'){
					   alert('이미 좋아요한 게시물입니다.');
				  }else{
					  alert('db 연결 오류');
				  }
				}
			  }
			}
			xhs.open('GET', 'updateLike.php?no=' + <?= $recipe_No ?>);
			xhs.send();
		  }
  
	</script>
	<script>
		function getName(value) {
			switch (value) {
				case 1:
					return "반찬";
				case 2:
					return "국/탕";
				case 3:
					return "찌개";
				case 4:
					return "디저트";
				case 5:
					return "면";
				case 6:
					return "빵";
				case 7:
					return "음료";
				case 11:
					return "육류";
				case 12:
					return "채소류";
				case 13:
					return "해물류";
				case 14:
					return "달걀/유제품";
				case 15:
					return "곡류";
				case 16:
					return "과일류";

				case 21:
					return "볶음";
				case 22:
					return "끓이기";
				case 23:
					return "부침";
				case 24:
					return "굽기";
				case 25:
					return "비빔";
				case 26:
					return "찜";
				case 27:
					return "튀김";
				case 28:
					return "삶기";

				case 31:
					return "1인분";
				case 32:
					return "2인분";
				case 33:
					return "3인분";
				case 34:
					return "4인분";
				case 35:
					return "5인분";
				case 36:
					return "6인분";

				case 41:
					return "5분이내";
				case 42:
					return "10분이내";
				case 43:
					return "15분이내";
				case 44:
					return "20분이내";
				case 45:
					return "30분이내";
				case 46:
					return "60분이내";
				case 47:
					return "90분이내";
				case 48:
					return "2시간이내";
				case 49:
					return "2시간이상";
			}
		}
		document.getElementById("cg_type").textContent = getName(<?=$cg_type?>);
		document.getElementById("cg_material").textContent = getName(<?=$cg_material?>);
		document.getElementById("cg_method").textContent = getName(<?=$cg_method?>);
		document.getElementById("serving").textContent = getName(<?=$serving?>);
		document.getElementById("cook_time").textContent = getName(<?=$cook_time?>);

	</script>
</body>
