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
  <title>주부들의 쉼터</title>

  <style>
    * {

      /*      border: 1px solid black;*/


    }

    .boxed {
      border-right: 1px solid black;
    }

    #thumbPhoto {
      cursor: pointer;
      max-width: 250px;
      max-height: 250px;

    }

    .stepImg {
      width: 110px;
      height: 110px;
      object-fit: cover;
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
  <!--메뉴 바-->
  <nav>
    <ul class="container list-unstyled d-flex justify-content-around mb-0 pt-2 pb-2 ">
      <li class="nav-item "><a href="index.php" class="nav-link">HOME</a></li>
      <li class="nav-item"><a href="recipe.php?sort=date&t=0&m=10&h=20" class="nav-link">레시피</a></li>
      <li class="nav-item"><a href="ranking.php?date=weekly" class="nav-link">랭킹</a></li>
      <li class="nav-item"><a href="community.php" class="nav-link">커뮤니티</a></li>
    </ul>
  </nav>

  <form class="container-fluid pt-0 section" action="upload.php" method="post" enctype="multipart/form-data" id="myForm">
    <!--레시피 등록-->
    <div class="container bg-white ">
      <p class="container fw-bold mt-3 pt-3 fw-5">레시피 등록</p>
      <hr>
      <div class="contianer-fluid">
        <div class="container row ">
          <div class="col-md-8">
            <div class="row mb-3">
              <div class="col-md-3">
                레시피 이름
              </div>
              <div class="col-md-8">
                <input type="text" class="form-control" id="inputRecipeName" placeholder="예) 제육덮밥" name="recipe_name">
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-3">
                요리소개<br> /게시물 제목
              </div>
              <div class="col-md-8">
                <textarea class=" form-control" rows="3" placeholder=" 이 레시피의 간단한 설명을 입력해 주세요. 예) 혼자 자취인들을 위한 간단 제육볶음 레시피!" maxlength=40 style="resize: none" id="inputTitle" name="title"></textarea>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-3">
                카테고리
              </div>
              <div class="col-md-3">
                <select name="cg_type" class="form-select" text="종류별" id="cg_type">
                  <option value="0">종류별</option>
                  <option value="1">반찬</option>
                  <option value="2">국/탕</option>
                  <option value="3">찌개</option>
                  <option value="4">디저트</option>
                  <option value="5">면</option>
                  <option value="6">빵</option>
                  <option value="7">음료</option>
                </select>
              </div>
              <div class="col-md-3">
                <select name="cg_material" class="form-select" text="재료별" id="cg_material">
                  <option value="10">재료별</option>
                  <option value="11">육류</option>
                  <option value="12">채소류</option>
                  <option value="13">해물류</option>
                  <option value="14">달걀/유제품</option>
                  <option value="15">곡류</option>
                  <option value="16">과일류</option>
                </select>
              </div>
              <div class="col-md-2">
                <select name="cg_method" class="form-select" text="방법별" id='cg_method'>
                  <option value="20">방법별</option>
                  <option value="21">볶음</option>
                  <option value="22">끓이기</option>
                  <option value="23">부침</option>
                  <option value="24">굽기</option>
                  <option value="25">비빔</option>
                  <option value="26">찜</option>
                  <option value="27">튀김</option>
                  <option value="28">삶기</option>
                </select>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-3">
                요리정보
              </div>
              <div class="col-md-1">
                <p class="m-0 pt-2 text-center">인원</p>
              </div>
              <div class="col-md-2">
                <select name="serving" class="form-select " text="인원" id='serving'>
                  <option value="30">인원</option>
                  <option value="31">1인분</option>
                  <option value="32">2인분</option>
                  <option value="33">3인분</option>
                  <option value="34">4인분</option>
                  <option value="35">5인분</option>
                  <option value="36">6인분 이상</option>
                </select>
              </div>
              <div class="col-md-2">
                <p class="m-0 pt-2 text-center">조리시간</p>
              </div>
              <div class="col-md-3">
                <select name="cook_time" class="form-select " text="조리시간" id='cook_time'>
                  <option value="40">조리시간</option>
                  <option value="41">5분이내</option>
                  <option value="42">10분이내</option>
                  <option value="43">15분이내</option>
                  <option value="44">20분이내</option>
                  <option value="45">30분이내</option>
                  <option value="46">60분이내</option>
                  <option value="47">90분이내</option>
                  <option value="48">2시간이내</option>
                  <option value="49">2시간이상</option>
                </select>
              </div>
            </div>
          </div>

          <div class=" col-md-4 d-flex align-items-center justify-content-center">
            <img class="img-fluid" id="thumbPhoto" src="IMG/uploadIMG.gif">
            <input type="file" class="upload-btn" accept="image/* " required style="display: none;" name="thumbIMG">
          </div>
        </div>
      </div>
    </div>

    <!--주재료 / 부재료 필드-->
    <div class="container bg-white mt-4">
      <p class="container fw-bold pt-3">재료</p>
      <div id="material-group" class="row">
        <div class="container text-center col-md-6 boxed">주재료
          <hr>
          <div class="row material-main1 d-flex flex-column ">
            <!--버튼을 통해 삽입-->
          </div>
          <div id="button-aria" class="d-flex justify-content-center mt-2">
            <button type="button" id="addButton1">추가하기</button>
          </div>
        </div>
        <div class="container text-center col-md-6">부재료
          <hr>
          <div class="row material-main2 d-flex flex-column-reverse ">
            <div id="button-aria" class="d-flex justify-content-center mt-2">
              <button type="button" id="addButton2">추가하기</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!--요리 단계 필드-->
    <div class="container bg-white mt-4">
      <p class="container fw-bold  mt-3 pt-3"> 요리 순서</p>
      <hr>
      <div class="container" id="Step-Aria">
        <div class="container row mb-2 ">
          <div class="col-md-1"></div>
          <div class="col-md-1">
            Step1
          </div>
          <div class="col-md-6">
            <textarea class=" form-control" rows="4" placeholder="이 레시피의 간단한 설명을 입력해 주세요. 예) 혼자 자취인들을 위한 간단 제육볶음 레시피!" maxlength=200 style="resize: none" name="info1"></textarea>
          </div>
          <div class="col-md-4">
            <img id="img1" src="IMG/stepInputImg.gif" class="stepImg" onclick="set_step_img(1)">
            <input type="file" class="upload-step-btn" accept="image/* " required style="display: none;" name="step_img1">
          </div>
        </div>
      </div>


      <div id="button-aria" class="d-flex justify-content-center mt-2">
        <button id="addStepBtn">추가하기</button>
      </div>

    </div>
    <button type="button" onclick="insert()">전송</button>
  </form>

  <footer>
    <pre>(주)주부들의 쉼터 : 경기도 포천시 호국로 1007x
      제작자 : 오준걸 | t. ##-###-#### | F. 010-####-###
      Fax. ##-###-#### | 사업자 번호 : ###-###-### <address>20181165@daejin.ac.kr</address>
      </pre>
  </footer>

  <!--메인재료 필드 추가-->
  <script>
    var mainNum = 1;
    $(document).ready(function() {
      $('#addButton1').click(function() {
        if (mainNum == 11) {
          alert('최대 10까지 등록 가능합니다.');
          return;
        }
        var rowDiv = $('<div>').addClass('row mt-3 mb-2');
        var colDiv1 = $('<div>').addClass('col-md-6');
        var colDiv2 = $('<div>').addClass('col-md-5');
        var colDiv3 = $('<div>').addClass('col-md-1');
        var inputField1 = $('<input>').attr('type', 'text').addClass('form-control').attr('placeholder', '예) 돼지고기').attr('name', 'main' + mainNum);
        var inputField2 = $('<input>').attr('type', 'text').addClass('form-control').attr('placeholder', '300g').attr('name', 'main_amount' + mainNum++);
        var deleteIcon = $('<i>').addClass('bi bi-x btn');

        deleteIcon.click(function() {
          rowDiv.remove();
        });

        colDiv1.append(inputField1);
        colDiv2.append(inputField2);
        colDiv3.append(deleteIcon);
        rowDiv.append(colDiv1);
        rowDiv.append(colDiv2);
        rowDiv.append(colDiv3);
        rowDiv.appendTo('.material-main1');
      });
    });

  </script>

  <!--서브재료 필드 추가-->
  <script>
    var subNum = 1;
    $(document).ready(function() {
      $('#addButton2').click(function() {
        if (subNum == 11) {
          alert('최대 10까지 등록 가능합니다.');
          return;
        }
        var rowDiv = $('<div>').addClass('container row mt-3 mb-2');
        var colDiv1 = $('<div>').addClass('col-md-6');
        var colDiv2 = $('<div>').addClass('col-md-5');
        var colDiv3 = $('<div>').addClass('col-md-1');
        var inputField1 = $('<input>').attr('type', 'text').addClass('form-control').attr('placeholder', '예) 소금').attr('name', 'sub' + subNum);
        var inputField2 = $('<input>').attr('type', 'text').addClass('form-control').attr('placeholder', '2스푼').attr('name', 'sub_amount' + subNum++);
        var deleteIcon = $('<i>').addClass('bi bi-x btn');

        deleteIcon.click(function() {
          rowDiv.remove();
        });

        colDiv1.append(inputField1);
        colDiv2.append(inputField2);
        colDiv3.append(deleteIcon);
        rowDiv.append(colDiv1);
        rowDiv.append(colDiv2);
        rowDiv.append(colDiv3);
        rowDiv.appendTo('.material-main2');
      });
    });

  </script>



  <script>
    $(document).ready(function() {
      // 추가 버튼 클릭 시 동작
      var stepNum = 2;
      $("#addStepBtn").click(function() {
        if (stepNum == 11) {
          alert('스텝은 최대 10단계까지 등록 가능합니다.');
          return;
        }
        // 새로운 스텝 요소를 생성하여 컨테이너에 추가
        var newStep = `
      <div class="container row mb-2" >
          <div class="col-md-1"></div>
        <div class="col-md-1">
          Step${stepNum}
        </div>
        <div class="col-md-6">
          <textarea class="form-control" rows="4" placeholder="이 레시피의 간단한 설명을 입력해 주세요. 예) 혼자 자취인들을 위한 간단 제육볶음 레시피!" maxlength="200" style="resize: none" name="info${stepNum}"></textarea>
        </div>
        <div class="col-md-4">
          <img id="img${stepNum}" src="IMG/stepInputImg.gif" class="stepImg" onclick="set_step_img(${stepNum})">
          <input type="file" class="upload-step-btn" accept="image/* " required style="display: none;" name="step_img${stepNum}">
        </div>
      </div>
    `;
        $("#Step-Aria").append(newStep);
        stepNum++;
      });
    });

  </script>

  <script>
    // 섬네일 이미지의 효과 변경
    // 이미지 업로드 영역
    const fileInput = document.querySelector('.upload-btn');
    // 바꿀 이미지 영역
    const imageElement = document.getElementById('thumbPhoto');
    imageElement.addEventListener('click', () => fileInput.click()); //업로드 버튼 클릭을 호출
    fileInput.addEventListener('change', function() {
      if (fileInput.files && fileInput.files[0]) {
        var reader = new FileReader(); //이미지 파일 읽기
        reader.onload = function(e) {
          //이미지 파일의 위치
          let dataURL = e.target.result;
          imageElement.src = dataURL;
        };
        reader.readAsDataURL(fileInput.files[0]);
      }
    });

  </script>

  <!--스텝 이미지의 효과 변경-->
  <script>
    // 스텝은 고정 요소가 아니기 떄문에 함수로 처리해야함. 이럴바엔 섬네일 이미지도 함수로 처리하는 것이 좋았을 듯
    function set_step_img(num) {
      const fileInput = document.getElementsByName('step_img' + num)[0];
      const imageElement = document.getElementById('img' + num);
      fileInput.click();
      fileInput.addEventListener('change', function() {
        if (fileInput.files && fileInput.files[0]) {
          var reader = new FileReader();
          reader.onload = function(e) {
            let dataURL = e.target.result;
            imageElement.src = dataURL;
          };
          reader.readAsDataURL(fileInput.files[0]);
        }
      });
    }

  </script>

  <script>
    //함수로 처리 필요
    function insert() {
      document.getElementById('myForm').submit();
    }

  </script>
</body>



</html>
<!---->
