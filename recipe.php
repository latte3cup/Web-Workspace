<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Nanum+Gothic&display=swap" rel="stylesheet">
	<!--부트스트랩 CDN-->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
	<!--부트스트랩 아이콘 CDN-->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<!-- Jquery CDN 정의-->
	<script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
	<!--기본 프레임 css-->
	<link rel="stylesheet" href="css/base.css?after">
	<script src="js/search.js"></script>
	<link rel="stylesheet" href="css/receipt.css?after">

	<title>주부들의 쉼터</title>
	<style>
		* {
			/*            border: 1px solid black;*/
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
		<!--검색 바, 회원접근-->
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
					<a href="insert.html"><span class="bi bi-pencil fs-4"></span></a>
					<?php }else { ?>
					<a href="login.html"><span class="bi bi-pencil fs-4"></span></a>
					<?php } ?>
				</div>
			</ul>
		</div>
	</header>
	<nav>
		<ul class="container list-unstyled d-flex justify-content-around mb-0 pt-2 pb-2 ">
			<li class="nav-item"><a href="index.php" class="nav-link">HOME</a></li>
			<li class="nav-item selected"><a href="recipe.php?sort=date&t=0&m=10&h=20" class="nav-link">레시피</a></li>
			<li class="nav-item"><a href="ranking.php?date=weekly" class="nav-link">랭킹</a></li>
			<li class="nav-item"><a href="community.php" class="nav-link">커뮤니티</a></li>
		</ul>
	</nav>
	<section class="container-fluid mt-2">
		<div class="container mb-5 bg-white pb-2">
			<div class="toggle-element ml-3">
				<?php
        $type = $_GET['t']; //종류별
        $material = $_GET['m']; //재료별
        $method = $_GET['h']; //방법별 how
        $sort = $_GET['sort']; // 정렬 방식 쿼리 변수
        ?>

				<?php
        #php 변수를 이용한 스크립트 생성 php구문이 끝나고 자바스크립트 실행으로 함수형으로 선언
        echo "<script>
                function applyCss() {
                   document.getElementById('$type').className='selected cg_selected';
                   document.getElementById('$material').className='selected cg_selected';
                   document.getElementById('$method').className='selected cg_selected';
                }
            </script>";
        ?>
				<!--쿼리 셀렉터가 숫자는 못받음;-->
				<ul class="mb-2 list-unstyled list-group d-flex flex-row">
					<li class="list-group-item px-3">종류별</li>
					<li id='0' value=0 onclick="classification(0)">전체</li>
					<li id='1' value=1 onclick="classification(1)">반찬</li>
					<li id='2' value=2 onclick="classification(2)">국/탕</li>
					<li id='3' value=3 onclick="classification(3)">찌개</li>
					<li id='4' value=4 onclick="classification(4)">디저트</li>
					<li id='5' vlaue=5 onclick="classification(5)">면</li>
					<li id='6' value=6 onclick="classification(6)">빵</li>
					<li id='7' value=7 onclick="classification(7)">음료</li>
				</ul>
				<ul class=" mb-2 list-unstyled list-group d-flex flex-row">
					<li class="list-group-item px-3">재료별</li>
					<li id='10' value=10 onclick="classification(10)">전체</li>
					<li id='11' value=11 onclick="classification(11)">육류</li>
					<li id='12' value=12 onclick="classification(12)">채소류</li>
					<li id='13' value=13 onclick="classification(13)">해물류</li>
					<li id='14' value=14 onclick="classification(14)">달걀/유제품</li>
					<li id='15' value=15 onclick="classification(15)">곡류</li>
					<li id='16' value=16 onclick="classification(16)">과일류</li>
				</ul>
				<ul class="list-unstyled list-group d-flex flex-row">
					<li class="list-group-item px-3">방법별</li>
					<li id='20' value=20 onclick="classification(20)">전체</li>
					<li id='21' value=21 onclick="classification(21)">볶음</li>
					<li id='22' value=22 onclick="classification(22)">끓이기</li>
					<li id='23' value=23 onclick="classification(23)">부침</li>
					<li id='24' value=24 onclick="classification(24)">굽기</li>
					<li id='25' value=25 onclick="classification(25)">비빔</li>
					<li id='26' value=26 onclick="classification(26)">찜</li>
					<li id='27' value=27 onclick="classification(27)">튀김</li>
					<li id='28' value=28 onclick="classification(28)">삶기</li>
				</ul>
				<hr class="mb-2">
			</div>
			<div class="container-fluid text-center">
				<a href="#" id="toggle-link">카테고리 닫기</a>
			</div>

		</div>
		<div class="container">
			<?php
      include_once('dbconn.php');
      
      if($type==0 && $material==10 && $method==20){
        $where = '1';
      }else{ //보여줄 조건들을 결정
        ($type == 0) ? $c1="cg_type IS NOT NULL" : $c1 = "cg_type=".$type;
        ($material==10) ? $c2="cg_material IS NOT NULL" : $c2 = "cg_material=" .$material;
        ($method==20) ? $c3="cg_method IS NOT NULL" : $c3 = "cg_method=".$method;
        $where = $c1 ." && ". $c2 ." && ". $c3;
      }
      
      if($sort=="date") $order = "posted_date desc";
      else if($sort=="recommend") $order = "likes desc";
      
      $sql = "select * from post where ". $where  ." order by ". $order;
      $result= $conn->query($sql); //  select 실행으로 검색된레코드 집합을 반환 
      ?>
			<div>
				<div style="position:absolute;">
					총 <b><?= $result->num_rows ?></b>개의 레시피가 있습니다.
				</div>

				<ul class="list-unstyled d-flex justify-content-end mb-1">
					<li class="sort_li p-1 <?php if($sort=='date') echo "selected sort_selected"; ?>">
						<a class="sort-btn" onclick="classification(100)">시간순</a>
					</li>
					<li class="sort_li p-1 <?php if($sort=='recommend') echo "selected sort_selected"; ?>">
						<a class="sort-btn" onclick="classification(101)">추천순</a>
					</li>
				</ul>
			</div>
			<hr>

			<div class="container mt-3">
				<?php
        if ($result->num_rows > 0){
      
        ?>
				<div class="row d-flex align-self-center mb-5 bg-white">
					<?php
            while( $row = $result-> fetch_assoc()){
            ?>
					<div class="card col-md-3 mt-5 ">
						<img src="IMG/<?=$row['image']?>" class="img-fluid card-img-top fixed-image">
						<div class="card-body p-1 mt-1 d-flex flex-column justify-content-between">
							<p class="mt-1"><?=$row['title']?></p>
							<div class="container mt-1 d-flex align-items-end p-0" style="position:relative">
								<?php
                  $id = $row['posted_ID'];

                  $sql2 = "select * from member where id = '$id'";
                  $result2 = $conn->query($sql2);
                  $row2 = $result2 -> fetch_assoc();
                  ?>

								<img src="IMG/<?=$row2['profile_img']?>" class="pf_img  rounded-circle">
								<div class="p-1"><?= $row2['name']?></div>
								<div style="position: absolute; top: 0; right: 0;">
									<div class="pt-1"><i class="bi bi-heart-fill red-heart"></i><?= $row['likes'] ?></div>
								</div>
							</div>
						</div>
					</div>
					<?php
             
            }
          ?>
				</div>
				<?php
          }
        
        ?>
			</div>

			<navigation>
				<ul class="pagination d-flex justify-content-center">
					<li class="page-item">
						<a class="page-link" href="#" aria-label="Previous">
							<span aria-hidden="true">&laquo;</span>
							<span class="sr-only"></span>
						</a>
					</li>
					<li class="page-item"><a class="page-link" href="#">1</a></li>
					<li class="page-item"><a class="page-link" href="#">2</a></li>
					<li class="page-item"><a class="page-link" href="#">3</a></li>
					<li class="page-item"><a class="page-link" href="#">4</a></li>
					<li class="page-item"><a class="page-link" href="#">5</a></li>
					<li class="page-item">
						<a class="page-link" href="#" aria-label="Next">
							<span aria-hidden="true">&raquo;</span>
							<span class="sr-only"></span>
						</a>
					</li>
				</ul>
			</navigation>//페이징네이션 구현 X
		</div>

	</section>
	<footer>
		<pre>(주)주부들의 쉼터 : 경기도 포천시 호국로 1007
      제작자 : 오준걸 | t. ##-###-#### | F. 010-####-###
      Fax. ##-###-#### | 사업자 번호 : ###-###-### <address>20181165@daejin.ac.kr</address>
      </pre>
	</footer>

	<!--카테고리 보이기 숨기기-->
	<script>
		$(document).ready(function() {
			$('#toggle-link').click(function() {
				$('.toggle-element').toggle();
				var newText = ($('.toggle-element').is(':visible')) ? '카테고리 닫기' : '카테고리 열기';
				$('#toggle-link').text(newText);
			});
		});

	</script>

	<!--클릭 시 정렬 방식 변경-->
	<script>
		function classification(num) {
			var currentQuery = window.location.search;
			const queryParams = currentQuery.substring(1).split("&");
			if (num < 10) {
				queryParams[1] = "t=" + num;
			} else if (num < 20) {
				queryParams[2] = "m=" + num;
			} else if (num < 30) {
				queryParams[3] = "h=" + num;
			} else if (num == 100) {
				queryParams[0] = "sort=date";
			} else if (num == 101) {
				queryParams[0] = "sort=recommend";
			}
			var newQuery = 'recipe.php?' + queryParams.join("&");
			window.location.href = newQuery;

		}

	</script>

	<!--선택된 카테고리 CSS적용 #line131-->
	<script>
		applyCss()

	</script>


</body>


</html>
<!---->
