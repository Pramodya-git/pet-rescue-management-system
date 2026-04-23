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
$Prescuedby_id = $_POST["rescuedby_id"];
$Psaved_id = $_POST["saved_id"];
$Prescue_id = $_POST["rescue_id"];
//Start Edit Section
if(isset($_POST['submit'])){
	$rescued_by = $_POST['rescued-by'];
	$Saved = $_POST['saved'];
	$Date = $_POST['date'];
	$Notes = $_POST['notes'];
	$Location = $_POST['location'];
	
	
                // Insert only if no duplicates
                $sql = "update rescue set Date='$Date',Location='$Location',Notes='$Notes',RescuedBy='$rescued_by',Saved='$Saved' where RescueID='$Prescue_id'";
                $result = $conn->query($sql);
            
                if ($result) {
                    echo "<script>
                              alert('Rescue Details Update Successfully!');
                              window.location.href='rescue_intake_management.php';
                          </script>";
                } else {
                    echo "<script>
                              alert('Rescue Details Update Unsuccessfully!');
                              window.location.href='edit_rescue_intake_details.php';
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
    <h1>Rescue Management</h1>
	
	<br />  <fieldset><legend>Edit Rescue Details</legend> 
	<br><br>
	        <form method="POST" action="edit_rescue_intake_details.php">
			<div class="section-one">
                <div class="section">
				    <div>
					    <label for="rescued-by">Rescued By</label><br>
						<input type="text" name="rescued-by" id="rescued-by" size="30" placeholder="<?php echo $Prescuedby_id ?>"Required>
					</div>
					<div><br>
					    <label for="date">Date</label><br>
						<input type="text" name="date" id="date" size="30" Required>
					</div>
					<div><br>
					    <label for="notes">Notes</label><br>
						<input type="text" name="notes" id="notes" size="30" Required>
					</div>
				</div>
				 <div class="section">
				    <div>
					    <label for="saved">Saved</label><br>
						<input type="text" name="saved" id="saved" size="30" placeholder="<?php echo $Psaved_id ?>" Required>
					</div>
					<div><br>
					    <label for="location">Location</label><br>
						<input type="text" name="location" id="location" size="30" Required>
					</div>
					<div><br><br>
					    <input type="hidden" name="rescue_id" value="<?php echo $Prescue_id; ?>">
						<input type="submit"  value="Edit Rescue Details" name="submit" class="update-button" Required>
					</div>
				</div>
			</div>
	        </form><br><br><br><br><br>
			</fieldset>
    </div>
</body>
</html>
