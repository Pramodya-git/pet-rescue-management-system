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


//Start Add New User Section
if(isset($_POST['submit'])){
	$UserName = $_POST['user-name'];
	$Password = $_POST['password'];
	$Confirm_Password = $_POST['confirm-password'];
	$Role = $_POST['role'];
	$Email = $_POST['email'];
	$Phone = $_POST['phone'];
	$Address = $_POST['address'];
	
	
	        $sql = "select * from user where User_Name='$UserName'";
            $res =  $conn->query($sql); 
            $results = $res->fetch_assoc();
	        
            $var = "select * from user where Password='$Password'";
            $res0 =  $conn->query($var); 
            $results0 = $res0->fetch_assoc();
	        
	        $checkEmail = $conn->query("SELECT * FROM user WHERE Email='$Email'");
	        
            $var1 = "select * from user where Phone='$Phone'";
            $res2 =  $conn->query($var1); 
            $results2 = $res2->fetch_assoc();	
	        if ($results && $results['User_Name'] == $UserName) {
                echo "<script>alert('User Name already exists!');</script>";
            }else if ($results0 && $results0['Password'] == $Password) {
                echo "<script>alert('Password already exists!');</script>";
            }else if ($Password != $Confirm_Password) {
                echo "<script>alert('Confirm Password is Wrong!');</script>";
            }else if ($checkEmail->num_rows > 0) {
                echo "<script>alert('Email already exists!');</script>";
            }else if ($results2 && $results2['Phone'] == $Phone) {
                echo "<script>alert('Phone already exists!');</script>";
            }else {
                // Insert only if no duplicates
                $sql = "INSERT INTO user (User_Name, Password, Role, Email, Address, Phone) 
                        VALUES ('$UserName','$Password','$Role','$Email','$Address','$Phone')";
                $result = $conn->query($sql);
            
                if ($result) {
                    echo "<script>
                              alert('User Added Successfully!');
                              window.location.href='user_management.php';
                          </script>";
                } else {
                    echo "<script>
                              alert('User Added Unsuccessfully!');
                              window.location.href='adduser.php';
                          </script>";
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
	
	<br />  <fieldset><legend>Add New User Section</legend> 
	<br><br>
	        <form method="POST" action="adduser.php" >
			<div class="section-one">
                <div class="section">
				    <div>
					    <label for="user-name">User Name</label><br>
						<input type="text" name="user-name" id="user-name" size="30" Required>
					</div>
					<div><br>
					    <label for="password">Password</label><br>
						<input type="password" name="password" id="password" size="30" Required>
					</div>
					<div><br>
					    <label for="address">Address</label><br>
						<input type="text" name="address" id="address" size="30" Required>
					</div>
					<div><br>
					    <label for="phone">Phone</label><br>
						<input type="text" name="phone" id="phone" size="30" Required>
					</div>
				</div>
				 <div class="section">
				    <div>
					    <label for="role">Role</label><br>
						<input type="text" name="role" id="role" size="30" placeholder="The first letter must be capitalized." Required>
					</div>
					<div><br>
					    <label for="confirm-password">Confirm Password</label><br>
						<input type="password" name="confirm-password" id="confirm-password" size="30" Required>
					</div>
					<div><br>
					    <label for="email">Email</label><br>
						<input type="text" name="email" id="email" size="30" Required>
					</div>
					<div><br><br>
						<input type="submit"  value="Add New User" name="submit" class="update-button" Required>
					</div>
				</div>
			</div>
	        </form><br><br><br><br><br><br><br><br><br>
			</fieldset>
    </div>
</body>
</html>
