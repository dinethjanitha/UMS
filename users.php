<?php require_once("inc/connection.php"); ?>
<?php session_start() ?>

<?php 

	$users = '';

	if(!isset($_SESSION['user_id'])){
		header("Location: login.php");
	}

	if (isset($_POST['submit'])) {
	 	$search = mysqli_real_escape_string($conn,$_POST['search']);

	 	if(!$search == ""){
	 		$query = "SELECT * FROM user WHERE (first_name LIKE '%{$search}%' OR last_name LIKE '%{$search}%' OR email LIKE '%{$search}%') AND is_deleted=0";
	 	}else{
	 		header("Location: users.php?input=empty");
	 	}

	 	
 	}else{
 		$query = "SELECT id,first_name,last_name,last_login
			  FROM user
			  WHERE is_deleted = 0
			  ORDER BY id"; 
 	}

	$result_set = mysqli_query($conn,$query);

	if($result_set){
		if(mysqli_num_rows($result_set) == 0){
			header("Location: users.php?err=users not found!");
		}else{
			while ($user = mysqli_fetch_assoc($result_set)) {
				$users .= "<tr>";
				$users .= "<td>{$user['id']}</td>";
				$users .= "<td>{$user['first_name']}</td>";
				$users .= "<td>{$user['last_name']}</td>";
				$users .= "<td>{$user['last_login']}</td>";
				$users .= "<td><a href='edituser.php?userid={$user['id']}'>Edit user</a></td>";
				$users .= "<td><a onclick=\"return confirm('are you sure?')\" href='deleteuser.php?userid={$user['id']}'>Delete user</a></td>";
				$users .= "</tr>";
			}
		}
	}else{
		echo "Database Query fail!";
	}
 ?>

 <?php 




  ?>

 <?php 

 	require_once("inc/nav.php")

  ?>

	<div class="container">
		
		<!-- <pre>
			<?php 

				print_r($_SESSION)
			 ?>
		</pre> -->
		<div class="row userpage d-flex flex-nowrap">
			<div class="col-6 "><h3>User Page<span class="adduserlink"><a href="addusers.php">+Add user</a> </h3></div>
		</div>

		<div class="search">
			<form action="users.php" method="post" class="">
				<?php 
					if(isset($_GET["err"])){
						$mzg = "<div class='user-not-found' mt-4 mb-4 id='user_add'>";
						$mzg .= "Users not found!";
						$mzg .= "</div>";

						echo $mzg;
					}

				 ?>
				<div class="row">
					<div class="col-10">
						<input  type="text" class="form-control" name="search" placeholder="Search User">
					</div>
					<div class="col-2">
						<button type="submit" name="submit" class="btn btn-2 form-control">Search</button>
					</div>
				</div>
			</form>
		</div>



		<div class="row">
			<?php 
				if(isset($_GET["user_add"])){
					$mzg = "<div class='user-added' id='user_add'>";
					$mzg .= "User Added!";
					$mzg .= "</div>";

					echo $mzg;
				}

			 ?>

			 <?php 
				if(isset($_GET["userupdate"])){
					$mzg = "<div class='user-added' id='user_add'>";
					$mzg .= "User Updated!";
					$mzg .= "</div>";

					echo $mzg;
				}


			 ?>
		</div>
		<div class="row">
			<div class="col-12">
				<table class="table">
					<thead>
						<tr>
							<th scope="col">Id</th>
							<th scope="col">First Name</th>
							<th scope="col">Last Name</th>
							<th scope="col">Last Log</th>
							<th scope="col">Edit user</th>
							<th scope="col">Delete user</th>
						</tr>	
					</thead>
					<tbody>
						<?php echo $users; ?>
					</tbody>
				</table>



			</div>
		</div>
	</div>

	<script type="text/javascript">
		$("#user_add").fadeOut(5000);
	</script>








</body>
</html>