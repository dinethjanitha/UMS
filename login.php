<?php require_once("inc/connection.php"); ?>
<?php session_start() ?>
<?php 
	

	$error = array();

	if(isset($_POST['submit'])){

		 if(!isset($_POST['email']) || strlen(trim($_POST['email'])) < 1) {

		 	$error[] = 'Invalid email or miss';
		 }

		 if(!isset($_POST['password']) || strlen(trim($_POST['password'])) < 1 ) {
		 	$error[] = "Invalid password or miss";
		 }

		 if(empty($error)){
		 	$email = mysqli_real_escape_string($conn, $_POST['email']);
		 	$password = mysqli_real_escape_string($conn, $_POST['password']);

		 	$hash_password = sha1($password);

			$query = "SELECT id,first_name,email,password FROM user
				  WHERE email='{$email}' AND password='{$hash_password}'
				  LIMIT 1";

			$result_set = mysqli_query($conn , $query);		  

			if($result_set){
		 		if(mysqli_num_rows($result_set) == 1){
		 			
		 			$user = mysqli_fetch_assoc($result_set);
		 			echo "<pre>";
		 			echo print_r($user);
		 			echo "</pre>";
		 			$_SESSION['user_id'] = $user['id'];
		 			$_SESSION['first_name'] = $user["first_name"]; 

		 			//updating last login

		 			$query2 = "UPDATE user SET last_login= NOW()
		 					  WHERE id={$user['id']}";

		 			$result_set2 = mysqli_query($conn,$query2);

		 			if(!$result_set2){
		 				die("Database query faild!");
		 			}		  
		 			
		 			header('Location: users.php');
		 		}else{
		 			$error[] = "username or password Invalid";
		 		}
			}else{
				$error[] = "Query Error";
			}

		}
	}	
		 		
		

		



 ?>



<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login</title>
	<link rel="stylesheet" href="css/login.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
</head>
<body >
	<div class="container" id="body">
		<div class="form">
			<div class="form-con">
				<h2>Login</h2>
				<form action="login.php" method="post">
					<div id="loginfail">
						<?php 
							$loginmessage = "<div'>";
			 	    		$loginmessage .= "<div class='message'>";
							$loginmessage .= "<p>Login Fail</p>";
							$loginmessage .= "</div>"	;

							if(isset($error) && !empty($error)){
								echo $loginmessage;
							}

					 	?>

					 	<?php 
					 		if(isset($_GET['logout'])){
					 			$loginoutmessage = "<div'>";
				 	    		$loginoutmessage .= "<div class='logout-m'";
								$loginoutmessage .= "<p>Logout Successfully!</p>";
								$loginoutmessage .= "</div>"	;

								echo $loginoutmessage;
					 		}


					 	 ?>
					</div>
					<div class="label">
						<label>Email</label>
					</div>
					<div class="field">
						<input name="email" id="email" type="text" onchange="">
					</div>
					<div id="result-em">
						<p id="result"></p>
					</div>
					<div class="label">
						<label>Password</label>
					</div>
					
					<div class="field">
						<input type="text" name="password">
					</div>
					<div class="forget-link">
						<a href="#">Forget Password</a>
					</div>
					<div>
						<button type="submit" disabled id="button" name="submit">Login</button>
					</div>
					<div class="forget-link">
						For Signup Click Here <a href="#">Signup</a>
					</div>
					<div class="mee">
						<p id="hehe">DON'T CLICK ME</p>
					</div>
				</form>
			</div>
		</div>
	</div>

	<script type="text/javascript">
		// document.getElementById("email").addEventListener("change" ,myfunc);

		// function myfunc(){
		// 	var $email = document.getElementById("email").value;
		// 	console.log($email)

		// }

		const validateEmail = (email) => {
		  return email.match(
		    /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
		  );
		};

		const validate = () => {
		  const $result = $('#result');
		  const email = $('#email').val();

		  const btn = $("#button")
		  $result.text('');

		  if(validateEmail(email)){
		    $result.text(email + ' is valid.');
		    $result.css('color', 'white');
		    $result.css('background-color', 'green');
		    $result.css('padding', '10px');
		   	btn.prop("disabled", false)
		   	// $("#result").delay(5000).fadeOut(1000);

		    $("#result-em").fadeOut(3000);


		  } else{
		    $result.text('Invalid Email.');
		    $result.css('color', 'white');
		    $result.css('background-color', 'gray');
		    $result.css('padding', '10px');
		    btn.prop("disabled", true)
		    $("#result-em").fadeIn();
		    

		  }
		  return false;

		  const hidefun = () => {
		  	$("#body").hide()
		  }
 		}


$("#hehe").click(function(){$("body").hide();})		
$("#loginfail").fadeOut(4000);
$('#email').on('input', validate);


	</script>

	<!-- <script>
		$(document).ready(function(){
		  $("#hehe").click(function(){
		    $(this).hide();
		  });
		});
	</script> -->

	</script>
	<script>
	    $(document).ready(function() {
	        
	    });
	</script>
</body>
</html>

<?php mysqli_close($conn); ?>