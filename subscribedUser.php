<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/goUser.js"></script>
    <style>
        .card{
            border: 2px solid gray;
            cursor: pointer;
        }
        
    </style>
</head>

<body>
	<?php
	session_start();
	$id = $_SESSION['current_uid'];
	include_once('dbconn.php');
	$exist = false;
	$sql = "select subscribedUser from subusers where id='$id'";
	$result = $conn->query($sql);  //좋아요한 게시물들의 post 넘버들을 가져옴
	if($result->num_rows > 0) {
		$users_array = array();
		$exist = true;
		while($row = $result-> fetch_assoc()){
			$users_array[] = $row['subscribedUser'];	
		}
	}else{
		
	}
	?>

	<?php 
	if ($exist){
		
	?>
	<h3 class="mt-2 mb-3" style="padding-top:5px;">구독한 요리인</h3><hr>
	<div class="container row">
		<?php
       
		for($i=0; $i < count($users_array); $i++){
			$sql_card = "select * from member where id='$users_array[$i]'";
			$result_card = $conn->query($sql_card);
			$row = $result_card-> fetch_assoc();
  
		?>
		<div class="col-4 card rounded-circle" style="max-width :100px; max-height:100px" onclick="goUser('<?=$row['name'] ?>')">
			<img src="IMG/<?=$row['profile_img']?>" class="card-img-top profile_img rounded-circle">
			<div class="card-body p-0">
				<p class="text-center  m-0"><?=$row['name']?></p>
			</div>
		</div>
		<?php
		}
		?>
	</div>
	<?php
	}else{
		echo "<h3 class='mt-2' style='padding-top:5px;'>구독한 요리인</h3>";
		echo "<p class='mt-3'>구독한 유저가 없습니다.</p>";
	}
	?>





</body>

</html>
