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

$RecordID = $_POST['recordID'];
$VetID = $_POST['vetID'];
$PetID = $_POST['petID'];
$Date = $_POST['date'];
$Healthcheck = $_POST['healthcheck'];
$Vaccinations = $_POST['vaccinations'];
$Treatments = $_POST['treatments'];
$Surgeries = $_POST['surgeries'];


//Start update medical record Section
if(isset($_POST['submit'])){
	$PDoctor_ID = $_POST['doctor-ID'];
	$PPet_ID = $_POST['pet-ID'];
	$PDate = $_POST['pdate'];
	$Phealth_Check = $_POST['health-Check'];
	$PVaccinations = $_POST['vaccinations'];
	$PTreatments = $_POST['treatments'];
	$PSurgeries = $_POST['surgeries'];
	
	
        $update_sql = "UPDATE MedicalRecord SET VetID='$PDoctor_ID',PetID='$PPet_ID',Date='$PDate',healthcheck='$Phealth_Check',Vaccinations='$PVaccinations',Treatments='$PTreatments',Surgeries='$PSurgeries' where RecordID='$RecordID'";
    	if($conn->query($update_sql)){	
		    echo "<script>
                alert('Medical Record Updated Successfully!');
                window.location.href='medical_management.php';
              </script>";
        }else{
			echo "<script>
                alert('Medical Record Update Unsuccessfully!');
                window.location.href='edit_medical_record.php';
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
    <h1>Medical Management</h1>
	
	<br />  <fieldset><legend>Edit Medical Record Section</legend> 
	<br><br>
	        <form method="POST" action="edit_medical_record.php" >
			<div class="section-one">
                <div class="section">
				    <div>
					    <label for="doctor-ID">Doctor ID</label><br>
						<input type="text" name="doctor-ID" id="doctor-ID" size="30" placeholder="<?php echo $VetID ?>" Required>
					</div>
					<div><br>
					    <label for="date">Date</label><br>
						<input type="text" name="pdate" id="date" size="30" placeholder="<?php echo $Date ?>" Required>
					</div>
					<div><br>
					    <label for="vaccinations">Vaccinations</label><br>
						<input type="text" name="vaccinations" id="vaccinations" size="30" placeholder="<?php echo $Vaccinations ?>" Required>
					</div>
					<div><br>
					    <label for="surgeries">Surgeries</label><br>
						<input type="text" name="surgeries" id="surgeries" size="30" placeholder="<?php echo $Surgeries ?>" Required>
					</div>
				</div>
				 <div class="section">
				    <div>
					    <label for="pet-ID">Pet ID</label><br>
						<input type="text" name="pet-ID" id="pet-ID" size="30" placeholder="<?php echo $PetID ?>" Required>
					</div>
					<div><br>
					    <label for="health-Check">Health Check</label><br>
						<input type="text" name="health-Check" id="health-Check" size="30" placeholder="<?php echo $Healthcheck ?>" Required>
					</div>
					<div><br>
					    <label for="treatments">Treatments</label><br>
						<input type="text" name="treatments" id="treatments" size="30" placeholder="<?php echo $Treatments ?>" Required>
					</div>
					<div><br><br>
					    <input type="hidden" name="recordID" value="<?php echo $RecordID; ?>">
						<input type="hidden" name="vetID" value="<?php echo $VetID; ?>">
						<input type="hidden" name="petID" value="<?php echo $PetID; ?>">
						<input type="hidden" name="date" value="<?php echo $Date; ?>">
						<input type="hidden" name="healthcheck" value="<?php echo $Healthcheck; ?>">
						<input type="hidden" name="vaccinations" value="<?php echo $Vaccinations; ?>">
						<input type="hidden" name="treatments" value="<?php echo $Treatments; ?>">
						<input type="hidden" name="surgeries" value="<?php echo $Surgeries; ?>">
						<input type="submit"  value="Edit Medical Record" name="submit" class="update-button" Required>
					</div>
				</div>
			</div>
	        </form><br><br><br><br><br><br><br><br><br>
			</fieldset>
    </div>
</body>
</html>
