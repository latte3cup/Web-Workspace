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
    <script src="js/search.js"></script>
    <script src="js/goPost.js"></script>


    <title>주부들의 쉼터</title>
    <style>
        * {

            /*
      border: 1px solid black;
*/

        }



        .auto-resize {
            height: auto;
            min-height: 40px;
            overflow: visible;
            resize: none;
        }

        section {
            max-width: 800px;
        }

        .top {
            border-top: 1px solid black;
            padding-top: 10px;
            padding-bottom: 20px;
        }

        .fixed-image {
            height: 250px;
            object-fit: cover;
        }

        .red-heart {
            color: #fc46aa;
        }

        .pictures {
            cursor: pointer;
        }

        .btn-subscribe {
            background-color: white;
            border: 2px solid #a9da5d;
            border-radius: 20px;
            padding: 5px;
        }

        .btn-subscribe:hover {
            background-color: #a9da5d;
            box-shadow: 0px 15px 20px #a9da5d;
            color: #fff;
            transform: translateY(-4px);
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
            <li class="nav-item "><a href="index.php" class="nav-link">HOME</a></li>
            <li class="nav-item"><a href="recipe.php?sort=date&t=0&m=10&h=20" class="nav-link">레시피</a></li>
            <li class="nav-item"><a href="ranking.php?date=weekly" class="nav-link">랭킹</a></li>
            <li class="nav-item"><a href="community.php" class="nav-link">커뮤니티</a></li>
        </ul>
    </nav>

    <?php
    include_once('dbconn.php');
    $userName = $_GET['name'];
    $sql = "select id,name,gender,pdate,profile_img from member where name='$userName'";
    $result = $conn->query($sql);
    if($result-> num_rows>0){
		$row = $result->fetch_assoc();
        $id = $row['id'];
        $name = $row['name'];
        $gender = $row['gender'];
        $pdate = $row['pdate'];
        $profile_img = $row['profile_img'];
        
        if($gender=='1'){
            $gender="남성";
        }else if($gender=='0'){
            $gender="여성";
        }
	}
    ?>
    <section class="container" style="padding-bottom:20px;">
        <div class="container text-center bg-white" style="max-width: 1000px; padding-bottom:20px;">
            <div id=img_part class="">
                <img src="IMG/<?= $profile_img ?>" class="mt-3 mb-3" id="profile_img">
            </div>

            <div class="row">
                <div class="col-2"></div>
                <div class="col-3 top"><b><?= $name ?></b></div>
                <div class="col-2 top"><?= $gender ?></div>
                <div class="col-3 top"><?= $pdate ?> 생성</div>
                <div class="col-2"></div>
            </div>
            <div class="text-center"><button class="btn-subscribe" onclick="addSubs('<?= $id ?>')">구독하기</button></div>
        </div>
        <?php
        $sql_posts = "select * from post where posted_name='$name'";
        $result2 = $conn->query($sql_posts);
   
        ?>
        <div class="container bg-white mt-5" style="max-width: 1000px; ">
            <?php
            if($result2-> num_rows>0){        
            ?>
            <div style="padding-top:20px;"><b><?= $name ?></b>님의 레시피</div>
            <div class="row d-flex align-self-center mb-5 pictures">
                <?php
                while($row2 = $result2-> fetch_assoc()){  
                ?>
                <div class="card col-md-4 mt-5 p-0" onclick="goPost(<?= $row2['recipe_No']?>)">
                    <img src="IMG/<?=$row2['image']?>" class="img-fluid card-img-top fixed-image">
                    <div class="card-body p-1 mt-1 d-flex flex-column justify-content-between">
                        <p class="mt-1"><?=$row2['title']?></p>
                        <div class="container mt-1 d-flex align-items-end p-0" style="position:relative">
                            <div><i class="bi bi-heart-fill red-heart"></i><?= $row2['likes'] ?></div>
                        </div>
                    </div>
                </div>

                <?php
                }
                ?>
            </div>
        </div>
        <?php
        }
        ?>







    </section>
    <footer>
        <pre>(주)주부들의 쉼터 : 경기도 포천시 호국로 1007
      제작자 : 오준걸 | t. ##-###-#### | F. 010-####-###
      Fax. ##-###-#### | 사업자 번호 : ###-###-### <address>20181165@daejin.ac.kr</address>
      </pre>
    </footer>
    <script>
        function addSubs(id) {
            boolValue = JSON.parse('<?= $login ?>');
            if (!boolValue) {
                alert('구독하려면 로그인을 해야합니다.');
                return;
            }
            const xhs = new XMLHttpRequest();
            xhs.onreadystatechange = function() {
                if (xhs.readyState === xhs.DONE) {
                    if (xhs.status === 200) {
                        const result = JSON.parse(xhs.responseText);
                        if (result.succ === true)
                            alert('구독이 완료되었습니다.');
                        else{
                            alert('이미 구독한 유저입니다.')
                        }
                    }
                }
            }
            xhs.open('GET', 'updateSubs.php?id=' + id); // 
            xhs.send();
        }

    </script>




</body>



</html>
<!---->
