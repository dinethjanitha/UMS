<?php require_once("inc/connection.php")  ?>
<?php session_start() ?>

<?php 

	if (!isset($_SESSION['user_id'])) {
		header("Location: login.php");
	}

	if(isset($_GET["userid"])){
		$user_id = mysqli_real_escape_string($conn,$_GET['userid']);
		if($user_id == $_SESSION['user_id']){

			// current user!
			header("Location:users.php?err=should_not_delete_current_user");
		}else{
			$querydelete = "UPDATE user SET is_deleted=1 WHERE id = {$user_id}";
			$result = mysqli_query($conn,$querydelete);
			if($result){
				header("Location: users.php?userdelete=done");
			}else{
				header("Location: users.php?userdelete=faild");
			}
		}
		
	}else{
		header("Location:users.php?err=somethingwrong");
	}

 ?>
