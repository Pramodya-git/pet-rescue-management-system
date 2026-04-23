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


//Start Add New post Adoption follow up Section
if(isset($_POST['submit'])){
	$Reminder_date = $_POST['reminder-date'];
	$Updates = $_POST['updates'];
	$Feedback = $_POST['feedback'];
	$Adoption_id = $_POST['adoption-id'];
	
	
    $sql = "insert into Post_Adoption_Follow_Up (Reminder_Date,Updates,Feedback,AdoptionID)values('$Reminder_date','$Updates','$Feedback','$Adoption_id')";
	$result = $conn->query($sql);
	if($result){
		echo "<script>alert('Post Adoption Follow Up Details Added Successfully');
		              window.location.href='post_adoption_follow_up_management.php';
			  </script>";
	}else{
		echo "<script>alert('Post Adoption Follow Up Details Add Unsuccessfully');
		              window.location.href='Add_New_Post_Adoption_Follow_Up.php';
			  </script>";
	}
}	
	

//End Add New post Adoption follow up Section

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
    <h1>Post Adoption Follow Up</h1>
	
	<br />  <fieldset><legend>Add New Post Adoption Follow Up Details Section</legend> 
	<br><br>
	        <form method="POST" action="Add_New_Post_Adoption_Follow_Up.php">
			<div class="section-one">
                <div class="section">
				    <br>
					<div>
					    <label for="reminder-date">Reminder Date</label><br>
						<input type="text" name="reminder-date" id="reminder-date" size="30" Required>
					</div>
					<div><br>
					    <label for="updates">Updates</label><br>
						<input type="text" name="updates" id="updates" size="30" Required>
					</div>
				</div>
				 <div class="section"><br><br><br><br>
					<div><br>
					    <label for="feedback">Feedback</label><br>
						<input type="text" name="feedback" id="feedback" size="30"> 
					</div>
					<div><br>
					    <label for="adoption-id">Adoption ID</label><br>
						<input type="text" name="adoption-id" id="adoption-id" size="30" Required>
					</div>
					<div><br><br>
						<input type="submit"  value="Add New Post Follow Up Details" size="30" name="submit" class="update-button">
					</div>
				</div>
			</div>
	        </form><br><br><br><br><br><br><br><br>
			</fieldset>
    </div>
</body>
</html>
