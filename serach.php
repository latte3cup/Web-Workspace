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
	

    <title>주부들의 쉼터</title>
    <style>
        * {
            /*   border: 1px solid black;*/
        }
        .pf_img{
          width: 30px;
          height: 30px; 
        }
        .red-heart {
			color: #fc46aa;
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
    $search = $_GET['query'];
    ?>
    <header>
        <div class="container-fluid mt-2 mb-2 d-flex" style="max-width: 800px;">
            <div class="input-group">
                <a href="index.php">
                    <img src="IMG/LOGO.png" class="img-fluid">
                </a>
                <input type="text" id="searchInput" class="form-control h-50 align-self-center shadow" placeholder="<?php echo $search; ?>" maxlength=15>
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
    //검색 처리
    include_once('dbconn.php');
    $sql = "select * from post where recipe_name LIKE '%$search%'";
    $result= $conn->query($sql);
    ?>
    <section class="container-fluid mt-2">
        <div class="container mb-5 pb-2 pt-4">
            총 <b><?= $result->num_rows ?></b>개의 레시피가 있습니다.
            <hr>
            <div class="bg-white p-5">
                <?php
                if (!($result->num_rows > 0)){ //검색된 레시피가 없으면
                    echo "<h2 class='text-center'>'<b>". $search ."</b>'에 대한 검색 결과가 없습니다.</h2>";
                ?>
                <div class="mt-5 ">
                    <div class="container-fluid text-center">
                        <img src="IMG/stop.png " class="img-fluid mb-3" style="max-width:30%;">
                    </div>
                    <p class="text-center m-0">- 단어의 철자가 정확한지 확인해주세요.</p>
                    <p class="text-center m-0">- 검색어의 단어 수를 줄이거나, 다른 검색어로 검색해 보세요.</p>
                    <p class="text-center m-0">- 더 일반적인 검색어로 다시 검색해 보세요.</p>
                </div>
                <?php
                }else{
                    while($row = $result-> fetch_assoc()){
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
                }
                ?>
            </div>



        </div>
    </section>
    <footer>
        <pre>(주)주부들의 쉼터 : 경기도 포천시 호국로 1007
      제작자 : 오준걸 | t. ##-###-#### | F. 010-####-###
      Fax. ##-###-#### | 사업자 번호 : ###-###-### <address>20181165@daejin.ac.kr</address>
      </pre>
    </footer>


</body>
