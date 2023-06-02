<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <!--기본 프레임 css-->
  <link href="css/base.css?after" type="text/css" rel="stylesheet">

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
  <script src="js/search.js"></script>
    
  <title>main_bootstrap</title>
    
  <!--스타일-->
  <style>
    * {
    /*  border: 1px solid black;*/
    }

    .swiper-button-prev,
    .swiper-button-next {
      color: gray;
    }

    .fixed-image {
      height: 100px;
      object-fit: cover;
    }
    .rank_icon{
      border : 1px solid black;
      padding-left:5px;
      padding-right: 5px;
      background-color: white;
      border-radius: 5px;
    }
    .more_btn{
      border : 1px solid green;
      border-radius: 5px;
    }
    a{
      text-decoration: none;
      color: inherit;
    }
    .post{
        cursor: pointer;
          
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
    <!--검색 바, 회원접근-->
  <header>
    <div class="container-fluid mt-2 mb-2 d-flex" style="max-width: 800px;">
      <div class="input-group">
        <a href="index.php">
          <img src="IMG/LOGO.png" class="img-fluid">
        </a>
        <input type="text" id="searchInput" class="form-control h-50 align-self-center shadow" placeholder="검색할 레시피를 입력하세요." maxlength=15  onkeypress="searchEnter(event)">
        <div class="input-group-append align-self-center shadow">
          <button class="btn btn-outline-secondary" type="submit" onclick="searchRecipe()" >검색</button>
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
      <li class="nav-item selected"><a href="index.php" class="nav-link">HOME</a></li>
      <li class="nav-item"><a href="recipe.php?sort=date&t=0&m=10&h=20" class="nav-link">레시피</a></li>
      <li class="nav-item"><a href="ranking.php?date=weekly" class="nav-link">랭킹</a></li>
      <li class="nav-item"><a href="community.php" class="nav-link">커뮤니티</a></li>
    </ul>
  </nav> 
    
  <section class="container-fluid">

    <!-- Slider 컨테이너 -->
    <div class="swiper container mb-4">
      <!-- Additional required wrapper -->
      <div class="swiper-wrapper">
        <!-- Slides -->
        <div class="swiper-slide"><img src="IMG/Main1.jpg" style="object-fit: cover; width: 100%; height: 100%;"></div>
        <div class="swiper-slide"><img src="IMG/Main2.jpg" style="object-fit: cover; width: 100%; height: 100%;"></div>
        <div class="swiper-slide"><img src="IMG/Main3.jpg" style="object-fit: cover; width: 100%; height: 100%;"></div>
      </div>
      <!--pagination -->
      <div class="swiper-pagination"></div>
      <!--navigation buttons -->
      <div class="swiper-button-prev"></div>
      <div class="swiper-button-next"></div>
    </div>

    <!--주간 레시피 순위-->
    <div id="weekly-recommand" class="container mb-5 bg-white">
      <div class=" d-flex align-items-start justify-content-between row ">
        <div class="col-md-2 ">
          <div class="fs-5 fw-bold mt-1 mb-1">주간 레시피</div>
          <div><p>이번 주 가장 많은 추천수를 받은 레시피입니다.</p></div>
          <div class="ml-auto text-center more_btn"><a href="ranking.php?date=monthly">더보기</a></div>
        </div>
        <?php
        #post 테이블의 레코드 검색해서 출력하기
        include_once('dbconn.php');
        $today = date("Y-m-d");
        $today_minus_7 = date("Y-m-d", strtotime($today . "-7 days"));
        $sql = "select * from post where posted_date>='$today_minus_7' order by likes desc";
        $result = $conn->query($sql); //  select 실행으로 검색된레코드 집합을 반환 
        if ($result->num_rows > 0){ // 검색된 레코드가 있으면 
          $num = 0;
          $rank_num = 1;
          while(($row = $result -> fetch_assoc()) and $num<5){
            
        ?>
        
        <div class="col-md-2 card p-0 position-relative post" onclick="goPost(<?= $row['recipe_No'] ?>)">
          <div class="position-absolute top-0 left-10 rank_icon "><?= $rank_num++ ?></div>
          <img src="IMG/<?=$row['image']?>" class="card-img-top fixed-image">
          <div class="card-body p-1 mt-1">
            <p class="text-truncate "><?=$row['title']?></p>
          </div>
        </div>
    
        <?php
          $num++;
          }
        }
        ?>
      </div>
        
    </div>
      
    <!--월간 레시피-->
    <div id="monthly-recommand" class="container mb-5 bg-white">
      <div class=" d-flex align-items-start justify-content-between row ">
        <?php
        $today_minus_30 = date("Y-m-d", strtotime($today . " -30 days"));
        $sql2 = "select * from post where posted_date>='$today_minus_30' order by likes desc";
        $result2 = $conn->query($sql2);
        if ($result2->num_rows > 0){ // 검색된 레코드가 있으면 
          $num = 0;
          $rank_num=1;
          while(($row = $result2 -> fetch_assoc()) and $num<5){  
        ?>
        <div class="col-md-2 card p-0 position-relative post" onclick="goPost(<?= $row['recipe_No'] ?>)">
          <div class="position-absolute top-0 left-10 rank_icon "><?= $rank_num++ ?></div>
          <img src="IMG/<?=$row['image']?>" class="card-img-top fixed-image">
          <div class="card-body p-1 mt-1">
            <p class="text-truncate"><?=$row['title']?></p>
          </div>
        </div>
        <?php
          $num++;
          }
        }else echo "등록된 상품이 없습니다.";
        ?>

        <div class="col-md-2">
          <div class="fs-5 fw-bold mt-1 mb-1">월간 레시피</div>
          <div><p>이번 달 가장 많은 추천수를 받은 레시피입니다.</p></div>
          <div class="ml-auto text-center more_btn"><a href="ranking.php?date=monthly">더보기</a></div>
        </div>
      </div>

    </div>
      
    <!-- 유저 랜덤 추천-->
    <div class="container mb-5 bg-white">
      <div>요리인 소개 </div>
      <div class=" d-flex align-items-start justify-content-between row ">
        <?php
      $sql3 = "SELECT * FROM member ORDER BY RAND() LIMIT 11";
      $result3 = $conn->query($sql3);
      if ($result3->num_rows > 0){ // 검색된 레코드가 있으면 
        $num = 0;
        while(($row = $result3 -> fetch_assoc()) and $num<11){  
      ?>
      <div class="col-md-1 card p-0">
        <img src="IMG/<?=$row['profile_img']?>" class="card-img-top profile_img rounded-circle">
        <div class="card-body p-0">
          <p class="text-center  m-0"><?=$row['name']?></p>
        </div>
      </div>
      <?php
        $num++;
        }
      }
      ?>
      </div>

    </div>
      
    
    <!--영상으로 레시피 보기 // 외부 유튜브 링크-->
    <div class="container mb-4 bg-white">
      <div class="mb-2"><span class="fs-5 fw-bold" style="color: green">영상</span>으로 보는 레시피 </div>
      <div class="container">
        <!--유튜브 썸네일 슬라이더 대입-->
        <div class=" d-flex align-items-end justify-content-between row ">
          <div class="col-md-3 card">
            <a href="https://www.youtube.com/watch?v=ZEDt9Jm1A4g" target="_blank">
              <img src="IMG/youtube_thumb/thumb1.jpg" class="card-img-top">
            </a>
            <div class="card-body text-truncate">쉽지만 고급진 손님 요리 모음</div>
          </div>
          <div class="col-md-3 card">
            <a href="https://www.youtube.com/watch?v=HHxrciV2-MU">
              <img src="IMG/youtube_thumb/thumb2.jpg" class="card-img-top">
            </a>
            <div class="card-body text-truncate">
              [이연복] 칠리새우
            </div>
          </div>
          <div class="col-md-3 card">
            <a href="https://www.youtube.com/watch?v=IV_fNz4ojlI">
              <img src="IMG/youtube_thumb/thumb3.jpg" class="card-img-top ">
            </a>
            <div class="card-body text-truncate">
              한우 꼬리 수육 : "우리 아이 술안주, 아빠의 영양간식"
            </div>
          </div>
          <div class="col-md-3 card">
            <a href="https://www.youtube.com/watch?v=HOSOi8u04qY">
              <img src="IMG/youtube_thumb/thumb4.jpg" class="card-img-top ">
            </a>
            <div class="card-body text-truncate">
              치킨 역대급 레시피 _못 믿겠지만 설거지까지 해서 11분_
            </div>
          </div>
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

  <!--Swiper 스크립트-->
  <script>
    const swiper = new Swiper('.swiper', {
      // Optional parameters
      direction: 'horizontal',
      loop: true,

      // If we need pagination
      pagination: {
        el: '.swiper-pagination',
      },
      // Navigation arrows
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
      autoplay: {
        delay: 5000,
      },
    });

  </script>
    
    
  <script>
    function goPost(post){
        let link = "post.php?no=" + post;
        window.location.href=link;
    }
  </script>

</body>



</html>
<!---->
