<?php require_once("inc/connection.php")  ?>
<?php session_start() ?>
<?php require_once("inc/nav.php") ?>

<?php 

	if (!isset($_SESSION['user_id'])) {
		header("Location: login.php");
	}

	$email = "";
	$firstname = "";
	$lastname = "";
	$password = "";
	$user_id = "";

	if(isset($_GET["userid"])){
		$user_id = mysqli_real_escape_string($conn,$_GET['userid']);
		$query = "SELECT * FROM user WHERE id='$user_id'";

		$result = mysqli_query($conn,$query);

		if($result){
			if(mysqli_num_rows($result) == 1){
				$record = mysqli_fetch_assoc($result);
				$email = $record["email"];
				$password = $record["password"];
				$firstname = $record["first_name"];
				$lastname= $record["last_name"];

			}else{
				header("Location: users.php?user=notfund");
			}
			
		}else{
			die("Faild!");
		}

	}else{
		if(!isset($_POST['user_id'])){
				header("Location:users.php?something=wrong");
		}
	}

	$error = array();

	if(isset($_POST['submit'])){
		echo "<pre>";
		echo print_r($_POST);
		echo "</pre>";

		$user_id = mysqli_real_escape_string($conn,$_POST['user_id']);

		$email = mysqli_real_escape_string($conn,$_POST['email']);
		$newpassword = mysqli_real_escape_string($conn,$_POST['password']);
		$oldpassword = mysqli_real_escape_string($conn,$_POST['oldpassword']);

		$hash_oldpassword = sha1($oldpassword);
		$hash_newpassword = sha1($newpassword);

		$queryemailcheck = "SELECT * FROM user WHERE email='{$email}' AND id={$user_id} AND password='{$hash_oldpassword}' LIMIT 1";

		$resultset1 = mysqli_query($conn, $queryemailcheck);

		if($resultset1){
			if(mysqli_num_rows($resultset1) == 1){
				$queryupdate = "UPDATE user SET password='{$hash_newpassword}' WHERE id='{$user_id}'";

				$resultUpdate = mysqli_query($conn, $queryupdate);

				if($resultUpdate){
					header("Location: users.php?passwordChange=done");
				}else{
					die("Query Faild");
				}
			}else{
				$error[] = "Your Old password Not Match!!!";
				
			}
		} 


	}


 ?>

<body>
	<div class="container">
		<div class="row">
			<h2>Change Password<span><a href="users.php">+View user</a></span></h2>
		</div>
		<div class="row justify-content-center mt-5">
			<div class="col-8">
				<form action="changepassword.php" method="post">	
					<div>
						<?php 
							if(isset($error) && !empty($error)){
								echo "<div class='emailAlert' id='email_alert'>";
									   foreach ($error as $er) {
									    	echo $er;
									    }
									   echo "</div>"; 
							}


						 ?>
						<input type="hidden" name="user_id" value="<?php echo $user_id ?>">
						<label for="email"  class="form-lable">Email</label>
						
						<input <?php echo 'value="' . $email . '"' ?> type="hidden" id="email" name="email" class="form-control input-f">
						

						<input <?php echo 'value="' . $email . '"' ?> type="text" class="form-control input-f" disabled>
						<div class="emailNewAlert" id="email_alert" role="alert">
						</div>
						
					</div>

					<div class="mt-2">
						<label for="oldpassword" class="form-lable col-2">Old password</label>
						<input type="text" id="oldpassword" name="oldpassword" class="form-control input-f"aria-describedby="oldPasswordHelpBlock">
						<div id="oldPasswordHelpBlock" class="form-text"></div>
					</div>

					<div class="mt-2">
						<label for="password" class="form-lable col-2">Password</label>
						<input type="text" id="password" name="password" class="form-control input-f"aria-describedby="passwordHelpBlock">
						<div id="passwordHelpBlock" class="form-text"></div>
					</div>

					<div class="mt-2">
						<label for="confirmpasswordHelpBlock" class="form-lable col-2">Confirm Password</label>
						<input type="text" id="confirmpassword" name="lastname" class="form-control input-f"aria-describedby="confirmpasswordHelpBlock">
						<div id="confirmpasswordHelpBlock" class="form-text"></div>
					</div>

					<div class="mt-4">
						<button class="btn bg-info" id="button" name="submit" type="submit">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<script type="text/javascript">

	</script>

	<script src="js/changepassword.js"></script>
</body>