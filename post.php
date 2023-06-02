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
			   /*border: 1px solid black;*/
		}

		.pf_img {
			width: 30px;
			height: 30px;
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
		echo $profile_img;
	}
	?>
	<section class="container mt-2 bg-gray">
		<div class="container text-center row" style="max-width: 1000px margin:0,auto; ">
			<div class="col-6">
				<img  src="IMG/<?= $thumb_img ?>" style="max-width: 350px; ">
			</div>
			<div class="col-6"></div>
			
		</div>
	</section>
	<footer>
		<pre>(주)주부들의 쉼터 : 경기도 포천시 호국로 1007
      제작자 : 오준걸 | t. ##-###-#### | F. 010-####-###
      Fax. ##-###-#### | 사업자 번호 : ###-###-### <address>20181165@daejin.ac.kr</address>
      </pre>
	</footer>


</body>
