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
			die("Faild");

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
		$firstname = mysqli_real_escape_string($conn,$_POST['firstname']);
		$lastname = mysqli_real_escape_string($conn,$_POST['lastname']);
		$email = mysqli_real_escape_string($conn,$_POST['email']);

		$queryemailcheck = "SELECT * FROM user WHERE email='{$email}' AND id !={$user_id}";

		$resultset1 = mysqli_query($conn, $queryemailcheck);

		if($resultset1){
			if(mysqli_num_rows($resultset1) == 1){
				$error[] = "Email already exit";
			}else{
				$queryupdate = "UPDATE user SET first_name='{$firstname}' , last_name='{$lastname}' , email='{$email}' WHERE id='{$user_id}'";

				$resultUpdate = mysqli_query($conn, $queryupdate);

				if($resultUpdate){
					header("Location: users.php?userupdate=done");
				}else{

				}
			}
		} 


	}


 ?>

<body>
	<div class="container">
		<div class="row">
			<h2>Edit User<span><a href="users.php">+View user</a></span></h2>
		</div>
		<div class="row justify-content-center mt-5">
			<div class="col-8">
				<form action="edituser.php" method="post">	
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
						<input <?php echo 'value="' . $email . '"' ?> type="text" id="email" name="email" class="form-control input-f ">
						<div class="emailNewAlert" id="email_alert" role="alert">
						</div>
					</div>
					<div class="mt-2">
						<label for="firstname" class="form-lable">First Name</label>
						<input  <?php echo 'value="' . $firstname . '"' ?> type="text" id="firstname" name="firstname" class="form-control input-f" aria-describedby="firstnameHelpBlock">
						<div id="firstnameHelpBlock"  class=" firstnameHelpBlock form-text">
						  
						</div>
					</div>
					<div class="mt-2">
						<label for="last_name" class="form-lable">Last Name</label>
						<input <?php echo 'value="' . $lastname . '"' ?> type="text" id="last_name" name="lastname" class="form-control input-f"aria-describedby="lasnameHelpBlock">
						<div id="lasnameHelpBlock" class="form-text">
							
						</div>
					</div>
					<div class="mt-2">
						<label for="password" class="form-lable col-12 col-md-2">Password</label>
						<a href="changepassword.php?userid=<?php echo $user_id ?>">Change password</a>
					</div>
					<div class="mt-3">
						<button class="btn bg-info" id="button" name="submit" type="submit">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<script src="js/edituser.js">
		
	</script>

	
</body>