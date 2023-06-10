<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Nanum+Gothic&display=swap" rel="stylesheet">
	<!--반응형 웹을 위한 미디어 쿼리 지정-->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--부트스트랩 cdn 정의-->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
	<!--부트스트랩 아이콘 CDN-->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

	<!-- Jquery CDN 정의-->
	<script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
	<!--swiper-->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />
	<script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
	<!--기본 프레임 css-->
	<link rel="stylesheet" href="css/base.css">
    <script src="js/search.js"></script>
    
	<title>main_bootstrap</title>
	<style>
		* {
			/*
			border: 1px solid black;
*/
		}

		.sidebar {
			border-right: 1px solid black;
			padding-right: 10px;

		}

		.menus {
			padding: 5px;
			cursor: pointer;
			border-bottom: 1px solid black;
			box-shadow: 2px 2px gray;
		}
		footer{
			margin-top: 30px;
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
					<button class="btn btn-outline-secondary" type="submit">검색</button>
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

	<!--메뉴 바-->
	<nav>
		<ul class="container list-unstyled d-flex justify-content-around mb-0 pt-2 pb-2 ">
			<li class="nav-item  "><a href="index.php" class="nav-link">HOME</a></li>
			<li class="nav-item"><a href="recipe.php?sort=date&t=0&m=10&h=20" class="nav-link">레시피</a></li>
			<li class="nav-item"><a href="ranking.php?date=weekly" class="nav-link">랭킹</a></li>
			<li class="nav-item"><a href="community.php" class="nav-link">커뮤니티</a></li>
		</ul>
	</nav>

	<section class="container-fluid">
		<div class="container">
			<div class="row">
				<div class="col-md-3 sidebar p-0 bg-white">
					<ul class="list-unstyled fw-bold mb-0">
						<li class="menus mt-2 mb-2" onclick="logOut()">로그아웃</li>
						<li class="menus mb-2" onclick="loadPage('announcement.html')">공지사항</li>
						<li class="menus mb-2" onclick="loadPage('signModify.php')">정보수정</li>
						<li class="menus mb-2" onclick="loadPage('subscribedUser.php')">구독한 유저</li>
						<li class="menus mb-2" onclick="loadPage('likedPosts.php')">관심 있는 게시물</li>
						<li class="menus" onclick="loadPage('confrim.html')">회원탈퇴</li>
					</ul>
				</div>
				<div class="col-md-9">
					<div class="bg-white" id='innerHTML'> <b><?= $uname . " 님 환영합니다."; ?></b></div>
				</div>
			</div>
		</div>

	</section>
	<footer>
		<pre>(주)주부들의 쉼터 : 경기도 포천시 호국로 1007
      제작자 : 오준걸 | t. ##-###-#### | F. 010-####-###
      Fax. ##-###-#### | 사업자 번호 : ###-###-### <address>20181165@daejin.ac.kr</address>
      </pre>
	</footer>

	<script>
		function logOut() {
			if (confirm('로그아웃 하시겠습니까?')) {
				location.href = "logOut.php";
			}
		}

	</script>

	<script>
		function loadPage(funcName) {
			var xhr = new XMLHttpRequest();
			xhr.onreadystatechange = function() {
				if (xhr.readyState === 4 && xhr.status === 200) {
					var response = xhr.responseText;
					document.getElementById("innerHTML").innerHTML = response;
                    loadScript(funcName);
				}
                
				
			};
			xhr.open("GET", funcName, true);
			xhr.send();
			
		}

	</script>
	<script>
		function loadScript(page) {
            var jsfile = "";
            switch (page){
                case 'signModify.php' :
                    jsfile = 'signModify.js';
                    break;
                case 'subscribedUser.php' :
                    jsfile = 'goUser.js';
                    break;
                case 'likedPosts.php' :
                    jsfile = 'goPost.js';
                    break;
            }
            const script = document.createElement('script');
			script.src = "js/" + jsfile; // 외부 페이지에 포함된 스크립트 파일 경로
			document.body.appendChild(script);
		}
	</script>


</body>





</html>
<!---->
