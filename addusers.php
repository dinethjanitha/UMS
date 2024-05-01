<?php require_once("inc/connection.php"); ?>
<?php session_start() ?>

<?php 

	if(!isset($_SESSION['user_id'])){
		header("Location: login.php");
	}

	$error = array();

	if(isset($_POST["submit"])){
		$email = mysqli_real_escape_string($conn, $_POST['email']);
		$password = mysqli_real_escape_string($conn, $_POST['password']);
		$firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
		$lastname = mysqli_real_escape_string($conn, $_POST['lastname']);

		$hash_password = sha1($password);

		$queryselect = "SELECT * from user WHERE email='{$email}'";

		$select_result = mysqli_query($conn,$queryselect);

		if($select_result){
			if(mysqli_num_rows($select_result) == 1){
				$error[] = "email Aleary Exit!";
			}else{

				$query = "INSERT INTO user(first_name,last_name,email,password,is_deleted)
					VALUES('{$firstname}','{$lastname}','{$email}','{$hash_password}',0)";

				$insert_result = mysqli_query($conn,$query);
				
				if($insert_result){
					header("Location: users.php?user_add=done");
				}else{
					die("Database Query Faild!");
				}	
			}
		}else{
			die("Database query faild!");
		}
		
	}


 ?>

<?php 




 ?>


<?php require_once("inc/nav.php") ?>

<body>
	<div class="container">
		<div class="row mt-4">
			<h2>Add new user <span><a href="users.php">+ View users</a></span> </h2>
		</div>
		<div class="row justify-content-center mt-5">
			<div class="col-8">
				<form action="addusers.php" method="post">
					<div>
						
							<?php
								if(isset($error) && !empty($error)){
									echo "<div class='emailAlert' id='email_alert'>";
								    echo "Email Aleary Exit!";
								    echo "</div>";
								}


							 ?>
						
						<label for="email"  class="form-lable">Email</label>
						<input value="" type="text" id="email" name="email" class="form-control input-f ">
						<div class="emailNewAlert" id="email_alert" role="alert">
						</div>
					</div>
					<div>
						<label for="firstname" class="form-lable">First Name</label>
						<input  type="text" id="firstname" name="firstname" class="form-control input-f" aria-describedby="firstnameHelpBlock">
						<div id="firstnameHelpBlock"  class=" firstnameHelpBlock form-text">
						  
						</div>
					</div>
					<div>
						<label for="last_name" class="form-lable">Last Name</label>
						<input value="" type="text" id="last_name" name="lastname" class="form-control input-f"aria-describedby="lasnameHelpBlock">
						<div id="lasnameHelpBlock" class="form-text">
							
						</div>
					</div>
					<div>
						<label for="password" class="form-lable">Password</label>
						<input value="" type="text" id="password" class="form-control input-f" name="password" aria-describedby="passwordHelpBlock">
						<div id="passwordHelpBlock"  class="form-text"></div>
					</div>
					<div class="mt-2">
						<button class="btn bg-info" id="button" name="submit" type="submit">Submit</button>
					</div>
				</form>
				
			</div>

		</div>
		<script src="js/adduser.js">
		
	</script>
	</div>
</body>				