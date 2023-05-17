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

  <title>주부들의 쉼터</title>
  <style>
    * {

      /*
            border: 1px solid black;
*/

    }

    .toggle-element li {
      padding: 3px;
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
        <input type="text" class="form-control h-50 align-self-center shadow" placeholder="검색할 레시피를 입력하세요." maxlength=15>
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
      <li class="nav-item selected"><a href="recipe.php" class="nav-link">레시피</a></li>
      <li class="nav-item"><a href="ranking.php" class="nav-link">랭킹</a></li>
      <li class="nav-item"><a href="community.php" class="nav-link">커뮤니티</a></li>
    </ul>
  </nav>
  <section class="container-fluid">
    <div class="container mb-5">
      <div class="toggle-element ml-3">
        <ul class="list-unstyled list-group d-flex flex-row">
          <li class="list-group-item px-3">종류별</li>
          <li class="selected">전체</li>
          <li>반찬</li>
          <li>국/탕</li>
          <li>개</li>
          <li>디저트</li>
          <li>면</li>
          <li>빵</li>
          <li>음료</li>
        </ul>
        <ul class="list-unstyled list-group d-flex flex-row">
          <li class="list-group-item px-3">재료별</li>
          <li class="selected">전체</li>
          <li>육류</li>
          <li>채소류</li>
          <li>해물류</li>
          <li>달걀/유제품</li>
          <li>곡류</li>
          <li>과일류</li>
        </ul>
        <ul class="list-unstyled list-group d-flex flex-row">
          <li class="list-group-item px-3">방법별</li>
          <li class="selected">전체</li>
          <li>볶음</li>
          <li>끓이기</li>
          <li>부침</li>
          <li>굽기</li>
          <li>비빔</li>
          <li>찜</li>
          <li>튀김</li>
          <li>삶기</li>
        </ul>
      </div>
      <div class="container-fluid text-center">
        <a href="#" id="toggle-link">카테고리 닫기</a>
      </div>


    </div>
    <div class="container">
      <div>
        <div style="position:absolute;">
          총 <b>##</b>개의 레시피가 있습니다.
        </div>
        <ul class="list-unstyled d-flex justify-content-end mb-1">
          <li class="mr-2">추천순</li>
          <li>시간순</li>
        </ul>
      </div>
      <div class="row">
        <div class="col-md-3">1</div>
        <div class="col-md-3">2</div>
        <div class="col-md-3">3</div>
        <div class="col-md-3">4</div>
      </div>
      <div class="row">
        <div class="col-md-3">5</div>
        <div class="col-md-3">6</div>
        <div class="col-md-3">7</div>
        <div class="col-md-3">8</div>
      </div>
      <div class="row">
        <div class="col-md-3">9</div>
        <div class="col-md-3">10</div>
        <div class="col-md-3">11</div>
        <div class="col-md-3">12</div>
      </div>
      <div class="row">
        <div class="col-md-3">13</div>
        <div class="col-md-3">14</div>
        <div class="col-md-3">15</div>
        <div class="col-md-3">16</div>
      </div>
      <div class="row">
        <div class="col-md-3">17</div>
        <div class="col-md-3">18</div>
        <div class="col-md-3">19</div>
        <div class="col-md-3">20</div>
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
      </navigation>
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




</body>



</html>
<!---->