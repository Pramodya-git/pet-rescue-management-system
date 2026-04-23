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


//Start Add New Rescue Intake Section
if(isset($_POST['submit'])){
	$Location = $_POST['location'];
	$Rescueby = $_POST['rescueby'];
	$Notes = $_POST['notes'];
	$Date= $_POST['date'];
	$Saved = $_POST['saved'];

	
	        $sql = "select * from rescue where Saved ='$Saved'";
            $res =  $conn->query($sql); 
            $results = $res->fetch_assoc();	
	
                // Insert only if no duplicates
                $sql = "INSERT INTO rescue (Date,Location,Notes,RescuedBy,Saved) 
                        VALUES ('$Date','$Location','$Notes','$Rescueby','$Saved')";
                $result = $conn->query($sql);
                if ($result) {
                    echo "<script>
                              alert('Rescue Intake Added Successfully!');
                              window.location.href='petintake.php';
                          </script>";
                } else {
                    echo "<script>
                              alert('Rescue Intake Added Unsuccessfully!');
                              window.location.href='add_new_rescue_intake.php';
                          </script>";
                }
            	
		
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Responsive Admin Dashboard</title>
  <link rel="stylesheet" type="text/css" href="add_new_rescue_intake.css" />
</head>
<body>
  <!-- Sidebar -->
  <div class="sidebar">
        <div class="profile">
          <img src="src/account.png" alt="Profile"><br>
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
    <h1>Rescue Intake</h1>
	
	<br />  <fieldset><legend>Add New Rescue Detalis</legend> 
	<br><br>
	        <form method="POST" action="add_new_rescue_intake.php" >
			<div class="section-one">
                <div class="section">
					<div><br>
					    <label for="rescueby">Rescued By</label><br>
						<input type="text" name="rescueby" id="rescueby" size="30" Required>
					</div>
					<div><br>
					    <label for="location">Location</label><br>
						<input type="text" name="location" id="location" size="30" Required>
					</div>
					<div><br>
					    <label for="notes">Notes</label><br>
						<input type="text" name="notes" id="notes" size="30" Required>
					</div>
					<br>
				</div>
				 <div class="section">
				    <div>
					    <label for="saved">Saved</label><br>
						<input type="text" name="saved" id="saved" size="30" Required>
					</div><br>
					<div>
					    <label for="date">Date</label><br>
						<input type="text" name="date" id="date" size="30" Required>
					</div>
					<div><br><br>
						<input type="submit"  value="Add New Rescue Details" name="submit" class="update-button">
					</div>
				</div>
			</div>
	        </form><br><br><br><br><br><br><br><br><br><br><br>
			</fieldset>
    </div>
</body>
</html>
