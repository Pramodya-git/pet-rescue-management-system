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


//Start Add New Pet Section
if(isset($_POST['submit'])){
	$PetType = $_POST['pet-type'];
	$Bread = $_POST['bread'];
	$Gender = $_POST['gender'];
	$Behavior = $_POST['behavior'];
	$Age = $_POST['age'];
	$Story = $_POST['story'];
	$Status = $_POST['status'];
	
	$file_name = $_FILES['photo']['name'];
	$tempname = $_FILES['photo']['tmp_name'];
	$folder = '../admin/Test Image/'.$file_name;
	
            $query = mysqli_query($conn,"insert into Pets (Pet_Type, Bread, Age, Gender, Status, Behavior, Story, Photo) values ('$PetType', '$Bread', '$Age', '$Gender', '$Status', '$Behavior', '$Story', '$file_name')");
	        if (move_uploaded_file($tempname,$folder)){
	    	    echo "<script>
	    	            alert('Pet Added Successfully!');
	    	            window.location.href='pet_management.php';  
	    	          </script>";
	        }else{
	    	    echo "<script>
	    	               alert('Pet Added Unsuccessfully!');
	    	    		   window.location.href='add.php';
	    	          </script>";
	             }		
        }
	
	

//End Add New Pet Section

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Responsive Admin Dashboard</title>
  <link rel="stylesheet" type="text/css" href="add.css" />
</head>
<body>
  <!-- Sidebar -->
  <div class="sidebar">
        <div class="profile">
          <img src="../src/account.png" alt="Profile"><br>
          <h3><?php echo $_SESSION["user"]["Role"]." : ".$_SESSION["user"]["User_Name"]  ?></h3>
          <p><?php echo $_SESSION["user"]["Email"] ?></p>
		  <span>User ID:<?php echo $_SESSION["user"]["UserID"] ?></span>
        </div>
    <button><a href="../logout.php" style="color:white; font-weight:bold; text-decoration:none;">Log Out</a></button>
        <ul>
          <li><a href="staffadmin.php">Dashboard</a></li>
          <li><a href="notifications.php">Notification</a></li>
	      <li><a href="pet_management.php">Pet Management</a></li>
          <li><a href="petintake.php">Rescue Intake</a></li>
	      <li><a href="medical_management.php">Medical Management</a></li>
          <li><a href="adoption_approved_details.php">Adoption Approved Details</a></li>
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
    <h1>Pet Management</h1>
	
	<br />  <fieldset><legend>Add New Pet Section</legend> 
	<br><br>
	        <form method="POST" action="add.php" enctype="multipart/form-data">
			<div class="section-one">
                <div class="section">
				    <div>
					    <label for="pet-type">Pet Type</label><br>
						<input type="text" name="pet-type" id="pet-type" size="30" Required>
					</div>
					<div><br>
					    <label for="bread">Breed</label><br>
						<input type="text" name="bread" id="bread" size="30" Required>
					</div>
					<div><br>
					    <label for="gender">Gender</label><br>
						<input type="text" name="gender" id="gender" size="30" Required>
					</div>
					<div><br>
					    <label for="photo">Photo</label><br>
						<input type="file" name="photo" id="photo" >
					</div><br><br><br>
				</div>
				 <div class="section">
					<div><br>
					    <label for="behavior">Behavior</label><br>
						<input type="text" name="behavior" id="behavior" size="30" Required> 
					</div>
					<div><br>
					    <label for="age">Age</label><br>
						<input type="text" name="age" id="age" size="30" Required>
					</div>
					<div><br>
					    <label for="status">Status</label><br>
						<input type="text" name="status" id="status" size="30" Required>
					</div>
					<div><br>
					    <label for="story">Story</label><br>
						<input type="text" name="story" id="story" size="30" Required>
					</div>
					<div><br><br>
						<input type="submit"  value="Add New Pet" size="30" name="submit" class="update-button">
					</div>
				</div>
			</div>
	        </form><br><br><br><br>
			</fieldset>
    </div>
</body>
</html>
