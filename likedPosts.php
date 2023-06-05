<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
	<style>
		.fixed-image {
		  height: 250px;
		  object-fit: cover;
		}
		.pf_img {
			width: 30px;
			height: 30px;
		}
		.red-heart {
		  color: #fc46aa;
		}
		*{
			/*border: 1px solid black;*/
		}

	</style>
</head>

<body>
	<?php
	session_start();
	$id = $_SESSION['current_uid'];
	include_once('dbconn.php');
	$exist = false;
	$sql = "select likedPosts from likes where id='$id'";
	$result = $conn->query($sql);  //좋아요한 게시물들의 post 넘버들을 가져옴
	if($result->num_rows > 0) {
		$posts_array = array();
		$exist = true;
		while($row = $result-> fetch_assoc()){
			$posts_array[] = $row['likedPosts'];	
		}
	}else{
		
	}
	?>

	<?php 
	if ($exist){
		
	?>
	<h3 class="mt-2 mb-4" style="padding-top:5px;">좋아요한 게시물</h3>
	<div class="container row">
		<?php
			for($i=0; $i < count($posts_array); $i++){
				$recipe_No = intval($posts_array[$i]);
				$sql_card = "select * from post where recipe_No=$recipe_No";
				$result_card = $conn->query($sql_card);
				$row = $result_card-> fetch_assoc();
			?>
		<div class="col-4 card">
			<img src="IMG/<?=$row['image']?>" class="img-fluid fixed-image">
			<div class="card-body p-1 mt-1 d-flex flex-column justify-content-between">
				<p class="mt-1"><?=$row['title']?></p>
				<div class="container mt-1 d-flex align-items-end p-0" style="position:relative">
					<?php
						  $post_id = $row['posted_ID'];
						  $sql2 = "select * from member where id = '$post_id'";
						  $result2 = $conn->query($sql2);
						  $row2 = $result2 -> fetch_assoc();
						  ?>
					<img src="IMG/<?=$row2['profile_img']?>" class="pf_img  rounded-circle">
					<div class="p-1"><?= $row2['name']?></div>
					<div style="position: absolute; top: 0; right: 0;">
						<div><i class="bi bi-heart-fill red-heart"></i><?= $row['likes'] ?></div>
					</div>
				</div>
			</div>
		</div>
		<?php
			}
			?>
	</div>
	<?php
	}else{
		echo "<h3 class='mt-2' style='padding-top:5px;'>좋아요한 게시물</h3>";
		echo "<p class='mt-3'>좋아요한 게시물이 없습니다.</p>";
	}
	?>





</body>

</html>
