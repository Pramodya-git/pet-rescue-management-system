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
//Medical Record Report Generate Section
$sql = "SELECT * FROM medicalrecord";
$result = $conn->query($sql);

// File name
$medicalreport = "medical_report_report.txt";

// Open file
$file = fopen($medicalreport, "w");

// Write header
fwrite($file, "Medical Report\n\n");
fwrite($file, str_pad("RecordID", 10) . str_pad("Date", 20) . str_pad("healthcheck", 20) . str_pad("Vaccinations", 30) . str_pad("Treatments", 30) . str_pad("Surgeries", 30) . str_pad("PetID", 15) . str_pad("VetID", 15) . "\n");
fwrite($file, str_repeat("-", 170) . "\n");

// Write data
if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
    fwrite($file, 
        str_pad($row['RecordID'], 10) .
        str_pad($row['Date'], 20) .
        str_pad($row['healthcheck'], 20) .
        str_pad($row['Vaccinations'], 30) .
        str_pad($row['Treatments'], 30) .
        str_pad($row['Surgeries'], 30) .
        str_pad($row['PetID'], 15) .
		str_pad($row['VetID'], 15) .
		"\n"
    );}
}else{
    fwrite($file, "No Records Found\n");
}

fclose($file);

//Adoption Process Report Generate Section
$sql = "SELECT * FROM adoption_process ";
$result = $conn->query($sql);

// File name
$filename = "adoption_process_report.txt";

// Open file
$file = fopen($filename, "w");

// Write header
fwrite($file, "Adoption Process Report\n\n");
fwrite($file, str_pad("AdoptionID", 10) . str_pad("Payment", 20) . str_pad("AdoptionDate", 20) . str_pad("Meeting_Date", 30) . str_pad("Approval_Status", 30) . str_pad("ApplicationID", 30) . "\n");
fwrite($file, str_repeat("-", 170) . "\n");

// Write data
if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
    fwrite($file, 
        str_pad($row['AdoptionID'], 10) .
        str_pad($row['Payment'], 20) .
        str_pad($row['AdoptionDate'], 20) .
        str_pad($row['Meeting_Date'], 30) .
        str_pad($row['Approval_Status'], 30) .
        str_pad($row['ApplicationID'], 30) .
		"\n"
    );}
}else{
    fwrite($file, "No Records Found\n");
}

fclose($file);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Responsive Admin Dashboard</title>
  <link rel="stylesheet" type="text/css" href="../CSS/admin.css"/>
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
      <span><h1>🐾 ResQPet</h1></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	  <?php echo "<a href='$medicalreport' download style='color:white;border-radius:20px;padding:10px 40px;background: linear-gradient(to right, #667eea, #764ba2);'>Medical Report Generate</a>"; ?>
	  <?php echo "<a href='$filename' download style='color:white;border-radius:20px;padding:10px 40px;background: linear-gradient(to right, #667eea, #764ba2);'>Adoption Process Report Generate</a>"; ?>
    </div>
	<br /><br />
    <h1>Dashboard Overview</h1>
	<br /><br />
    <!-- Status Cards -->
    <div class="cards">
      <div class="card"><h2><?php $sql = "select count(PetID) as total_pets from Pets";
                            $result = $conn->query($sql); $total = $result->fetch_assoc(); echo $total['total_pets']; ?></h2><p>🐾Total Pets</p></div>
      <div class="card"><h2><?php $sql = "select count(FosterID) as total_foster from foster";
                            $result = $conn->query($sql); $total = $result->fetch_assoc(); echo $total['total_foster']; ?></h2><p>🏠Adopted Total</p></div>
      <div class="card"><h2><?php $sql = "select count(ApplicationID) as total_application from adoption_application where Status='Pending'";
                            $result = $conn->query($sql); $total = $result->fetch_assoc(); echo $total['total_application']; ?></h2><p>📄Pending Applications</p></div>
      <div class="card"><h2><?php $sql = "select count(UserID) as total_users from user";
                            $result = $conn->query($sql); $total = $result->fetch_assoc(); echo $total['total_users']; ?></h2><p>👤Users</p></div>
    </div>

    <!-- Tables -->
    <div class="tables">
      <div class="table-card"><br>
        <center>
		    <h3>Pending Applications</h3>
        </center>
		<table>
          <tr><th><center>Application ID</center></th><th><center>Date Applied</center></th><th><center>Pet ID</center></th><th><center>Adopter ID</center></th></tr>
		  <?php 
		    $var = "select * from adoption_application where Status='Pending'";
			$feedback = $conn->query($var); 
			while($total = $feedback->fetch_assoc()){
				?>
			        <tr><td><center><?php echo $total["ApplicationID"]?></center></td><td><center><?php echo $total["DateApplied"]?></center></td><td><center><?php echo $total["PetID"]?></center></td><td><center><?php echo $total["AdopterID"]?></center></td></tr>	
				<?php
			}
		  ?>
        </table>
      </div>
      <div class="table-card"><br>
	    <center>
		    <h3>Mediacl Records</h3>
        </center>
		<table>
        <tr><th><center>Record ID</center></th><th><center>Health Check</center></th><th><center>Vaccinations</center></th><th><center>Treatments</center></th>
		<th><center>Surgeries</center></th><th><center>Pet ID</center></th><th><center>Doctor ID</center></th></tr>
		  <?php 
		    $var = "select * from MedicalRecord";
			$feedback = $conn->query($var); 
			while($total = $feedback->fetch_assoc()){
				?>
			        <tr><td><center><?php echo $total["RecordID"]?></center></td><td><center><?php echo $total["healthcheck"]?></center></td><td><center><?php echo $total["Vaccinations"]?></center></td>
					<td><center><?php echo $total["Treatments"]?></center></td><td><center><?php echo $total["Surgeries"]?></center></td><td><center><?php echo $total["PetID"]?></center></td>
					<td><center><?php echo $total["VetID"]?></center></td></tr>	
				<?php
			}
		  ?>
        </table>
      </div>
    </div>
  </div>
</body>
</html>
