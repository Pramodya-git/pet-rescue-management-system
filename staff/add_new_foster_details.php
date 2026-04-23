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


//Start Add New Foster Section
if(isset($_POST['submit'])){
	$Start_date = $_POST['start-date'];
	$End_date = $_POST['end-date'];
	$Address = $_POST['address'];
	$Caregiver_id = $_POST['caregiver-id'];
	$Pet_id = $_POST['pet-id'];
	
    $sql = "insert into Foster (StartDate,EndDate,Address,PetID,CaregiverID)values('$Start_date','$End_date','$Address','$Pet_id','$Caregiver_id')";
	$result = $conn->query($sql);
	if($result){
		echo "<script>alert('Foster Details Added Successfully');
		              window.location.href='foster_management.php';
			  </script>";
	}else{
		echo "<script>alert('Foster Details Add Unsuccessfully');
		              window.location.href='add_new_foster_details.php';
			  </script>";
	}
}	
	

//End Add New Foster Section

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
    <h1>Foster Management</h1>
	
	<br />  <fieldset><legend>Add New Foster Details Section</legend> 
	<br><br>
	        <form method="POST" action="add_new_foster_details.php">
			<div class="section-one">
                <div class="section">
				    <br>
					<div>
					    <label for="start-date">Start Date</label><br>
						<input type="text" name="start-date" id="start-date" size="30" Required>
					</div>
					<div><br>
					    <label for="address">Address</label><br>
						<input type="text" name="address" id="address" size="30" Required>
					</div>
					<div><br>
					    <label for="pet-id">Pet ID</label><br>
						<input type="text" name="pet-id" id="pet-id" size="30" Required>
					</div>
				</div>
				 <div class="section">
					<div><br>
					    <label for="end-date">End Date</label><br>
						<input type="text" name="end-date" id="end-date" size="30"> 
					</div>
					<div><br>
					    <label for="caregiver-id">Caregiver ID</label><br>
						<input type="text" name="caregiver-id" id="caregiver-id" size="30" Required>
					</div>
					<div><br><br>
						<input type="submit"  value="Add New Foster Details " size="30" name="submit" class="update-button">
					</div>
				</div>
			</div>
	        </form><br><br><br><br><br><br><br><br><br><br><br><br>
			</fieldset>
    </div>
</body>
</html>
