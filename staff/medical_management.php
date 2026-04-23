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
//Search bar empty check
$sea = isset($_POST["earch"]) ? $_POST["earch"] : ''; 


//Start medical record data delete section
if(isset($_POST['delete'])){
	$Precord_id = $_POST['recordid'];
    // Delete pet
    if($conn->query("DELETE FROM MedicalRecord WHERE RecordID = '$Precord_id'")){
        echo "<script>alert('Medical Record Details Delete Successfully');</script>";
        echo "<script>window.location.href = 'medical_management.php';</script>";
    } else {
        echo "<script>alert('Medical Record Details Delete Unsuccessfully');</script>";
		echo "<script>window.location.href = 'medical_management.php';</script>";
    }
}
//End medical record data delete section





?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Responsive Admin Dashboard</title>
  <link rel="stylesheet" type="text/css" href="../CSS/pet_management.css" />
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
	<br /><br />
    <h1>Medical Management</h1>
	<h3><a href="add_new_medical_record.php" class="pet-add-btn">Add New Medical Record</a></h3>
	<br /><br />
    <!--Pet Search Section-->
	<div class="admin-search-filter">
		    <form  method="POST" action="medical_management.php">
                <span class="search-bar">
		        <input type="search" id="admin-pet-search" name="earch" placeholder="Search Medical Record Using Pet Id or Date...">
		        </span>&nbsp;
		        <span class="Search-button">
		        <input type="submit" value="Search" class="search">
		        </span>
            </form>
    </div>
    <!-- Tables -->
    <div class="admin-table-container">
                <table class="admin-table">
                    <thead>
                        <tr>
						    <th><center>Record ID</center></th>
                            <th><center>Doctor ID</center></th>
                            <th><center>Pet ID</center></th>
                            <th><center>Date</center></th>
                            <th><center>Health Check</center></th>
                            <th><center>Vaccinations</center></th>
                            <th><center>Treatments</center></th>
							<th><center>Surgeries</center></th>
                            <th><center>Actions</center></th>
                        </tr>
                    </thead>
                    <tbody id="admin-pets-table" style="height:150px; overflow-y:auto; overflow-x:hidden;">
					<?php                   
                        //Search bar variable
                        if($sea){
							$rch = "select * from MedicalRecord where PetID='$sea' or Date='$sea'";
							$resc =  $conn->query($rch);
									if($resc->num_rows > 0){
										while($ret = $resc->fetch_assoc()){
												?>
												<tr>  
												      <td><center><?php echo $ret["RecordID"] ?></center></td>
						                              <td><center><?php echo $ret["VetID"] ?></center></td>
							                          <td><center><?php echo $ret["PetID"] ?></center></td>
							                          <td><center><?php echo $ret["Date"] ?></center></td>
							                          <td><center><?php echo $ret["healthcheck"] ?></center></td>
							                          <td><center><?php echo $ret["Vaccinations"] ?></center></td>
							                          <td><center><?php echo $ret["Treatments"] ?></center></td>
													  <td><center><?php echo $ret["Surgeries"] ?></center></td>
							                          <td><center>
																<form method="POST" action="medical_management.php" style="display:inline;">
																	<input type="hidden" name="recordid" value="<?php echo $ret['RecordID']; ?>">
																    <input type="submit" name="delete" style="padding:4px;background-color:#60a5fa;border-color:#60a5fa;border-radius:10px;" value="Remove <?php echo $ret['RecordID']; ?>">&nbsp;&nbsp;&nbsp;
															    </form>
                                                                <form method="POST" action="edit_medical_record.php" style="display:inline;">
																	<input type="hidden" name="recordID" value="<?php echo $ret['RecordID']; ?>">
																	<input type="hidden" name="vetID" value="<?php echo $ret["VetID"]; ?>">
																	<input type="hidden" name="petID" value="<?php echo $ret["PetID"]; ?>">
																	<input type="hidden" name="date" value="<?php echo $ret["Date"]; ?>">
																	<input type="hidden" name="healthcheck" value="<?php echo $ret["healthcheck"]; ?>">
																	<input type="hidden" name="vaccinations" value="<?php echo $ret["Vaccinations"]; ?>">
																	<input type="hidden" name="treatments" value="<?php echo $ret["Treatments"]; ?>">
																	<input type="hidden" name="surgeries" value="<?php echo $ret["Surgeries"]; ?>">
																	<input type="submit" name="edit" style="padding:4px;background-color:#60a5fa;border-color:#60a5fa;border-radius:10px;" value="Edit <?php echo $ret['RecordID']; ?>">
															    </form>        
							                              </center>
							                          </td>
						                        </tr>
												<?php
										}
									}else{
										echo "<script>document.getElementById('admin-pet-search').style.borderColor='red';</script>";
									}
                                }
                                                 ?>	
                    </tbody>
                </table>
    </div>
  </div>
</body>
</html>
