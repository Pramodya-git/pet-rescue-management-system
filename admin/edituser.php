<?php
session_start();
if(!isset($_SESSION["user"])){
	header("Location: ../log.php");
	exit;
}

$conn = new mysqli("localhost","root","","petrescueandrehome_db");
if($conn->connect_error){
    die("Connection failed: ". $conn->connect_error);
}

//Start Edit Section
$PUser_ID = $_POST['user_id'];
//End Edit Section
if(isset($_POST['submit-check'])){
	$User_name = $_POST['user-name'];
	$Password = $_POST['password'];
	$Confirm_password = $_POST['confirm-password'];
	$Role = $_POST['role'];
	$Email = $_POST['email'];
	$Address = $_POST['address'];
	$Phone = $_POST['phone'];
	 //this section check input details unique or nor
	        $sql = "select * from user where User_Name='$User_name'";
            $res =  $conn->query($sql); 
            $results = $res->fetch_assoc();
	        
            $var = "select * from user where Password='$Password'";
            $res0 =  $conn->query($var); 
            $results0 = $res0->fetch_assoc();
	        
	        $checkEmail = $conn->query("SELECT * FROM user WHERE Email='$Email'");
	        $rsql = $checkEmail->fetch_assoc();
			
            $var1 = "select * from user where Phone='$Phone'";
            $res2 =  $conn->query($var1); 
            $results2 = $res2->fetch_assoc();
			
			if ($results && $results['User_Name'] == $User_name) {
                echo "<script>alert('User Name already exists!');</script>";
            }else if ($results0 && $results0['Password'] == $Password) {
                echo "<script>alert('Password already exists!');</script>";
            }else if ($Password != $Confirm_password) {
                echo "<script>alert('Confirm Password is Wrong!');</script>"; 
	        }else if ($rsql && $rsql['Email']== $Email) {
                echo "<script>alert('Email already exists!');</script>";
            }else if ($results2 && $results2['Phone'] == $Phone) {
                echo "<script>alert('Phone already exists!');</script>";
            }else{
				//This section check your login job role and change your job roal.it's not same automatically you log out.
				if($Role!=$_SESSION["user"]["Role"] and $_SESSION["user"]["UserID"]==$PUser_ID){
			        $query = $conn->query("update user set User_Name='$User_name',Password='$Password',Role='$Role',Email='$Email',Address='$Address',Phone='$Phone' where UserID='$PUser_ID'");
	                if ($query){ 	
	    	            	echo "<script>alert('Warning!You change your login account job role.');</script>";
			                session_destroy();
	                        echo "<script>window.location.href = '../log.php';</script>";
	                }else{
	    	            echo "<script>
	    	                       alert('User Details update Unsuccessfully!');
	    	            		   window.location.href='edituser.php';
	    	                  </script>";
	                      }		
                }else{
			        $query = $conn->query("update user set User_Name='$User_name',Password='$Password',Role='$Role',Email='$Email',Address='$Address',Phone='$Phone' where UserID='$PUser_ID'");
	                if ($query){
	    	            echo "<script>
	    	                    alert('User Details Update Successfully!');
	    	                    window.location.href='user_management.php';  
	    	                  </script>";
	                }else{
	    	            echo "<script>
	    	                       alert('User Details update Unsuccessfully!');
	    	            		   window.location.href='edituser.php';
	    	                  </script>";
	                      }		
		             }
			}
}
							
    
	


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Responsive Admin Dashboard</title>
  <link rel="stylesheet" type="text/css" href="../CSS/add.css" />
</head>
<body>
  <!-- Sidebar -->
  <div class="sidebar">
        <div class="profile">
          <img src="../src/account.png" alt="Profile"><br>
          <h3><?php echo $_SESSION["user"]["Role"]." : ".$_SESSION["user"]["User_Name"]  ?></h3>
          <p><?php echo $_SESSION["user"]["Email"] ?></p>
        </div>
    <button><a href="../logout.php" style="color:white; font-weight:bold; text-decoration:none;">Log Out</a></button>
        <ul>
          <li><a href="admin.php">Dashboard</a></li>
          <li><a href="user_management.php">User Management</a></li>
          <li><a href="pet_management.php">Pet Management</a></li>
          <li><a href="rescue_intake_management.php">Rescue Management</a></li>
          <li><a href="adoption_management.php">Adoption Management</a></li>
		  <li><a href="foster_management.php">Foster Management</a></li>
		  <li><a href="post_adoption_follow_up_management.php">Post Adoption Follow Up</a></li>
        </ul>
  </div>

  <!-- Main Content -->
  <div class="main">
    <!-- Topbar -->
    <div class="topbar">
      <span><h1>🐾 ResQPet</h1></span>
    </div>
	<br />
    <h1>User Management</h1>
	
	<br />  <fieldset><legend>Edit User Details</legend> 
	<br><br>
	        <form method="POST" action="edituser.php">
			<div class="section-one">
                <div class="section">
				    <div>
					    <label for="user-name">User Name :</label><br>
						<input type="text" name="user-name" id="user-name" size="30" Required>
					</div>
					<div><br>
					    <label for="password">New Password :</label><br>
						<input type="password" name="password" id="password" size="30" Required>
					</div>
					<div><br>
					    <label for="address">Address :</label><br>
						<input type="text" name="address" id="address" size="30" Required>
					</div>
					<div><br>
					    <label for="phone">Phone :</label><br>
						<input type="text" name="phone" id="phone" size="30" Required>
					</div>
				</div>
				 <div class="section">
					<div>
					    <label for="role">Role :</label><br>
						<input type="text" name="role" id="role" size="30" placeholder="The first letter must be capitalized." Required>
					</div>
					<div><br>
					    <label for="confirm-password">Confirm Password :</label><br>
						<input type="password" name="confirm-password" id="confirm-password" size="30" Required>
					</div>
					<div><br>
					    <label for="email">Email :</label><br>
						<input type="text" name="email" id="email size="30" Required>
					</div>
					<div><br>
					    <input type="hidden" name="user_id" value="<?php echo $PUser_ID; ?>">
						<input type="submit"  value="Update User Details" size="30" name="submit-check" class="update-button">
					</div>
				</div>
			</div>
	        </form><br><br><br><br><br>
			</fieldset>
    </div>
</body>
</html>
